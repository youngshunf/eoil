<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchAuctionGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品分类';
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
        <?= Html::a('增加分类', ['create-cate'], ['class' => 'btn btn-success']) ?>
    </p>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
           ['attribute'=>'是否车类','value'=>function ($model){
               return $model->is_car==0?'否':'是';
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
					
					       return  Html::a('修改  ', $url, ['title' => '修改分类'] );					       												   
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
