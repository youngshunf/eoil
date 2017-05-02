<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\UserRelation;
use common\models\CommonUtil;
use backend\models\AdminUser;
use common\models\UserJudge;
use common\models\UserData;
use common\models\UserAuth;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionAuth()
    {
        $userType=1;
        if(isset($_GET['userType'])){
            $userType=$_GET['userType'];
        }
        $dataProvider = new ActiveDataProvider([
            'query'=>UserAuth::find()->andWhere(['user_type'=>$userType])->orderBy('created_at desc')
        ]);
    
        return $this->render('auth', [
            'dataProvider' => $dataProvider,
            'userType'=>$userType
        ]);
    }
    
    public function actionAuthPass($id){
        $userAuth=UserAuth::findOne($id);
        $userAuth->auth_result=1;
        $userAuth->save();
        $user=User::findOne(['user_guid'=>$userAuth->user_guid]);
        $user->is_auth=1;
        $user->user_type=$userAuth->user_type;
        $user->updated_at=time();
        $user->save();
        yii::$app->getSession()->setFlash('success','用户审核通过!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionAuthDeny($id){
        $userAuth=UserAuth::findOne($id);
        $userAuth->auth_result=2;
        $userAuth->save();
        yii::$app->getSession()->setFlash('success','操作成功,用户审核未通过!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function  actionViewAuth($id){
        $model=UserAuth::findOne($id);
        return $this->render('view-auth',['model'=>$model]);
    }
    
    public function  actionJudge($id){
        $model=User::findOne(['id'=>$id]);
        return  $this->render('judge',[
            'model'=>$model,
            'action'=>'new'
        ]);
    }
    
   
    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionAdmin()
    {
     
        $dataProvider = new ActiveDataProvider([
            'query'=>AdminUser::find()->orderBy('created_at desc')
        ]);
    
        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
    
    public function actionExportAgent(){
        if(empty($_POST['startTime'])||empty($_POST['endTime'])){
             
            $model=User::find()->andWhere(['is_agent'=>1])->orderBy('created_at desc')->all();
        }else{
            $startTime=strtotime($_POST['startTime']);
            $endTime=strtotime($_POST['endTime']);
            if($endTime<$startTime){
                yii::$app->getSession()->setFlash('error','结束时间不能小于开始时间');
                return $this->redirect(yii::$app->getRequest()->referrer);
            }
            $model=User::find()->andWhere(['is_agent'=>1])->andWhere(" created_at >$startTime and created_at <=$endTime")->orderBy("created_at desc")->all();
        }
    
        if(empty($model)){
            yii::$app->getSession()->setFlash('error','该时间段没有数据');
            return $this->redirect(yii::$app->getRequest()->referrer);
        }
    
        $resultExcel=new \PHPExcel();
        $resultExcel->getActiveSheet()->setCellValue('A1','序号');
        $resultExcel->getActiveSheet()->setCellValue('B1','姓名');
        $resultExcel->getActiveSheet()->setCellValue('C1','电话');
        $resultExcel->getActiveSheet()->setCellValue('D1','昵称');
        $resultExcel->getActiveSheet()->setCellValue('E1','省份');
        $resultExcel->getActiveSheet()->setCellValue('F1','城市');
        $resultExcel->getActiveSheet()->setCellValue('G1','会员卡号');
        $resultExcel->getActiveSheet()->setCellValue('H1','身份证号');
        $resultExcel->getActiveSheet()->setCellValue('I1','用户角色');
        $resultExcel->getActiveSheet()->setCellValue('J1','推荐人');
        $resultExcel->getActiveSheet()->setCellValue('K1','推荐人卡号');
        $resultExcel->getActiveSheet()->setCellValue('L1','推荐人数');
        $resultExcel->getActiveSheet()->setCellValue('M1','注册时间');
         
        $i=2;
        foreach ($model as $k=>$v){
            $resultExcel->getActiveSheet()->setCellValue('A'.$i,$k+1);
            $resultExcel->getActiveSheet()->setCellValue('B'.$i,$v->name);
            $resultExcel->getActiveSheet()->setCellValue('C'.$i,$v->mobile);
            $resultExcel->getActiveSheet()->setCellValue('D'.$i,$v->nick);
            $resultExcel->getActiveSheet()->setCellValue('E'.$i,$v->province);
            $resultExcel->getActiveSheet()->setCellValue('F'.$i,$v->city);
            $resultExcel->getActiveSheet()->setCellValue('G'.$i,$v->card_number);
            $resultExcel->getActiveSheet()->setCellValue('H'.$i,$v->id_code);
            $resultExcel->getActiveSheet()->setCellValue('I'.$i,CommonUtil::getDescByValue('user', 'role_id', $v->role_id));
            $resultExcel->getActiveSheet()->setCellValue('J'.$i,$v->parent_agent_name);
            $resultExcel->getActiveSheet()->setCellValue('K'.$i,$v->parent_agent_card);
            $countUser=UserRelation::find()->andWhere(['parent_user'=>$v->user_guid])->count();
            $resultExcel->getActiveSheet()->setCellValue('L'.$i,$countUser);
            $resultExcel->getActiveSheet()->setCellValue('M'.$i,CommonUtil::fomatTime($v->created_at));
    
            $i++;
        }
         
        //设置导出文件名
        $outputFileName ="代理商导出".date('Y-m-d',time()).'.xls';
        $xlsWriter = new \PHPExcel_Writer_Excel5($resultExcel);
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
    
        $xlsWriter->save( "php://output" );
    
    }
    public function actionCreateAdmin()
    {
        $model = new AdminUser();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post())) {
            $model->user_guid=CommonUtil::createUuid();
            $model->generateAuthKey();
            $model->setPassword($model->password);
            $model->password=md5($model->password);
            $model->password2=md5($model->password2);
            $model->role_id=98;
            $model->created_at=time();
            if($model->save())
                return $this->redirect(['view-admin', 'id' => $model->id]);
        } else {
            return $this->render('create-admin', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateAdmin($id)
    {
        $model =AdminUser::findOne($id);
        unset($model->password);
        if ($model->load(Yii::$app->request->post())) {
            $model->generateAuthKey();
            $model->setPassword($model->password);
            $model->password=md5($model->password);
            $model->password2=md5($model->password2);
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['view-admin', 'id' => $model->id]);
        } else {
            return $this->render('update-admin', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionViewAdmin($id)
    {
        $model = AdminUser::findOne($id);
    
        return $this->render('view-admin', [
            'model' => $model,
        ]);
    
    }
    
    public function actionDeleteAdmin($id)
    {
        AdminUser::findOne($id)->delete();
        yii::$app->getSession()->setFlash('success','删除成功!');
        return $this->redirect(['admin']);
    
    }
    public function actionUnbindUser($id){
        $parentUser=yii::$app->user->identity->user_guid;
        $user=User::findOne($id);
        $trans=yii::$app->db->beginTransaction();
        try{
            $user->id_code='';
            $user->parent_agent_name='';
            $user->parent_agent_card='';
            if(!$user->save()) throw new \Exception('更新用户失败');
            UserRelation::deleteAll(['user_guid'=>$user->user_guid]);
            $trans->commit();
            yii::$app->getSession()->setFlash('success','解绑成功!');
        }catch (\yii\db\Exception $e){
            $trans->rollBack();
            yii::$app->getSession()->setFlash('error','解绑失败!');
        }
        
        return $this->redirect(yii::$app->request->referrer);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
