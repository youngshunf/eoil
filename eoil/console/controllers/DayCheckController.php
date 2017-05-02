<?php
namespace console\controllers;
use yii\console\Controller;
use common\models\IncomeRec;
use yii;
use common\models\CommonUtil;
use common\models\Wallet;
use common\models\SysSet;
use common\models\Orders;

class DayCheckController extends Controller{
    
    public function actionIndex(){
      echo '每天运行时间';
    }
    
    /**
     * 
     * @author youngshunf
     */
    //----------------------------------------------更新用户钱包--------------------------------------------
    public function actionUpdateIncome() {
        $i=0;
        $trans=yii::$app->db->beginTransaction();
        $sysSet=SysSet::find()->one();
      
        try{
            foreach (Orders::find()->andWhere(['status'=>2])->each(10) as $order) {
                $now=time();
                $period=$sysSet->withdraw_deposit;
                $period=3600*24*$period;//履约期限
                if((time()-$order->updated_at)>=$period){
                    $order->status =3;
                    $order->updated_at=time();
                    if(!$order->save()) throw new \Exception('更新订单失败');
                    $i++;
                }
            }
            
            foreach (Orders::find()->andWhere(['status'=>3])->each(10) as $order) {
                $now=time();
                $period=$sysSet->keep_expire;
                $period=3600*24*$period;//申诉期限
                if((time()-$order->updated_at)>=$period){
                    $order->status =4;
                    $order->updated_at=time();
                    if(!$order->save()) throw new \Exception('更新订单失败');
                    $buyerIncome=new IncomeRec();
                    $buyerIncome->user_guid=$order->user_guid;
                    $buyerIncome->orderid=$order->id;
                    $buyerIncome->orderno=$order->orderno;
                    $buyerIncome->number=$order->number;
                    $buyerIncome->refer_goods=$order->goodsid;
                    $buyerIncome->amount=$order->amount;
                    $buyerIncome->status=1;
                    $buyerIncome->remark='保证金退款,订单号:'.$order->orderno.',商品:'.$order->goods_name;
                    $buyerIncome->year=date('Y');
                    $buyerIncome->year_month=date('Ym');
                    $buyerIncome->year_month_day=date('Ymd');
                    $buyerIncome->created_at=time();
                    if(!$buyerIncome->save()) throw new \Exception('更新收入记录失败!');
                     
                    $sellerIncome=new IncomeRec();
                    $sellerIncome->user_guid=$order->seller_user;
                    $sellerIncome->orderid=$order->id;
                    $sellerIncome->orderno=$order->orderno;
                    $sellerIncome->number=$order->number;
                    $sellerIncome->refer_goods=$order->goodsid;
                    $sellerIncome->amount=$order->amount;
                    $sellerIncome->status=1;
                    $sellerIncome->remark='供货保证金退款,订单号:'.$order->orderno.',商品:'.$order->goods_name;
                    $sellerIncome->year=date('Y');
                    $sellerIncome->year_month=date('Ym');
                    $sellerIncome->year_month_day=date('Ymd');
                    $sellerIncome->created_at=time();
                    if(!$sellerIncome->save()) throw new \Exception('更新收入记录失败!');
                    $i++;
                }
            }
            
            foreach (IncomeRec::find()->andWhere(['status'=>1])->each(10) as $incomeRec) {
                $now=time();
                $period=3600*24*7;
                if((time()-$incomeRec->created_at)>=$period){
                    
                   $incomeRec->status=2;
                   $incomeRec->updated_at=time();
                   IncomeRec::updateAll(['status'=>2,'updated_at'=>time()],['id'=>$incomeRec->id]);
                   if(!$incomeRec->save()) throw new \Exception('更新收入记录失败!');
                   $wallet=Wallet::findOne(['user_guid'=>$incomeRec->user_guid]);
                   $wallet->balance +=$incomeRec->amount;
                   $wallet->frozen -=$incomeRec->amount;
                   if(!$wallet->save()) throw new \Exception('更新钱包失败');
                   $i++;
                }
            }
            $trans->commit();
            echo CommonUtil::LogMsg("更新收入记录成功！本次共更新 $i 条记录");
        }catch (\yii\db\Exception $e){
            $trans->rollBack();
            echo CommonUtil::LogMsg("更新钱包状态失败！");
        }
    
    }
    
    //----------------------------------------------检查订单--------------------------------------------
    public function actionCheckOrder() {
        $i=0;
        $trans=yii::$app->db->beginTransaction();
        $sysSet=SysSet::find()->one();
        
        try{
            foreach (Orders::find()->andWhere(['status'=>[0,1]])->each(10) as $order) {
                $now=time();
                $period=1800;
                if((time()-$order->updated_at)>=$period){
                    $order->status =98;
                    $order->updated_at=time();
                    if(!$order->save()) throw new \Exception('更新订单失败');
                    $i++;
                }
            }
            
            $trans->commit();
            echo CommonUtil::LogMsg("更新订单状态成功！本次共更新 $i 条记录");
        }catch (\yii\db\Exception $e){
            $trans->rollBack();
            echo CommonUtil::LogMsg("更新订单状态失败！");
        }
    
    }  
   
       
      
    
   
    
     
}