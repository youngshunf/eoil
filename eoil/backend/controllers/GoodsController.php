<?php

namespace backend\controllers;

use Yii;
use common\models\Goods;
use common\models\SearchGoods;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CommonUtil;
use common\models\ImageUploader;
use yii\filters\AccessControl;
use common\models\GoodsCate;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    
    {
        $dataProvider = new ActiveDataProvider([
            'query'=>GoodsCate::find()->andWhere(['parentid'=>0])->orderBy('created_at desc'),
            'pagination'=>[
                'pagesize'=>20
            ]
        ]);
         
         
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCollect()
    {
        $c = new \TopClient();
    	$c->appkey = yii::$app->params['appkey'];
    	$c->secretKey = yii::$app->params['secretKey'];
    	$keyword="女装";
    	$sort='1';
    	$sortDetail='all';
    	$page='1';
    	if(isset($_GET['keyword'])){
    	    $keyword=$_GET['keyword'];
    	}
    	if(isset($_GET['sort'])){
    	    $sort=$_GET['sort'];
    	}
    	if(isset($_GET['sortDetail'])){
    	    $sortDetail=$_GET['sortDetail'];
    	}
    	if(isset($_GET['page'])){
    	    $page=$_GET['page'];
    	}
    	
        if($sort=='2'){
        if($sortDetail=='price_desc'){
            $sortDetail='price_asc';
        }elseif ($sortDetail=='price_asc'){
            $sortDetail='price_desc';
        }else{
            $sortDetail='price_desc';
        }
        }
         if($sort=='3'){
            $sortDetail='credit_desc';
         }
         if($sort=='4'){
    	        if($sortDetail=='commissionNum_desc'){
    	            $sortDetail='commissionNum_asc';
    	        }elseif ($sortDetail=='commissionNum_asc'){
    	            $sortDetail='commissionNum_desc';
    	        }else{
    	            $sortDetail='commissionNum_desc';
    	        }
    	}
    	$req = new \AtbItemsGetRequest;
    	$req->setFields("open_iid,title,nick,pic_url,price,commission,commission_rate,commission_num,commission_volume,seller_credit_score,item_location,volume");
    	$req->setRealDescribe("true");
    	$req->setKeyword($keyword);
//     	$req->setCashCoupon("true");
//     	$req->setVipCard("true");
    	$req->setPageNo($page);
    	$req->setPageSize("20");
//     	$req->setSevendaysReturn("true");
       if($sort!=='1'&&$sortDetail!=='all'){
           $req->setSort($sortDetail);
       }
    	
//     	$req->setStartCredit("1heart");
//     	$req->setStartPrice("1");
//     	$req->setStartTotalnum("1");
    	$resp = $c->execute($req);
        return $this->render('collect', [
            'resp' => $resp,
            'keyword'=>$keyword,
            'sort'=>$sort,
            'sortDetail'=>$sortDetail,
            'page'=>$page
        ]);
    }
    
    public function actionGoodsLabel($open_iid){
        $action='new';
        $goods=Goods::findOne(['open_iid'=>$open_iid]);
        if(!empty($goods)){
            $goodsDetail=json_decode($goods->goods_detail);
            $action='update';
        }else{
            $goodsDetail=Goods::getAtbGoodsDetail($open_iid);
        }
        $cate=GoodsCate::find()->orderBy('created_at desc')->all();
        return  $this->render('goods-label',['goodsDetail'=>$goodsDetail,
            'action'=>$action,
            'goods'=>$goods,
            'cate'=>$cate
        ]);
    }
    
    public function actionSubmitLabel(){
        
        $data=yii::$app->request->post();
        $goodsDetail=Goods::getAtbGoodsDetail($data['open_iid']);
        
        $goods=Goods::findOne(['open_iid'=>$data['open_iid']]);
        if(empty($goods)){
            $goods=new Goods();
            $goods->created_at=time();
        }else{
            $goods->updated_at=time();
        }
        $aitaobao_item_detail=$goodsDetail->atb_item_details->aitaobao_item_detail->item;
        $goods->title=(string)$aitaobao_item_detail->title;
        $goods->user_guid=yii::$app->user->identity->user_guid;
       echo $goods->cateid=@$data['cate'];
        $goods->open_iid=$data['open_iid'];
        $goods->nick=(string)$aitaobao_item_detail->nick;
        $goods->pic_url=(string)$aitaobao_item_detail->pic_url;
        $goods->price=(string)$aitaobao_item_detail->price;
       $goods->item_location=json_encode($aitaobao_item_detail->loction);
        $goods->sense=@$data['sense'];
        $goods->straight=@$data['straight'];
        $goods->movement=@$data['movement'];
        $goods->cold_warm=@$data['cold_warm'];
        $goods->lightness=@$data['lightness'];
        $goods->purity=@$data['purity'];
        $goods->shape=@$data['shape'];
        $goods->skin_color=@$data['skin_color'];
        $goods->style=@$data['style'];
        $goods->occasion_cate=@implode(@$data['occasion_cate'], ',');
       $goods->goods_detail=json_encode($goodsDetail);
//         print_r($goods);die;
        if($goods->save()){
            return $this->redirect(['goods']);
        }
        yii::$app->getSession()->setFlash('success','数据提交失败!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionGoods()
    {
        $searchModel = new SearchGoods();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('goods', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionGoodsRec($id){
        $model=Goods::findOne($id);
        if($model->is_rec==0){
            yii::$app->getSession()->setFlash('success',$model->name."---推荐成功!");
            $model->is_rec=1;
        }else{
            yii::$app->getSession()->setFlash('success',$model->name."---已取消推荐!");
            $model->is_rec=0;
        }
        if($model->save()){
            return $this->redirect(yii::$app->request->referrer);
        }
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        return $this->render('view', [
            'model' =>$model ,
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->user_guid=yii::$app->user->identity->user_guid;
            $model->goods_guid=CommonUtil::createUuid();
            $model->desc=@$_POST['desc'];
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->created_at=time();
            if($model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $cate=GoodsCate::find()->orderBy('created_at desc')->all();
            return $this->render('create', [
                'model' => $model,
                'cate'=>$cate
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->desc=@$_POST['desc'];
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->updated_at=time();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $cate=GoodsCate::find()->orderBy('created_at desc')->all();
            return $this->render('update', [
                'model' => $model,
                'cate'=>$cate
            ]);
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['goods']);
    }
    
    public function actionDeleteCate($id)
    {
        GoodsCate::findOne($id)->delete();
       yii::$app->getSession()->setFlash('success','删除成功!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
  
    
    //新建分类
    public function actionCreateCate()
    {
        $model = new GoodsCate();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->user_guid=yii::$app->user->identity->user_guid;
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            if(empty($model->parentid)){
                $model->parentid=0;
            }
            if(isset($_POST['secCate'])){
                if($_POST['secCate']!=0){
                    $model->parentid=$_POST['secCate'];
                }
            }
            $model->created_at=time();
            if($model->save())
                return $this->redirect(['view-cate', 'id' => $model->id]);
        } else {
            $cate=GoodsCate::find()->andWhere(['parentid'=>0])->orderBy('created_at desc')->all();
            return $this->render('create-cate', [
                'model' => $model,
                'cate'=>$cate
            ]);
        }
    }
    
    public function actionGetCate(){
        $parentid=$_POST['parentid'];
        $cate=GoodsCate::findAll(['parentid'=>$parentid]);
        return Json::encode($cate);
    }
    
    public function actionUpdateCate($id)
    {
        $model = GoodsCate::findOne($id);
    
        if ($model->load(Yii::$app->request->post()) ) {
            $model->user_guid=yii::$app->user->identity->user_guid;
    
            $photo=ImageUploader::uploadByName('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            if(empty($model->parentid)){
                $model->parentid=0;
            }
            if(!empty($_POST['secCate'])){
                $model->parentid=$_POST['secCate'];
            }
            $model->created_at=time();
            if($model->save())
                return $this->redirect(['view-cate', 'id' => $model->id]);
        } else {
            $cate=GoodsCate::find()->andWhere(['parentid'=>0])->orderBy('created_at desc')->all();
            return $this->render('update-cate', [
                'model' => $model,
                'cate'=>$cate
            ]);
        }
    }
    
    public function actionViewCate($id)
    {
        $model=GoodsCate::findOne($id);
        $searchModel = new SearchGoods();
        $searchModel->cateid=$model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cateData=new ActiveDataProvider([
            'query'=>GoodsCate::find()->andWhere(['parentid'=>$id])->orderBy('created_at desc')
        ]);
        return $this->render('view-cate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cateData'=>$cateData,
            'model'=>$model
        ]);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
