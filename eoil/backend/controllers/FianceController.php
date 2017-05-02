<?php

namespace backend\controllers;

use Yii;
use common\models\Wallet;
use common\models\SearchWallet;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\WithdrawRec;
use yii\db\Exception;
use common\models\IncomeRec;
use common\models\User;
use common\models\WxEnterprisePay;
use common\models\Order;
use yii\filters\AccessControl;
use common\models\Orders;

require_once "../../common/WxpayAPI/lib/WxPay.Api.php";
/**
 * FianceController implements the CRUD actions for Wallet model.
 */
class FianceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Wallet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchWallet();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 会员提现申请记录
     */
    public function actionWithdrawRec()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>WithdrawRec::find()->orderBy('created_at desc')
        ]);
    
        return $this->render('withdraw-rec', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * 查看财务详情
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $dataProvider=new ActiveDataProvider([
            'query'=>IncomeRec::find()->andWhere(['user_guid'=>$model->user_guid])->orderBy('created_at desc')
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider
        ]);
    }
    
    /**
     * 查看记录详情
     */
    public function actionViewIncomeRec($id)
    {
        $model=IncomeRec::findOne(['id'=>$id]);
        return $this->render('view-income-rec', [
            'model' => $model,
        ]);
    }
    
    public function actionPayMoney($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $user=User::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
        
        $input = new \WxPayEnterprisePay();
        $input->SetPartner_trade_no(Orders::getOrderNO());
        $input->SetOpenid($user->openid);
        $input->SetCheck_name('OPTION_CHECK');
        $input->SetRe_user_name($user->name);
        $input->SetAmount($withDrawRec->amount*100);
//         $input->SetAmount(100);
        $input->SetDesc("清友茶业代理商提现");
        $result=\WxPayApi::enterprisePay($input,2000);
        if($result['return_code']=='SUCCESS'&&$result['result_code']=="SUCCESS"){
        
            $trans=yii::$app->db->beginTransaction();
            try{
                $wxEnterprise=new WxEnterprisePay();
                $wxEnterprise->user_guid=$user->user_guid;
                $wxEnterprise->openid=$user->openid;
                $wxEnterprise->partner_trade_no=$result['partner_trade_no'];
                $wxEnterprise->payment_no=$result['payment_no'];
                $wxEnterprise->payment_time=$result['payment_time'];
                $wxEnterprise->created_at=time();
                if(!$wxEnterprise->save()) throw new Exception('更新退款记录失败');
                
                $wallet->paid +=$withDrawRec->amount;
                $wallet->withdrawing -=$withDrawRec->amount;
                $wallet->updated_at=time();
                if(!$wallet->save()) throw new Exception('');
                $withDrawRec->status=2;
                $withDrawRec->updated_at=time();
                if (!$withDrawRec->save()) throw new Exception('');
                $trans->commit();
                yii::$app->getSession()->setFlash('success','付款成功!');
            }catch (Exception $e){
                $trans->rollBack();
                yii::$app->getSession()->setFlash('error','付款失败，数据库错误!');
            }
        }else {
            yii::$app->getSession()->setFlash('error','付款失败!'.$result['return_msg']);
         
        }
        
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionAlipayMoney($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $user=User::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
    }
    
    public function actionRefuse($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $trans=yii::$app->db->beginTransaction();
        try{
            $wallet->balance +=$withDrawRec->amount;
            $wallet->withdrawing -=$withDrawRec->amount;
            $wallet->updated_at=time();
            if(!$wallet->save()) throw new Exception('');
            $withDrawRec->status=99;
            $withDrawRec->updated_at=time();
            if (!$withDrawRec->save()) throw new Exception('');
            $trans->commit();
            yii::$app->getSession()->setFlash('success','驳回成功!');
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','驳回失败!');
        }
    
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionBankPay($id){
        $withDrawRec=WithdrawRec::findOne($id);
        $wallet=Wallet::findOne(['user_guid'=>$withDrawRec->user_guid]);
        $trans=yii::$app->db->beginTransaction();
        try{
            $wallet->paid +=$withDrawRec->amount;
            $wallet->withdrawing -=$withDrawRec->amount;
            $wallet->updated_at=time();
            if(!$wallet->save()) throw new Exception('');
            $withDrawRec->status=2;
            $withDrawRec->updated_at=time();
            if (!$withDrawRec->save()) throw new Exception('');
            $trans->commit();
            yii::$app->getSession()->setFlash('success','付款成功!');
        }catch (Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','付款失败!');
        }
    
        return $this->redirect(yii::$app->request->referrer);
    }
    
    

    /**
     * Creates a new Wallet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wallet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wallet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Wallet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Wallet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wallet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
