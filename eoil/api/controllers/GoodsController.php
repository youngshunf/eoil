<?php
namespace api\controllers;

use Yii;
use common\models\User;
use common\models\CommonUtil;
use yii\db\Exception;
use common\models\Answer;
use common\models\Question;
use common\models\AnswerDetail;
use common\models\ImageUploader;
use common\models\GroupUser;
use yii\web\UploadedFile;
use common\models\Goods;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\GeoCoding;
use common\models\GoodsPhoto;
use common\models\GoodsCate;
use common\models\Orders;
use common\models\SysSet;
use common\models\GoodsTemplate;
use common\models\Wallet;
use common\models\IncomeRec;
use common\models\AlipayOrder;
use common\models\Message;
use common\models\Appeal;
use common\models\Comment;
use common\models\AppealPhoto;

require_once "../../common/WxpayAPI/lib/WxPay.Api.php";
require_once "../../common/WxpayAPI/example/WxPay.JsApiPay.php";
require_once '../../common/WxpayAPI/example/log.php';
require_once '../../common/WxpayAPI/example/log.php';

require_once '../../common/alipaysdk/wappay/service/AlipayTradeService.php';
/**
 * app api
 */
class GoodsController extends ActiveController
{
 
    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
    public $modelClass = 'common\models\Goods';
    /**
     * 取消用户提交数据验证
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                #这个地方使用`ComopositeAuth` 混合认证
                'class' => CompositeAuth::className(),
                #`authMethods` 中的每一个元素都应该是 一种 认证方式的类或者一个 配置数组
                'authMethods' => [
                    HttpBasicAuth::className(),
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ]
            ]
        ]);
    }
    
    public function actionIndex(){
    
        print_r(yii::$app->user->identity);
    
    }
    
   public function actionSubmitGoods(){
       $user=yii::$app->user->identity;
       $data=yii::$app->request->post('data');
      
       if(is_string($data)){
           $data=json_decode($data,true);
       }
       $goods=new Goods();
       $goods->user_guid=$user->user_guid;
       $goods->uid=$user->id;
       $goods->name=@$data['name'];
       $goods->price=@$data['price'];
       $goods->stock=@$data['stock'];
       $goods->unit=@$data['unit'];
       //$goods->is_tax=@$data['is_tax'];
       $cate=@$data['cate']['selected'];
       if(!empty($cate[0])){
           $goods->cateid=$cate[0]['value'];
           $goodsCate=GoodsCate::findOne($goods->cateid);
           if(!empty($goodsCate)){
               $goods->is_car=$goodsCate->is_car;
           }
           if(!empty($cate[1])){
               $goods->cateid=$cate[1]['value'];
               $goodsCate=GoodsCate::findOne($goods->cateid);
               if(!empty($goodsCate)){
                   $goods->is_car=$goodsCate->is_car;
               }
           }
           if(!empty($cate[2])){
               $goods->cateid=$cate[2]['value'];
               $goodsCate=GoodsCate::findOne($goods->cateid);
               if(!empty($goodsCate)){
                   $goods->is_car=$goodsCate->is_car;
               }
           }
       }
       $goods->end_time=strtotime(@$data['endTime']);
       $goods->mobile=@$data['mobile'];
       $goods->qq=@$data['qq'];
       $goods->address=@$data['address'];
       $goods->status=1;
       if(!empty($goods->address)){
           $geoCoding=new GeoCoding(yii::$app->params['baiduMapAK']);
           $result=$geoCoding->getLngLatFromAddress(urldecode($goods->address));
           if($result['status']==0){
               $goods->lng=$result['result']['location']['lng'];
               $goods->lat=$result['result']['location']['lat'];
           }
       }
       $goods->desc=@$data['desc'];
       $goods->total_amount=$goods->price*$goods->stock;
       $goods->created_at=time();
       if($goods->save()){
           foreach ($data['imgs'] as $v){
               $photo=ImageUploader::uploadImageByBase64($v);
               if($photo){
                   $goodsPhoto=new GoodsPhoto();
                   $goodsPhoto->user_guid=$user->user_guid;
                   $goodsPhoto->uid=$user->id;
                   $goodsPhoto->goodsid=$goods->id;
                   $goodsPhoto->path=$photo['path'];
                   $goodsPhoto->photo=$photo['photo'];
                   $goodsPhoto->created_at=time();
                   $goodsPhoto->save();
               }
           }
           if(@$data['action']=='template'){
               if(!empty($data['photos'])){
                   foreach ($data['photos'] as $item){
                       $goodsPhoto=new GoodsPhoto();
                       $goodsPhoto->user_guid=$user->user_guid;
                       $goodsPhoto->uid=$user->id;
                       $goodsPhoto->goodsid=$goods->id;
                       $goodsPhoto->path=$item['path'];
                       $goodsPhoto->photo=$item['photo'];
                       $goodsPhoto->created_at=time();
                       $goodsPhoto->save();
                   }
               }
           }
           CommonUtil::calScore('publish_goods', $user->user_guid);
           return CommonUtil::success($goods->id);
       }
       
       return CommonUtil::error('e1002');
       
   }
   
   public function actionSubmitAppeal(){
       $user=yii::$app->user->identity;
        $data=yii::$app->request->post('data');
      
       if(is_string($data)){
           $data=json_decode($data,true);
       }
       $orderid=$data['orderid'];
       $reason=$data['content'];
      
       $order=Orders::findOne(['id'=>$orderid]);
       $type=1;
       if($order->user_guid==$user->user_guid){
           $type=1;
       }elseif ($order->seller_user==$user->user_guid){
           $type=2;
       }
      
       $appeal=new Appeal();
       $appeal->user_guid=$user->user_guid;
       $appeal->orderid=$orderid;
       $appeal->type=$type;
       $appeal->orderno=$order->orderno;
       $appeal->reason=$reason;
       $appeal->created_at=time();
       $appeal->goodsid=$order->goodsid;
       
       if($appeal->save()){
           foreach ($data['imgs'] as $v){
               $photo=ImageUploader::uploadImageByBase64($v);
               if($photo){
                   $appealPhoto=new AppealPhoto();
                   $appealPhoto->appealid=$appeal->id;
                   $appealPhoto->user_guid=$user->user_guid;
                   $appealPhoto->orderid=$orderid;
                   $appealPhoto->path=$photo['path'];
                   $appealPhoto->photo=$photo['photo'];
                   $appealPhoto->created_at=time();
                   $appealPhoto->save();
               }
           }
           return CommonUtil::success('success');
       }
       return CommonUtil::error('e1002');
   }
   
   public function actionSubmitComment(){
       $user=yii::$app->user->identity;
       $data=$_POST['data'];
       $orderid=$data['orderid'];
       $content=$data['content'];
       //$score=$data['score'];
       
       $order=Orders::findOne(['id'=>$orderid]);
       if($order->user_guid==$user->user_guid){
           $type=1; 
       }elseif ($order->seller_user==$user->user_guid){
           $type=2;
       }
       $comment=new Comment();
       $comment->user_guid=$user->user_guid;
       $comment->orderid=$orderid;
      $comment->goodsid=$order->goodsid;
      $comment->content=$content;
       $comment->created_at=time();
       if($comment->save()){
           return CommonUtil::success('success');
       }
       return CommonUtil::error('e1002');
   }
   
   public function actionGoodsDetail(){
       $data=$_POST['data'];
       $id=$data['id'];
       $model=Goods::findOne($id);
       if($model->status==1 ||$model->status==0){
           $time=time();
           if($model->end_time<=$time){
               $model->status=2;
               $model->updated_at=time();
               $model->save();
           }
       }
       $user=yii::$app->user->identity;
       $goodsPhoto=GoodsPhoto::findAll(['goodsid'=>$model->id]);
       CommonUtil::calScore('view_goods', $user->user_guid);
//        $goodsUser=User::findOne(['user_guid'=>$model->user_guid]);
       return $this->renderAjax('goods-detail',['model'=>$model,
           'goodsPhoto'=>$goodsPhoto
       ]);
   }
   
   public function actionOrderDetail(){
       $data=$_POST['data'];
       $id=$data['id'];
       $model=Orders::findOne($id);
       if($model->status==0 || $model->status==1){
           if(time()-$model->updated_at>1800){
               $model->status=98;
               $model->updated_at=time();
               $model->save();
           }
       }
       $goodsPhoto=GoodsPhoto::findOne(['goodsid'=>$model->goodsid]);
      
       return $this->renderAjax('order-detail',['model'=>$model,
           'goodsPhoto'=>$goodsPhoto
       ]);
   }
   
   public function actionOrderData(){
       $data=$_POST['data'];
       $id=$data['id'];
       $model=Orders::findOne(['id'=>$id]);
   
       return CommonUtil::success($model);
   }
   
   //供货保证金
   public  function actionPayDeposit(){
       $data=$_POST['data'];
       $id=$data['id'];
        $user=yii::$app->user->identity;
        $order=Orders::findOne(['user_guid'=>$user->user_guid,'goodsid'=>$id,'type'=>1]);
        if(!empty($order)){
            return CommonUtil::success($order->id);
        }
       $goods=Goods::findOne($id);
       if(empty($goods)){
           return CommonUtil::error('e1007');
       }
       if($goods->is_pay==1){
           return CommonUtil::error('e1007');
       }
       $sysSet=SysSet::find()->one();
       if($goods->is_car==1){
           $rate=$sysSet->car_deposit_rate;
       }else{
           $rate=$sysSet->deposit_rate;
       }
       $order=new Orders();
       $order->user_guid=$goods->user_guid;
       $order->seller_user=$goods->user_guid;
       $order->orderno=Orders::getOrderNo();
       $order->type=1;
       $order->goodsid=$goods->id;
       $order->number=$goods->stock;
       $order->goods_price=$goods->price;
       $order->cateid=$goods->cateid;
       $order->goods_name=$goods->name;
       $order->amount=$rate/100*$goods->total_amount;
       $order->total_amount=$rate/100*$goods->total_amount;
       $order->year=date('Y');
       $order->year_month=date('Ym');
       $order->year_month_day=date('Ymd');
       $order->created_at=time();
       if($order->save()){
           return CommonUtil::success($order->id);
       }
       return CommonUtil::error('e1002');
   }
   
   //进货保证金
   public  function actionSubmitOrder(){
       $data=$_POST['data'];
       $id=$data['id'];
       $number=$data['number'];

       $user=yii::$app->user->identity;
       $goods=Goods::findOne($id);
       if(empty($goods)){
           return CommonUtil::error('e1007');
       }
       $sysSet=SysSet::find()->one();
       if($goods->is_car==1){
           $rate=$sysSet->car_deposit_rate;
       }else{
           $rate=$sysSet->deposit_rate;
       }
       
       $order=new Orders();
       $order->user_guid=$user->user_guid;
       $order->seller_user=$goods->user_guid;
       $order->orderno=Orders::getOrderNo();
       $order->seller_orderno=Orders::getSellerOrderNo($order->orderno);
       $order->type=2;
       $order->is_car=$goods->is_car;
       $order->goodsid=$goods->id;
       $order->number=$number;
       $order->goods_price=$goods->price;
       $order->cateid=$goods->cateid;
       $order->goods_name=$goods->name;
       $order->amount=$rate/100*$goods->price*$number;
       $order->total_amount=$rate/100*$goods->price*$number;
       $order->year=date('Y');
       $order->year_month=date('Ym');
       $order->year_month_day=date('Ymd');
       $order->created_at=time();
       $order->updated_at=time();
       if($order->save()){
           return CommonUtil::success($order->id);
       }
       return CommonUtil::error('e1002');
   }
   
  
   
   public function getAlipayOrder($orderid,$orderType){
       $order=Orders::findOne($orderid);
       if($order->status==3){
           return false;
       }
//        $config=yii::$app->params['alipayConfig'];
//        $c = new \AopClient;
//        $c->gatewayUrl =$config['gatewayUrl'];
//       // $c->method="	alipay.trade.app.pay";
//        $c->appId = $config['app_id'];
//       // $c->rsaPrivateKey='MIICXQIBAAKBgQDywd7bW5pYULxlIndIOsRNBrumosRcXQy71fImn096XrVMTp3t1+pvBy6xgbvZjw8HdyUGnxsFEXRvjlqxae6Ugq+R+b+mLsZmux2IJbn1ccmI/AzDDLVIZmOBA6gHgfUzXCnLNFzqNaUjzoWxeeoZj7TdFIXaiF2EUNpQP5cLwQIDAQABAoGAHtr5gpQwGA2bBJfO5YVisg+rBlEl+D9zgOR+tN4G8hzbmmlbtYF+MMKO8sz0nYCLfn1sXV0XyBsh25QSfv5h7osVyC81JTD9/l1wmYbecqejOJAwiHSZKWjQjX8oNCp8aoBJffmRkJNino5ZwKjFAevzWstz4QT1UfwjS/23T+ECQQD7m/wQ+vBewjr1xiOmNfr8WdXel/eEdWnNCv5cThY/LtegPKsK5hr8/tUO86hwF/M4GSn1vOVUdWqwsSnDhVQlAkEA9v5XXo4eDWIMEpKdXoKEkSkh1LW+SFaMuploS1kaTEixw01fAfTeb3B3aHc0qYQhRc5DG2I8ahuj0I4xs5fYbQJBAPdyl7sHX8CBmsS9oa/EJNtramdo4zd01aGe7ztOXJi088EWCU1FskMgR99ViFD9bOi97sNLi+q9MzkkcyNkC7UCQGEYPPpTveae64YFks2LW1fBJqZ6x5GiTHIySjiMj3T7gr321WlsfGCsgpRTgCU/ZuENI35JUNyZfv1GWK1z/MUCQQDJEnr688t4yvJfsu+RURVGn3GPoBkzFXHlvDxE6D30RDaIevAIcHkIkJ9GDO7jWdCkGXIKlo6ilvPBmS+0LYqv';
//        $c->rsaPrivateKey=$config['merchant_private_key'];
//        $c->format = "json";
//        $c->charset= "utf-8";
//        $c->debugInfo=true;
//        $c->alipayrsaPublicKey =$config['alipay_public_key'];
//        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.open.public.template.message.industry.modify
//        $request = new \AlipayTradeAppPayRequest();
//        $request->setNotifyUrl(yii::$app->params['alipayNotifyUrl']);
// //        SDK已经封装掉了公共参数，这里只需要传入业务参数
// //        此次只是参数展示，未进行字符串转义，实际情况下请转义
//        $orderDesc=$order->type==1?'[供货保证金]':'[进货保证金]';
//        $bizContent=[
//            'body'=>$orderDesc.', 数量:'.$order->number,
//            'subject'=>$order->goods_name,
//            'out_trade_no'=>$order->orderno,
//            'total_amount'=>$order->amount,
//            'product_code'=>'QUICK_MSECURITY_PAY',
//            'timeout_express'=>'10m',
           
//        ];
//        $bizContent=json_encode($bizContent,JSON_UNESCAPED_UNICODE);
//        $request->setBizContent($bizContent);
//        $config=yii::$app->params['alipayConfig'];
//        $payResponse = new \AlipayTradeService($config);
//        $result=$payResponse->appPay($bizContent,$config['notify_url']);
       $alipay=new AlipayOrder();
       $result=$alipay->generateOrderInfo($order,$orderType);
       return $result;
   }
   

   public function actionAlipayWappay(){
       require_once '../../common/alipaysdk/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
       //商户订单号，商户网站订单系统中唯一订单号，必填
       $orderid=$_GET['orderid'];
       $order=Orders::findOne($orderid);
       if($order->is_pay==1){
           return '此订单您已经支付过了';
       }
        
       $out_trade_no = $order->orderno;
        
       //订单名称，必填
       $subject = $order->goods_name;
        
       //付款金额，必填
       $total_amount = $order->amount;
      // $total_amount = 0.1;
       $orderDesc=$order->type==1?'[供货保证金]':'[进货保证金], 数量:'.$order->number;
       //商品描述，可空
       $body = $orderDesc;
        
       //超时时间
       $timeout_express="10m";
        
       $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
       $payRequestBuilder->setBody($body);
       $payRequestBuilder->setSubject($subject);
       $payRequestBuilder->setOutTradeNo($out_trade_no);
       $payRequestBuilder->setTotalAmount($total_amount);
       $payRequestBuilder->setTimeExpress($timeout_express);
        
       $config=yii::$app->params['alipayConfig'];
       $payResponse = new \AlipayTradeService($config);
       $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        
       echo $result;
   }
   
   public function getWxpayOrder($orderid,$orderType){
       $order=Orders::findOne($orderid);
       if ($order->status==3){
           return false;
       }
       $logHandler= new \CLogFileHandler("../runtime/logs/".date('Y-m-d').'.log');
       $log = \Log::Init($logHandler, 15);
      
       $orderDesc=$orderType==1?'[进货保证金]':'[供货保证金]';
       if($orderType==1){
           $orderno=$order->orderno;
       }elseif($orderType==2){
           $orderno=$order->seller_orderno;
       }
       //②、统一下单
       $input = new \WxPayUnifiedOrder();
       $input->SetBody('e油网-'.$order->goods_name);
       $input->SetAttach($orderDesc);
       $input->SetOut_trade_no($orderno);
//        $input->SetTotal_fee(100);
       $input->SetTotal_fee(intval($order->amount*100) );
       $input->SetTime_start(date("YmdHis"));
       $input->SetTime_expire(date("YmdHis", time() + 30000));
       $input->SetGoods_tag(yii::$app->user->identity->mobile);
       $input->SetNotify_url(yii::$app->params['wxpayNotifyUrl']);
       $input->SetTrade_type("APP");
       $wxorder = \WxPayApi::unifiedOrder($input);
       return $wxorder;
   }
   
  
   
   //设置模板
   public  function actionTemplateSet(){
       $data=$_POST['data'];
       $id=$data['id'];
       $user=yii::$app->user->identity;
       $goodsTemplate=GoodsTemplate::findOne(['user_guid'=>$user->user_guid,'goodsid'=>$id]);
       if(!empty($goodsTemplate)){
           return CommonUtil::error('e1007');
       }
       $goods=Goods::findOne($id);
        $goodsTemp=new GoodsTemplate();
       $goodsTemp->user_guid=$user->user_guid;
       $goodsTemp->origin_user=$goods->user_guid;
       $goodsTemp->uid=$user->id;
       $goodsTemp->goods_user=$goods->user_guid;
       $goodsTemp->goodsid=$goods->id;
       $goodsTemp->cateid=$goods->cateid;
       $goodsTemp->name=$goods->name;
       $goodsTemp->desc=$goods->desc;
       $goodsTemp->price=$goods->price;
       $goodsTemp->stock=$goods->stock;
       $goodsTemp->address=$goods->address;
       $goodsTemp->mobile=$goods->mobile;
       $goodsTemp->lng=$goods->lng;
       $goodsTemp->lat=$goods->lat;
       $goodsTemp->unit=$goods->unit;
       $goodsTemp->end_time=$goods->end_time;
       $goodsTemp->created_at=time();
       if($goodsTemp->save()){
           return CommonUtil::success($goodsTemp->id);
       }
       return CommonUtil::error('e1002');
   }
   //模板数据
   public  function actionTemplateData(){
       $data=$_POST['data'];
       $id=$data['id'];
       $user=yii::$app->user->identity;
       $goodsTemplate=GoodsTemplate::findOne(['user_guid'=>$user->user_guid,'id'=>$id]);
       if(empty($goodsTemplate)){
           return CommonUtil::error('e1007');
       }
       $goodsPhoto=GoodsPhoto::findAll(['goodsid'=>$goodsTemplate->goodsid]);
       $cate=GoodsCate::findOne(['id'=>$goodsTemplate->cateid]);
       $data=[
           'photos'=>$goodsPhoto,
           'cate'=>[
               'value'=>$cate->id,
               'text'=>$cate->name
           ],
           'templateData'=>$goodsTemplate
       ];
       return CommonUtil::success($data);
   }
   
  public function  actionTemplateList(){
        //更新任务状态
        $user=yii::$app->user->identity;
        $goods=GoodsTemplate::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
        return $this->renderAjax('template-list',['goods'=>$goods]);
    }
   
    public function  actionDelTemplate(){
        //更新任务状态
        $data=yii::$app->request->post('data');
        $id=$data['id'];
        GoodsTemplate::deleteAll(['id'=>$id]);
        return CommonUtil::success('success');
    }
   
   public function actionPayOrder(){
       $data=$_POST['data'];
       $orderid=@$data['orderid'];
       $payType=@$data['payType'];
       $order=Orders::findOne($orderid);
       $user=yii::$app->user->identity;
       if($order->user_guid==$user->user_guid){
           $orderType=1;
       }elseif ($order->seller_user==$user->user_guid){
           $orderType=2;
       }
       if( ($orderType==1&&$order->is_pay==1) ||($orderType==2&&$order->is_seller_pay==1) ){
           return 'payed';
       }
       
       if($order->status==98){
           return 'closed';
       }

       
       
       if($payType=='alipay'){
           $order=$this->getAlipayOrder($orderid,$orderType);
           return $order;
           //return CommonUtil::success($order);
//            if($order){
//                return CommonUtil::success($order);
//            }else{
//                return CommonUtil::error('e1007');
   //        }
       }
       
       if($payType=='wxpay'){
           $order=$this->getWxpayOrder($orderid,$orderType);
           if($order){
               return CommonUtil::success($order);
           }else{
               return CommonUtil::error('e1007');
           }
       }
   }
   
   public function actionPaySuccess(){
       $data=$_POST['data'];
        
       $id=@$data['orderid'];
       //$orderType=@$data['orderType'];
       $trans=yii::$app->db->beginTransaction();
       try{
       $order=Orders::findOne($id);
       $user=yii::$app->user->identity;
       if($order->user_guid==$user->user_guid){
           $orderType=1;
       }elseif ($order->seller_user==$user->user_guid){
           $orderType=2;
       }
       if($orderType==1){
           $order->is_pay=1;
           $order->pay_time=time();
           $order->status=1;
           $order->pay_type=@$data['payType'];
           $message=new Message();
           $content="您发布的商品".$order->goods_name."已经有客户支付保证金,请在30分钟内支付保证金,否则订单关闭.<p class='text-center'><a href='#' class='pay-order' data-id='".$order->id."' >立即支付</a></p>";
           $message->send(NULL,$order->seller_user, $content, 1);
       }elseif ($orderType==2){
           $order->is_seller_pay=1;
           $order->seller_paytime=time();
           $order->status=2;
           $order->seller_paytype=@$data['payType'];
       }
       $order->updated_at=time();
       if(!$order->save()) throw new Exception('更新订单失败!');
           $goods=Goods::findOne(['id'=>$order->goodsid]);
           if($orderType == 1){
               $goods->count_sales +=$order->number;
               $goods->updated_at=time();
               if(!$goods->save())  throw new Exception('更新产品状态失败!');
           }
           
     
         
       $trans->commit();
       return CommonUtil::success('success');
       }catch (Exception $e){
           $trans->rollBack();
           return CommonUtil::error('e1002');
       }
     
   }
   
   public function actionGoodsData(){
       $data=$_POST['data'];
       $id=$data['id'];
       $model=Goods::findOne($id);
       $goodsPhoto=GoodsPhoto::findOne(['goodsid'=>$model->id]);
       $photoUrl=yii::$app->params['photoUrl'].$goodsPhoto->path.'thumb/'.$goodsPhoto->photo;
       $data=[
           'goods'=>$model,
           'photo'=>$photoUrl
       ];
       return CommonUtil::success($data);
   }
   
   public function actionSellerOrder(){
       $user=yii::$app->user->identity;
       $order=Orders::find()->andWhere(['seller_user'=>$user->user_guid])->orderBy('created_at desc')->all();
       $data=[];
       foreach ($order as $k=>$item){
           $data[$k]=[];
           $data[$k]['order']=$item;
           $data[$k]['goods']=Goods::findOne(['id'=>$item->goodsid]);
           $goodsPhoto=GoodsPhoto::findOne(['goodsid'=>$item->goodsid]);
           $data[$k]['goodsPhoto']=yii::$app->params['photoUrl'].$goodsPhoto->path.'thumb/'.$goodsPhoto->photo;
       }
       return CommonUtil::success($data);
   }
   
   public function actionBuyerOrder(){
        $user=yii::$app->user->identity;
       $order=Orders::find()->andWhere(['user_guid'=>$user->user_guid,'type'=>2])->orderBy('created_at desc')->all();
       $data=[];
       foreach ($order as $k=> $item){
           $data[$k]=[];
           $data[$k]['order']=$item;
           $data[$k]['goods']=Goods::findOne(['id'=>$item->goodsid]);
           $goodsPhoto=GoodsPhoto::findOne(['goodsid'=>$item->goodsid]);
           $data[$k]['goodsPhoto']=yii::$app->params['photoUrl'].$goodsPhoto->path.'thumb/'.$goodsPhoto->photo;
       }
       return CommonUtil::success($data);
   }
   
   
   
   public function actionGoodsCate(){
       $data=$_POST['data'];
       $cateid=$data['cateid'];
       $cate=GoodsCate::findOne($cateid);
       $cates=GoodsCate::findAll(['parentid'=>$cateid]);
       $cateArr=[];
       $cateArr[]=$cate->id;
       foreach ($cates as $v){
           
           $cateArr[]=$v->id;
           $subCate=GoodsCate::findAll(['parentid'=>$v->id]);
           foreach ($subCate as $item){
               $cateArr[]=$item->id;
           }
       }
       $pGoods=Goods::find()->andWhere(['cateid'=>$cateArr])->orderBy('created_at desc')->all();
       return $this->renderAjax('goods-cate',['cates'=>$cates,'cate'=>$cate,'pGoods'=>$pGoods]);
   }
   
   public function actionGoodsSearch(){
       $data=$_POST['data'];
      
//        $data=[
//            'type'=>'3',
//            'keyword'=>'22'
//        ];
       $keyword=@$data['keyword'];
       if($data['type']==1){
           $goods=Goods::find()->andFilterWhere(['like', 'name', $keyword])->orderBy('created_at desc')->all();
       }
       if($data['type']==2){
           $goods=Goods::find()->andFilterWhere(['like', 'address', $keyword])->orderBy('created_at desc')->all();
       }
       if($data['type']==3){
            $user=User::find()->andFilterWhere(['like', 'name', $keyword])->orderBy('created_at desc')->one();
           
           if(!empty($user)){
               $goods=Goods::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
           }else{
               $goods=[];
           }
       }
       if($data['type']==4){
           $startTime=strtotime(@$data['startTime']);
           $endTime=strtotime(@$data['endTime']);
           $goods=Goods::find()->andWhere("created_at >= $startTime and created_at <=$endTime ")->orderBy('created_at desc')->all();
       }
       
       return $this->renderAjax('goods-search',['goods'=>$goods]);
   }
   
   public function actionCateList(){
       $cates=GoodsCate::findAll(['parentid'=>0]);
       return $this->renderAjax('cate-list',['cates'=>$cates]);
   }
        
    /**
     * 推荐商品列表
     */
    public function  actionRecGoodsList(){
        
        $goods=Goods::find()->andWhere(['is_rec'=>1])->orderBy('created_at desc')->all();
        return $this->renderAjax('rec-goods-list',['goods'=>$goods]);
        
    }
    public function  actionGoodsList(){
    
        $goods=Goods::find()->orderBy('created_at desc')->all();
        return $this->renderAjax('goods-list',['goods'=>$goods]);
    
    }
    public function  actionUserGoods(){
        $data=yii::$app->request->post('data');
        
        $user=User::findOne(['user_guid'=>$data['uid']]);
        $goods=Goods::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
        return $this->renderAjax('user-goods',['goods'=>$goods,'user'=>$user]);
         
    }
    
