<?php
namespace api\controllers;

use common\models\WithdrawRec;
use Yii;
use yii\db\Exception;
use common\models\User;
use yii\helpers\Json;
use common\models\CommonUtil;
use common\models\ImageUploader;
use common\models\Wallet;
use common\models\Message;
use common\models\UserData;
use common\models\UserScore;
use common\models\UserSign;
use common\models\ShoppingCart;
use common\models\GoodsLove;
use common\models\UserJudge;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use common\models\UserAuth;
use common\models\Goods;
use common\models\GeoCoding;
use common\models\GoodsPhoto;
use common\models\UserLocation;

/**
 * 用户信息
 */
class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';
    /**
     * 取消用户提交数据验证
     */
    public $enableCsrfValidation = false;
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
         
    
        /**
     * 修改个人信息
     * @author youngshunf
     *
     */
    public function actionUpdateProfile(){
        //验证用户
        $user=yii::$app->user->identity;
        $data=$_POST['data'];
        $user->name=@$data['name'];
        $user->sex=@$data['sex'];
        $user->birthday=@$data['birthday'];
        $user->identityno=@$data['identityno'];
        $user->address=@$data['address'];
        $user->email=@$data['email'];
        $user->bank_name=@$data['bank_name'];
        $user->bank_account=@$data['bank_account'];
        $user->marital=@$data['marital'];
        $user->interest=@$data['interest'];
        $user->second_mobile=@$data['second_mobile'];
        $user->homeland=@$data['homeland'];
        $user->weixin=@$data['weixin'];
        $user->qq=@$data['qq'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
        
        
    }
    
    /**
     * 修改个人学历与职业
     * @author youngshunf
     *
     */
    public function actionUpdatePost(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->top_edu=@$data['top_edu'];
        $user->graduate_school=@$data['graduate_school'];
        $user->graduate_time=@$data['graduate_time'];
        $user->english_level=@$data['english_level'];
        $user->major=@$data['major'];
        $user->computer_level=@$data['computer_level'];
        $user->post=@$data['post'];
        $user->income_level=@$data['income_level'];
        $user->work_experience=@$data['work_experience'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        return CommonUtil::error('e1002');
    
    }
    /**
     * 修改家庭信息
     * @author youngshunf
     *
     */
    public function actionUpdateHomeInfo(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->children_age=@$data['children_age'];
        $user->home_income=@$data['home_income'];
        $user->estate=@$data['estate'];
        $user->car_num=@$data['car_num'];
        $user->updated_at=time();
        if($user->save()){
            return CommonUtil::success($user);
        }
        
        return CommonUtil::error('e1002');
        
    }
    /**
     * 上传头像
     * @author youngshunf
     * 
     */
  public function actionUploadHeadimg(){
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $imgData=@$_POST['data']['imgData'];
        //$imgLen=@$_POST['data']['imgLength'];
        $photo=ImageUploader::uploadImageByBase64($imgData);
       // return json_encode($photo);
        if($photo){
            $user->path=$photo['path'];
            $user->photo=$photo['photo'];
            $user->updated_at=time();
            if($user->save()){
                return CommonUtil::success($user);
            }
         }
        
         return CommonUtil::error('e1002');
    }
       
   public function actionUserData(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $data=$_POST['data'];
       $userData=new UserData();
       $userData->user_guid=$user->user_guid;
       $userData->sex=@$data['sex'];
       $userData->age=@$data['age'];
       $userData->weight=@$data['weight'];
       $userData->tall=@$data['tall'];
       $userData->post=@$data['post'];
       $userData->style=@$data['style'];
       $userData->shape=@$data['shape'];
       $userData->jtype=1;
       if(!empty($data['imgFace'])){
           $photo1=ImageUploader::uploadImageByBase64($data['imgFace']);
           if($photo1){
               $userData->path1=$photo1['path'];
               $userData->photo1=$photo1['photo'];
           }
       }
       if(!empty($data['imgTotal'])){
           $photo2=ImageUploader::uploadImageByBase64($data['imgTotal']);
           if($photo2){
               $userData->path2=$photo2['path'];
               $userData->photo2=$photo2['photo'];
           }
       }
      
       $userData->created_at=time();
       if($userData->save()){
           $user->is_submit_data=1;
           $user->save();
           return CommonUtil::success('数据提交成功!');
       }
       
      
       return CommonUtil::error('e1002');
   }      

   public function actionGetWallet(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
       if(empty($wallet)){
           return CommonUtil::success('nodata');
       }
       return CommonUtil::success($wallet);
   }
   
   public function actionGetScore(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $score=UserScore::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
       return $this->renderAjax('user-score',['score'=>$score]);
        
   }
   
   public function actionUserSign(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $userSign=new UserSign();
       $userSign->user_guid=$user->user_guid;
       $userSign->sign_date=date('Y-m-d');
       $userSign->created_at=time();
       if($userSign->save()){
           $scoreUser=CommonUtil::calScore('sign', $user->user_guid);
           if($scoreUser){
               return CommonUtil::success($scoreUser);
           }else{
               return CommonUtil::error('e1002');
           }
       }
       return CommonUtil::error('e1002');
   }
   
   public function actionGetAuthView(){
       $user=yii::$app->user->identity;
       $userAuth=UserAuth::findOne(['user_guid'=>$user->user_guid]);
       return $this->renderAjax('my-auth-view',['model'=>$userAuth]);
   }
   
   public function actionSubmitAuth(){
       //验证用户
       $user=yii::$app->user->identity;
       $data=yii::$app->request->post('data');
       $userAuth=new UserAuth();
       $userAuth->user_guid=$user->user_guid;
       $userAuth->uid=$user->id;
       $userAuth->created_at=time();
       $data['form']=json_decode($data['form'],true);
       $userAuth->user_type=$data['form']['userType'];
       if($userAuth->user_type=='1'){
           $userAuth->name=$data['form']['name'];
           $userAuth->id_code=$data['form']['id_code'];
       }
      if($userAuth->user_type=='2'){
           $userAuth->company_name=$data['form']['company_name'];
           $userAuth->company_owner=$data['form']['company_owner'];
           $userAuth->owner_code=$data['form']['owner_code'];
           $userAuth->company_credit_code=$data['form']['company_credit_code'];
       }
       
       if($data['imgs']['p1']){
           $photo=ImageUploader::uploadImageByBase64($data['imgs']['p1']);
           if($photo){
               $userAuth->path=$photo['path'];
               $userAuth->id_photo1=$photo['photo'];
           }
       }
       if($data['imgs']['p2']){
           $photo=ImageUploader::uploadImageByBase64($data['imgs']['p2']);
           if($photo){
               $userAuth->path=$photo['path'];
               $userAuth->id_photo2=$photo['photo'];
           }
       }
       if($data['imgs']['p3']){
           $photo=ImageUploader::uploadImageByBase64($data['imgs']['p3']);
           if($photo){
               $userAuth->path=$photo['path'];
               $userAuth->id_photo3=$photo['photo'];
           }
       }
       
       if($userAuth->save()){
           $user=User::findOne($user->id);
           $user->is_submit_data=1;
           $user->user_type=$userAuth->user_type;
           if($userAuth->user_type==1){
               $user->name=$userAuth->name;
           }else{
               $user->name=$userAuth->company_owner;
           }
          
           $user->save();
           return CommonUtil::success($user);
       }
       return CommonUtil::error('e1002');
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
       $goods->cateid=@$data['cate']['value'];
       $goods->end_time=strtotime(@$data['endTime']);
       $goods->mobile=@$data['mobile'];
       $goods->qq=@$data['qq'];
       $goods->address=@$data['address'];
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
           CommonUtil::calScore('publish_goods', $user->user_guid);
           return CommonUtil::success($goods->id);
       }
        
       return CommonUtil::error('e1002');
        
   }
   
   public function actionUserReport(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $userJudge=null;
       $userData=UserData::findOne(['user_guid'=>$user->user_guid,'dtype'=>1]);
       if(!empty($userData)){
           $userJudge=UserJudge::findOne(['data_id'=>$userData->id]);
       }
       //return Json::encode($userJudge);
        
       return $this->renderAjax('user-report',[
           'user'=>$user,
           'userData'=>$userData,
           'userJudge'=>$userJudge
       ]);
        
   }
   
   public function actionAddCart(){
       //验证用户
       $user=yii::$app->user->identity;
       $data=$_POST['data'];
//        $data=[
//            'id'=>'1',
//            'count'=>'2'
//        ];
       $shoppingCart=ShoppingCart::findOne(['user_guid'=>$user->user_guid,'goodsid'=>$data['id']]);
       if(empty($shoppingCart)){
           $shoppingCart=new ShoppingCart();
           $shoppingCart->count=0;
           $shoppingCart->created_at=time();
       }else{
           $shoppingCart->updated_at=time();
       }
       $shoppingCart->user_guid=$user->user_guid;
       $shoppingCart->uid=$user->id;
       $shoppingCart->count +=$data['count'];
       $shoppingCart->goodsid=$data['id'];
       
       if($shoppingCart->save()){
                $userScore=new UserScore();
                $userScore->user_guid=$user->user_guid;
                $userScore->type=3;
                $userScore->score=5;
                $userScore->desc='添加商品进购物车';
                $userScore->created_at=time();
                if($userScore->save()){
                    $scoreUser=User::findOne(['user_guid'=>$user->user_guid]);
                    $scoreUser->score+=$userScore->score;
                    $scoreUser->save();
                    return CommonUtil::success($scoreUser);
                }
       }
       return CommonUtil::error('e1002');
        
   }
   
   public function actionGetShoppingcart(){
       $user=yii::$app->user->identity;
       $shoppingCart=ShoppingCart::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
     // return Json::encode($shoppingCart[0]->goods);
       return $this->renderAjax('shopping-cart',[
           'shoppingCart'=>$shoppingCart
       ]);
   
   }
   public function actionDeleteCart(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
        $data=$_POST['data'];
       ShoppingCart::findOne(['id'=>$data['id'],'user_guid'=>$user->user_guid])->delete();
        
       return CommonUtil::success('success');
        
   }
   
   public function actionGetGoodslove(){
       $user=yii::$app->user->identity;
       $goodsLove=GoodsLove::find()->andWhere(['user_guid'=>$user->user_guid])->orderBy('created_at desc')->all();
       return $this->renderAjax('goods-love',[
           'goodsLove'=>$goodsLove
       ]);
        
   }
   public function actionDeleteGoodslove(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $data=$_POST['data'];
       GoodsLove::findOne(['id'=>$data['id'],'user_guid'=>$user->user_guid])->delete();
   
       return CommonUtil::success('success');
   
   }
   
   
   public function actionGoodsLove(){
       //验证用户
       $user=yii::$app->user->identity;
       $data=$_POST['data'];
       $goods=GoodsLove::findOne(['user_guid'=>$user->user_guid,'goodsid'=>$data['id']]);
       if(!empty($goods)){
           return CommonUtil::error('e1007');
       }
       $goodsLove=new GoodsLove();
       $goodsLove->user_guid=$user->user_guid;
       $goodsLove->uid=$user->id;
       $goodsLove->goodsid=$data['id'];
       $goodsLove->created_at=time();
       if($goodsLove->save()){
           CommonUtil::calScore('goods_love', $user->user_guid);
              
       }
       return CommonUtil::error('e1002');
   }
   
   public function actionCheckSign(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $day=date('Y-m-d');
       
       $userSign=UserSign::findOne(['user_guid'=>$user->user_guid,'sign_date'=>$day]);
       
       if(!empty($userSign)){
               return CommonUtil::success('signed');
       }
        
       return CommonUtil::error('e1002');
        
   }
   
   public function actionCheckUser(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
        
      return CommonUtil::success($user);
   
   
   }
   
   
   
   
   
  /**
   * 获取未读消息
   * @return string
   */
     public function actionGetMessageState(){
       $clientUser=$_POST['user'];
       //验证用户
       $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
       if(empty($user)){
           return CommonUtil::error('e1006');
       }
       $unreadSys=Message::find()->andWhere(['to_user'=>$user->user_guid,'is_read'=>0,'type'=>Message::SYS])->count();
       $unreadEnt=Message::find()->andWhere(['to_user'=>$user->user_guid,'is_read'=>0,'type'=>2])->count();
        
       $result=[
           'unreadSys'=>$unreadSys,
           'unreadEnt'=>$unreadEnt
       ];
       return CommonUtil::success($result);
   }
   
   /**
    * 获取未读消息
    * @return string
    */
   public function actionGetNotify(){
       $user=yii::$app->user->identity;
       $notify=Message::find()->andWhere(['to_user'=>$user->user_guid])->orderBy('created_at desc')->all();
        Message::updateAll(['is_read'=>1],['to_user'=>$user->user_guid]);
       return $this->renderAjax('notify',[
           'notify'=>$notify
       ]);
   }
   
   public function actionGetMsgnum(){
       $user=yii::$app->user->identity;
       $num=Message::find()->andWhere(['to_user'=>$user->user_guid,'is_read'=>0])->count();
       return CommonUtil::success($num);
   }

   
    /**
     * 更新支付宝信息
     * @author youngshunf
     * @return string
     *
     */

    public function actionUpdateAlipay(){
        //验证用户
        $user=yii::$app->user->identity;
        $data=$_POST['data'];
        $user->alipay=$data['alipay'];
        if($user->save()){
            return CommonUtil::success($user);
        }

        return CommonUtil::error('e1002');
    }
    
    public function actionUpdateName(){
        
        $clientUser=$_POST['user'];
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser['user_guid'],'access_token'=>$clientUser['access_token']])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->name=$data['name'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }
    public function actionUpdateNick(){
    
        $clientUser=yii::$app->user->identity;
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser->user_guid])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->nick=$data['nick'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }
    public function actionUpdateSex(){
    
        $clientUser=yii::$app->user->identity;
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser->user_guid])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->sex=$data['sex'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }
    public function actionUpdateSign(){
    
        $clientUser=yii::$app->user->identity;
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser->user_guid])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->sign=$data['sign'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }
    
    public function actionUpdateAddress(){
    
        $clientUser=yii::$app->user->identity;
        //验证用户
        $user=User::find()->andWhere(['user_guid'=>$clientUser->user_guid])->one();
        if(empty($user)){
            return CommonUtil::error('e1006');
        }
        $data=$_POST['data'];
        $user->address=$data['address'];
        if($user->save()){
            return CommonUtil::success($user);
        }
    
        return CommonUtil::error('e1002');
    }

    /**
     * 申请提现
     * @author youngshunf
     * @return string
     *
     */

    public function actionWithDraw(){
        $user=yii::$app->user->identity;
        $data=$_POST['data'];
        $amount=$data['amount'];
        $payPwd=$data['payPwd'];
        $authUser=User::findOne(['user_guid'=>$user->user_guid,'pay_password'=>md5($payPwd)]);
        if(empty($authUser)){
            return CommonUtil::error('e1007');
        }
        $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
        if(empty($wallet) || $amount==0 || empty($amount)){
            return CommonUtil::error('e1007');
        }
        if($wallet->balance <$amount){
            return CommonUtil::error('e1007');
        }
        $trans=yii::$app->db->beginTransaction();
        try{
            $withDrawRec=new WithdrawRec();
            $withDrawRec->user_guid=$user->user_guid;
            $withDrawRec->status=1;
            $withDrawRec->amount=$amount;
            $withDrawRec->created_at=time();

            if(!$withDrawRec->save()) throw new Exception();
                $wallet=Wallet::findOne(['user_guid'=>$user->user_guid]);
                $wallet->balance -= $amount;
                $wallet->withdrawing += $amount;
                $wallet->updated_at=time();
            if(!$wallet->save()) throw new Exception();
            $trans->commit();
             return CommonUtil::success('success');

        }catch(Exception $e){
            $trans->rollBack();
            return CommonUtil::error('e1002');
        }

    }
    
    public function actionUploadLocation(){
        $user=yii::$app->user->identity;
        $data=$_POST['data'];
        $locInfo=$data['locInfo'];
        $userLocation=new UserLocation();
        $userLocation->user_guid=$user->user_guid;
        $userLocation->lng=@$locInfo['lng'];
        $userLocation->lat=@$locInfo['lat'];
        $userLocation->address=@$locInfo['address'];
        $userLocation->locinfo=json_encode($locInfo);
        $userLocation->time=time();
        if($userLocation->save()){
            return CommonUtil::success('success');
        }
        
        return CommonUtil::error('e1002');
    }
    
    public function actionGetUserLocation() {
        $user=yii::$app->user->identity;
        $data=$_POST['data'];
        $locUser=$data['user'];
        $locInfo=UserLocation::find()->andWhere(['user_guid'=>$locUser])->orderBy('time desc')->one();
        if(empty($locInfo)){
            return CommonUtil::error('e1002');
        }
        $locInfo['time']=CommonUtil::fomatTime($locInfo->time);
        
        return CommonUtil::success($locInfo);
    }
    
    public function actionUpdateShareScore(){
        $user=yii::$app->user->identity;
        CommonUtil::calScore('share', $user->user_guid);
    }



}
