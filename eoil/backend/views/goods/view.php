<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\CommonUtil;
use yii\widgets\DetailView;
use common\models\GoodsPhoto;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =$model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
    <div class="row">
    
    <div class="col-sm-6">
    <?php $goodsPhoto=GoodsPhoto::findAll(['goodsid'=>$model->id]);
    foreach ($goodsPhoto as $v){?>
    <div class="goods-img">
       <img alt="主图" src="<?= yii::$app->params['photoUrl'].$v->path.$v->photo?>" class="img-responsive">
       
    </div>
   <?php }?>
 	
     </div>
    
    
    <div class="col-sm-6">
  	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'price',
            'stock',
           ['attribute'=>'创建时间','value'=>CommonUtil::fomatTime($model->created_at)],
            ['attribute'=>'更新时间','value'=>CommonUtil::fomatTime($model->updated_at)],
        ],
    ]) ?>
    
    </div>
    
    </div>
    <div class="box-header width-border">
          <h5>宝贝详情</h5>  
    </div>
    <div class="row">
    <div class="col-xs-12">
    <?= $model->desc ?>
    </div>
    </div>
</div>
</div>


