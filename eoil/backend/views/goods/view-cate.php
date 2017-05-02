<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <p>
        <?= Html::a('修改', ['update-cate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if($model->is_default==0){?>
        <?= Html::a('删除', ['delete-cate', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除此项目?',
                'method' => 'post',
            ],
        ]) ?>
        <?php }?>
    </p>
    <div class="row">
  <div class="col-md-6">
   <img alt="封面图片" src="<?= yii::$app->params['photoUrl'].$model->path.$model->photo?>" class="img-responsive">
  </div>
  <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'desc',
           ['attribute'=>'创建时间','value'=>CommonUtil::fomatTime($model->created_at)],
            ['attribute'=>'更新时间','value'=>CommonUtil::fomatTime($model->updated_at)],
        ],
    ]) ?>
 </div>
 </div>
 </div>
 </div>
 <div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
           下级分类
        </div>
    </div>
    <div class="box-body">

     <?= GridView::widget([
        'dataProvider' => $cateData,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],        
            'name',
           ['attribute'=>'描述','value'=>function ($model){
               return CommonUtil::cutHtml($model->desc, 50);
           }],
           ['attribute'=>'创建时间','value'=>function ($model){
               return CommonUtil::fomatTime($model->created_at);
           }],
            
                [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
            	'template'=>'{view-cate}{update-cate}{delete-cate}',
	             'buttons'=>[
					'view-cate'=>function ($url,$model,$key){
	                     return  Html::a('查看 | ', $url, ['title' => '查看分类'] );
					},
					'update-cate'=>function ($url,$model,$key){
					
					       return  Html::a('修改 ', $url, ['title' => '修改分类'] );					       												   
				},
					'delete-cate'=>function ($url,$model,$key){
					 if($model->is_default==0)
					   return  Html::a(' | 删除', $url, ['title' => '删除分类', 'data-confirm'=>'是否确定删除该分类以及该分类下的所有商品？'] );
					},
					
				]
           	],
        ],
    ]); ?>
</div>
</div>

 <div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            分类产品
        </div>
    </div>
    <div class="box-body">
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
         ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

            'name',
            'price',
            ['attribute'=>'created_at',
              'format'=>['date','php:Y-m-d H:i:s']
             ],

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view'=>function ($url,$model,$key){
                    return  Html::a('查看 | ', $url, ['title' => '查看商品'] );
                    },
                    'update'=>function ($url,$model,$key){
                    return  Html::a('修改 | ', $url, ['title' => '修改商品'] );
                    },
                    'delete'=>function ($url,$model,$key){
                    return  Html::a('删除 ', $url, ['title' => '删除分类', 'data-confirm'=>'是否确定删除该商品？','data-method'=>'post'] );
                    },
                    ],
             ],
        ],
    ]); ?>
</div>
</div>
</div>
