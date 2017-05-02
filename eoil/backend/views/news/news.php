<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchNews */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =$cate->name;
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
        <?= Html::a('发布', ['create','id'=>$cate->cateid], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

        
            'title',
           ['attribute'=>'内容','value'=>function ($model){
               return CommonUtil::cutHtml($model->content, 50);
           }],
           ['attribute'=>'发布时间','value'=>function ($model){
               return CommonUtil::fomatTime($model->created_at);
           }],
         
              [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
            	'template'=>'{view}{update}{delete}{recommend}',
	             'buttons'=>[
					'view'=>function ($url,$model,$key){
	                     return  Html::a('查看 | ', $url, ['title' => '查看资讯'] );
					},
					'update'=>function ($url,$model,$key){
					
					       return  Html::a('修改 | ', $url, ['title' => '修改资讯'] );					       												   
				},
					'delete'=>function ($url,$model,$key){
					return  Html::a('删除 | ', $url, ['title' => '删除资讯', 'data-confirm'=>'是否确定删除该资讯？'] );
					},
					
					'recommend'=>function ($url,$model,$key){
					if($model->is_recommend==0)
					return  Html::a('推荐 ', $url, ['title' => '推荐资讯', 'data-confirm'=>'是否确定推荐该资讯？'] );					
					if($model->is_recommend==1)
					    return  Html::a('取消推荐', $url, ['title' => '取消推荐', 'data-confirm'=>'是否确定取消推荐？'] );
						
					},
					
				]
           	],
        ],
    ]); ?>
</div>
</div>