    public function  actionMyPub(){
        $user=yii::$app->user->identity;
        $goods=Goods::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
        return $this->renderAjax('my-pub',['goods'=>$goods]);
    }
    

    
    /**
     * 供货商申请退还保证金
     */
        public function actionWithdrawOrder(){
           $data=$_POST['data'];
           $orderid=$data['orderid'];
           $user=yii::$app->user->identity;
           $order=Orders::findOne(['id'=>$orderid,'user_guid'=>$user->user_guid,'type'=>'1']);
           if(empty($order)){
               return CommonUtil::error('e1007');
           }
           if($order->status==3){
               return CommonUtil::error('e1007');
           }
            $trans=yii::$app->db->beginTransaction();
           try{
               $order->status=3;
               $order->updated_at=time();
               if(!$order->save()) throw new Exception('更新订单失败!');
               $goods=Goods::findOne(['id'=>$order->goodsid]);
               $goods->status=3;
               $goods->updated_at=time();
               if(!$goods->save()) throw new \Exception('更新产品失败');
               $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
               if(empty($wallet)){
                   $wallet=new Wallet();
                   $wallet->user_guid=$user->user_guid;
                   $wallet->created_at=time();
               }
               $wallet->frozen +=$order->amount;
               $wallet->total_amount +=$order->amount;
               if(!$wallet->save()) throw new \Exception();
               $incomRec=new IncomeRec();
               $incomRec->user_guid=$user->user_guid;
               $incomRec->orderid=$order->id;
               $incomRec->orderno=$order->orderno;
               $incomRec->number=$order->number;
               $incomRec->refer_goods=$order->goodsid;
               $incomRec->amount=$order->amount;
               $incomRec->status=1;
               $incomRec->remark='供货保证金退款,订单号:'.$order->orderno.',商品:'.$order->goods_name;
               $incomRec->year=date('Y');
               $incomRec->year_month=date('Ym');
               $incomRec->year_month_day=date('Ymd');
               $incomRec->created_at=time();
               if(!$incomRec->save()) throw new \Exception('收入记录失败!');
               
               $trans->commit();
               return CommonUtil::success('success');
           }catch (Exception $e){
               $trans->rollBack();
               return CommonUtil::error('e1002');
           }
       }
    
