<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use common\models\CommonUtil;
use common\models\MobileVerify;
use common\models\LoginRec;
use common\models\UnitSet;
use common\models\GoodsCate;
use common\models\News;
use common\models\Goods;
use common\models\Siteinfo;
use common\models\PayNotifyCallBack;
use common\models\Orders;
use yii\db\Exception;

require_once '../../common/alipaysdk/wappay/service/AlipayTradeService.php';
/**
 *app api
 */
class SiteController extends Controller
{
 

    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
    
    public function beforeAction($action){

        if($action!='check-update'){
            //检查客户端是否提交数据
            if(!isset($_POST['data'])){
                return CommonUtil::error('e1001');
            }
        }
        
        if($action!='check-update'||$action!='login'||$action!='check-mobile' || $action!='register' ||$action!='check-username'){
            //检查用户是否登录
            if(!isset($_POST['user'])){
                return CommonUtil::error('e1001');
            }
        }
        
        return parent::beforeAction($action);
    }
    
    /**
     * 检查手机号是否注册
     * @return string
     */
    public function actionCheckMobile(){
   
        $data=$_POST['data'];
        $mobile=$data['mobile'];      
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            return CommonUtil::error('e1004');
        }        
        return CommonUtil::success('checked');
    }
    
    /**
     * 检查用户名是否注册
     * @return string
     */
    public function actionCheckUsername(){
         
        $data=$_POST['data'];
        $username=$data['username'];
        $user=User::findOne(['username'=>$username]);
        if(!empty($user)){
            return CommonUtil::error('e1004');
        }
        return CommonUtil::success('checked');
    }
    
    public function actionGetUnit(){
        $unit=UnitSet::find()->orderBy('created_at desc')->all();
        return CommonUtil::success($unit);
    }
    
    public function actionGetHomeBanner(){
        $news=News::find()->andWhere(['is_recommend'=>1,'cateid'=>'1'])->orderBy('created_at desc')->limit(10)->all();
      
        return $this->renderAjax('home-banner',['news'=>$news]);
    }
    
    public function actionGetEoilTop(){
        $news=News::find()->andWhere(['is_recommend'=>1,'cateid'=>'2'])->orderBy('created_at desc')->limit(10)->all();
        return $this->renderAjax('eoil-top',['news'=>$news]);
    }
    
    public function actionGetHomeTop(){
        $news=News::find()->orderBy('created_at desc')->limit(5)->all();
        return $this->renderAjax('home-top',['news'=>$news]);
    }
    
    public function actionGetHomeNews(){
        $news=News::find()->andWhere(['cateid'=>2])->orderBy('created_at desc')->limit(5)->all();
        return $this->renderAjax('home-top',['news'=>$news]);
    }
    public function actionGetRecGoods(){
        $goods=Goods::find()->andWhere(['is_rec'=>1])->orderBy('created_at desc')->limit(10)->all();
        return $this->renderAjax('rec-goods',['goods'=>$goods]);
    }
    public function actionGetNewGoods(){
        $goods=Goods::find()->orderBy('created_at desc')->limit(6)->all();
        return $this->renderAjax('new-goods',['goods'=>$goods]);
    }
    
    public function actionGetCate(){
        $cate=[];
        $cateOne=GoodsCate::find()->andWhere(['parentid'=>0])->orderBy('created_at desc')->all();
        foreach ($cateOne as $k=> $v){
            $cate[$k]=[
                'value'=>$v->id,
                'text'=>$v->name,
                'children'=>[]
            ];
            $cateChild=GoodsCate::find()->andWhere(['parentid'=>$v->id])->orderBy('created_at desc')->all();
            foreach ($cateChild as $j=> $item){
                $cate[$k]['children'][$j]=[
                   'value'=>$item->id,
                   'text'=>$item->name,
                    'children'=>[]
                ];
                $thrdChild=GoodsCate::find()->andWhere(['parentid'=>$item->id])->orderBy('created_at desc')->all();
                foreach ($thrdChild as $m=> $n){
                    $cate[$k]['children'][$j]['children'][$m]=[
                        'value'=>$n->id,
                        'text'=>$n->name,
                    ];
                }
            }
        }
        
        return CommonUtil::success($cate);
    }
    
   public function actionWxpayNotify(){
       $logHandler= new \CLogFileHandler("../../common/WxpayAPI/logs/".date('Y-m-d').'.log');
       $log = \Log::Init($logHandler, 15);
       \Log::DEBUG(date('Y-m-d H:i:s').":get notify");
       $notify= new PayNotifyCallBack();
       $notify->Handle(false);
   }
   
   public function actionAlipayNotify(){
    
    $config=yii::$app->params['alipayConfig'];
    $arr=$_POST;
    $alipaySevice = new \AlipayTradeService($config); 
    $result = $alipaySevice->check($arr);
    $result=true;
    /* 实际验证过程建议商户添加以下校验。
    1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
    2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
    3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
    4、验证app_id是否为该商户本身。
    */
    if($result) {//验证成功
    	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    	//请在这里加上商户的业务逻辑程序代
    
    	
    	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    	
        //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    	
    	//商户订单号
    
    	$out_trade_no = $_POST['out_trade_no'];
    
    	//支付宝交易号
    
    	$trade_no = $_POST['trade_no'];
    
    	//交易状态
    	$trade_status = $_POST['trade_status'];
    
    
        if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS') {
            
            $order=Orders::findOne(['orderno'=>$out_trade_no]);
            if(!empty($order)){
                if($order->is_pay==0){
                    $trans=yii::$app->db->beginTransaction();
                    try{
                        $order->is_pay=1;
                        $order->pay_time=time();
                        $order->status=1;
                        $order->pay_type='alipay';
                        $order->alipay_trade_no=$trade_no;
                        $order->updated_at=time();
                        if(!$order->save()) throw new Exception('更新订单失败!');
                        if($order->type==1){
                            $goods=Goods::findOne(['id'=>$order->goodsid]);
                            $goods->is_pay=1;
                            $goods->status=1;
                            $goods->deposit_amount=$order->amount;
                            $goods->updated_at=time();
                            if(!$goods->save())  throw new Exception('更新产品状态失败!');
                        }
                    
                         
                        $trans->commit();
                         
                    }catch (Exception $e){
                        $trans->rollBack();
                        //return CommonUtil::error('e1002');
                    }
                }
            }
    		//判断该笔订单是否在商户网站中已经做过处理
    			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    			//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
    			//如果有做过处理，不执行商户的业务程序
    				
    		//注意：
    		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
        }
            
    	echo "success";		//请不要修改或删除
    		
    }else {
        //验证失败
        echo "fail";	//请不要修改或删除
    
    }
   }
   
   public function actionAlipayReturn(){
       
   
       $config=yii::$app->params['alipayConfig'];
       $arr=$_GET;
       $alipaySevice = new \AlipayTradeService($config);
       $result = $alipaySevice->check($arr);
       $result=true;
       /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
       if($result) {//验证成功

        	$out_trade_no = htmlspecialchars(@$_GET['out_trade_no']);
        
        	//支付宝交易号
        
        	$trade_no = htmlspecialchars(@$_GET['trade_no']);
   
           //交易状态
           $trade_status = @$_GET['trade_status'];
   
   
          // if(@$_GET['trade_status'] == 'TRADE_FINISHED' || @$_GET['trade_status'] == 'TRADE_SUCCESS') {
   
               $order=Orders::findOne(['orderno'=>$out_trade_no]);
               if(!empty($order)){
                   if($order->is_pay==0){
                       $trans=yii::$app->db->beginTransaction();
                       try{
                           $order->is_pay=1;
                           $order->pay_time=time();
                           $order->status=1;
                           $order->pay_type='alipay';
                           $order->alipay_trade_no=$trade_no;
                           $order->updated_at=time();
                           if(!$order->save()) throw new Exception('更新订单失败!');
                           if($order->type==1){
                               $goods=Goods::findOne(['id'=>$order->goodsid]);
                               $goods->is_pay=1;
                               $goods->status=1;
                               $goods->deposit_amount=$order->amount;
                               $goods->updated_at=time();
                               if(!$goods->save())  throw new Exception('更新产品状态失败!');
                           }
   
                            
                           $trans->commit();
                            
                       }catch (Exception $e){
                           $trans->rollBack();
                           //return CommonUtil::error('e1002');
                       }
                   }
               }
           //}
          
           //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
   
          return $this->renderAjax('pay-result',['result'=>'success']);
   
       }else {
           //验证失败
           return $this->renderAjax('pay-result',['result'=>'fail']);
   
       }
   }
    
    public function actionContact(){
        $id=2;
        $model=Siteinfo::findOne($id);
        return $this->render('contact',['model'=>$model]);
    }
    
    
    
    /**
     * 发送验证码
     * @author youngshunf
     * @return string
     */    
    public function actionSendVerifyCode(){
      
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $verifyCode=rand(1000,9999);
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            return CommonUtil::error('e1004');     
        }
        
        $mobileVerify=new MobileVerify();
        $mobileVerify->mobile=$mobile;
        $mobileVerify->verify_code=$verifyCode;
        $mobileVerify->created_at=time();    
        if($mobileVerify->save()){
            $this->sendSMS($mobile, $verifyCode);
            return CommonUtil::success('sent');
        }
        
       return CommonUtil::error('e1002');

    }
    
    /**
     * 修改密码验证码
     * @author youngshunf
     * @return string
     */
    public function actionSendVerifyCode2(){
        if(!isset($_POST['data'])){
            return CommonUtil::error('e1001');
        }
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $verifyCode=rand(1000,9999);
        $user=User::findOne(['mobile'=>$mobile]);
        if(empty($user)){
            return CommonUtil::error('e1004');
        }
    
        $mobileVerify=new MobileVerify();
        $mobileVerify->mobile=$mobile;
        $mobileVerify->verify_code=$verifyCode;
        $mobileVerify->created_at=time();
        if($mobileVerify->save()){
            $this->sendSMS($mobile, $verifyCode);
            return CommonUtil::success('sent');
        }
        return CommonUtil::error('e1002');
    
    }
    
    public  function sendSMS($mobile,$code){
        $c = new \TopClient;
//         $c ->appkey = '23440632' ;
//         $c ->secretKey = '74cd79711b874e94668166b8a6ac5146';
        $c ->appkey = '23565049' ;
        $c ->secretKey = '1405a1dd6066226c0c56ddda34f3b05e';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "e油网" );
        $param=[
            'code'=>(string)$code
        ];
        $param=json_encode($param);
        $req ->setSmsParam( $param );
        $req ->setRecNum( $mobile );
        $req ->setSmsTemplateCode( "SMS_33905041" );
        $resp = $c ->execute( $req );
    }
    
    /**
     * 修改密码
     * @author youngshunf
     */
    public function actionChangePassword(){
        if(!isset($_POST['data'])){
            return CommonUtil::error('e1001');
        }
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
            return CommonUtil::error('e1003');
        }
         
        $user=User::findOne(['mobile'=>$mobile]);
        if(empty($user)){
            //用户手机未注册
            return CommonUtil::error('e1004');
        }
    
        $user->password=md5($password);
        $user->generateAccessToken();
        $user->updated_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
            //记录登录日志
            $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=$user->last_login_time;
            $loginRec->ua=$user->last_login_client;
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    
    }
    
    /**
     * 修改支付密码
     * @author youngshunf
     */
    public function actionChangePayPassword(){
        if(!isset($_POST['data'])){
            return CommonUtil::error('e1001');
        }
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
            return CommonUtil::error('e1003');
        }
         
        $user=User::findOne(['mobile'=>$mobile]);
        if(empty($user)){
            //用户手机未注册
            return CommonUtil::error('e1004');
        }
    
        $user->pay_password=md5($password);
        $user->updated_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
        
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    
    }
    /**
     * 用户注册
     * @author youngshunf
     */
    public function actionRegister(){
      
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
           return CommonUtil::error('e1003');     
        }
    
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            //用户手机已注册
           return CommonUtil::error('e1004');     
        }
                
        $user=new User();
        $user->user_guid=CommonUtil::createUuid();
        $user->mobile=$mobile;
        $user->password_origin=$password;
        $user->password=md5($password);
        $user->generateAccessToken();
        $user->invite_code=rand(100000,999999);
        $user->imei=@$data['deviceInfo']['imei'];
        $user->imsi=@$data['deviceInfo']['imsi'];
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_time=time();
        $user->created_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
            //自动登录
            $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=time();
            $loginRec->ua=yii::$app->request->getUserAgent();
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
            
           return CommonUtil::success($user);
        }        
       return CommonUtil::error('e1002');     
        
    }
    
    /**
     * 用户自动登陆
     */
    public function actionAutoLogin(){
     $clientUser=$_POST['user'];
    //验证用户
    $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
            if(empty($user)){
                return CommonUtil::error('e1006');
       }
       // $user->generateAccessToken();
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_time=time();
        $user->login_type='auto';
        if($user->save()){      
             $loginRec=new LoginRec();
             $loginRec->user_guid=$user->user_guid;
             $loginRec->ip=$user->last_ip;
             $loginRec->time=$user->last_time;
             $loginRec->ua=yii::$app->request->getUserAgent();
             $loginRec->lng=@$_POST['data']['locInfo']['lng'];
             $loginRec->lat=@$_POST['data']['locInfo']['lat'];
             $loginRec->address=@$_POST['data']['locInfo']['address'];  
             $loginRec->save();  
           return CommonUtil::success($user);     
        }
        
        return CommonUtil::error('e1005');
    }
    
    public function actionAuthLogin(){
        $data=$_POST['data'];
        $userInfo=$data['userInfo'];
        $openid=$userInfo['openid'];
        $user=User::findOne(['openid'=>$openid]);
        if(!empty($user)){
            $user->last_ip=yii::$app->request->getUserIP();
            $user->last_time=time();
            $user->login_type=@$data['loginType'];
            if($user->save()){
                $loginRec=new LoginRec();
                $loginRec->user_guid=$user->user_guid;
                $loginRec->ip=$user->last_ip;
                $loginRec->time=$user->last_time;
                $loginRec->ua=yii::$app->request->getUserAgent();
                $loginRec->lng=@$_POST['data']['locInfo']['lng'];
                $loginRec->lat=@$_POST['data']['locInfo']['lat'];
                $loginRec->address=@$_POST['data']['locInfo']['address'];
                $loginRec->save();
                return CommonUtil::success($user);
            }
        }else{
            $user=new User();
            $user->user_guid=CommonUtil::createUuid();
            $user->generateAccessToken();
            $user->openid=$userInfo['openid'];
            $user->nick=@$userInfo['nickname'];
            $user->name=@$userInfo['nickname'];
            $user->city=@$userInfo['city'];
            $user->province=@$userInfo['province'];
            $user->register_type=$data['loginType'];
            $user->login_type=$data['loginType'];
            if($user->register_type=='weixin'){
                $user->sex=$userInfo['sex'];
                $user->img_path=$userInfo['headimgurl'];
            }else{
                $user->sex=$userInfo['gender']=='男'?'1':'2';
                $user->img_path=$userInfo['figureurl_2'];
            }
            $user->created_at=time();
            if($user->save()){
                return CommonUtil::success($user);
            }
        }
        
        return CommonUtil::error('e1002');
    }
    
    public function actionBindMobile(){
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=$data['password'];
        $verifycode=$data['verifycode'];
        $mobileVerify=MobileVerify::findOne(['mobile'=>$mobile,'verify_code'=>$verifycode,'is_valid'=>1]);
        if(empty($mobileVerify)){
            //验证码错误
            return CommonUtil::error('e1003');
        }
        
        $user=User::findOne(['mobile'=>$mobile]);
        if(!empty($user)){
            //用户手机已注册
            return CommonUtil::error('e1004');
        }
        
        $user=User::findOne(['user_guid'=>$data['user']['user_guid']]);
        if(empty($user)){
            return CommonUtil::error('e1002');
        }
        $user->mobile=$mobile;
        $user->password_origin=$password;
        $user->password=md5($password);
        $user->generateAccessToken();
        $user->invite_code=rand(100000,999999);
        $user->imei=@$data['deviceInfo']['imei'];
        $user->imsi=@$data['deviceInfo']['imsi'];
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_time=time();
        $user->created_at=time();
        if($user->save()){
            //验证码使用后失效
            $mobileVerify->is_valid=0;
            $mobileVerify->save();
            //自动登录
            $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=time();
            $loginRec->ua=yii::$app->request->getUserAgent();
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
        
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    }
    
    /**
     *用户登录
     *@author youngshunf
     */
    public function actionLogin()
    {       
        
        $data=$_POST['data'];
        $mobile=$data['mobile'];
        $password=md5($data['password']);  
              
        $user=User::find()->andWhere(" mobile ='$mobile' and password='$password' ")->one();            
        if($user===null){
            return CommonUtil::error('e1005');
        }   
        $user->last_ip=yii::$app->request->getUserIP();
        $user->last_time=time();
        $user->login_type="mobile";
        if($user->save()){          
             $loginRec=new LoginRec();
            $loginRec->user_guid=$user->user_guid;
            $loginRec->ip=$user->last_ip;
            $loginRec->time=time();
            $loginRec->ua=yii::$app->request->getUserAgent();
            $loginRec->lng=@$_POST['data']['locInfo']['lng'];
            $loginRec->lat=@$_POST['data']['locInfo']['lat'];
            $loginRec->address=@$_POST['data']['locInfo']['address'];
            $loginRec->save();
           return CommonUtil::success($user);     
        }
        
        return CommonUtil::error('e1005');
    }    
    

    /**
     * 检查更新
     * @author youngshunf
     * @return string
     *
     */
    public function actionCheckUpdate(){
       $ua=yii::$app->request->getUserAgent();
      $wgtUrl= 'http://images.eoil.mi2you.com/wgt/H51B98E5D.wgt';
       
      $updateInfo=[
          'newVer'=>'1.2.3',
          'wgtUrl'=>$wgtUrl
      ];
      
      return json_encode($updateInfo);
        
    }
    
    public function actionError(){
        
        return $this->render('error');
    }

}