       //确认履约
       public function actionConfirmOrder(){
           $data=$_POST['data'];
           $orderid=$data['orderid'];
           $user=yii::$app->user->identity;
           $order=Orders::findOne(['id'=>$orderid]);
           if(empty($order)){
               return CommonUtil::error('e1007');
           }
           if($order->user_guid==$user->user_guid){
               $order->buyer_confirm_time=time();
               $order->is_buyer_confirm=1;
               if($order->is_seller_confirm==1){
                   $order->status=3;
                   $order->updated_at=time();
               }
           }elseif($order->seller_user==$user->user_guid){
               $order->seller_confirm_time=time();
               $order->is_seller_confirm=1;
               if($order->is_buyer_confirm==1){
                   $order->status=3;
                   $order->updated_at=time();
               }
           }
          
           if($order->save()){
               return CommonUtil::success('success');
           }
           
           return CommonUtil::error('e1002');
           
       }
    
       //取消订单
       public function actionCancelOrder(){
           $data=$_POST['data'];
           $orderid=$data['orderid'];
           $user=yii::$app->user->identity;
           $order=Orders::findOne(['id'=>$orderid,'user_guid'=>$user->user_guid,'type'=>'2']);
           if(empty($order)){
               return CommonUtil::error('e1007');
           }
            
           $order->status=99;
           $order->cancel_time=time();
           $order->updated_at=time();
           if($order->save()){
               return CommonUtil::success('success');
           }
            
           return CommonUtil::error('e1002');
            
       }

}
