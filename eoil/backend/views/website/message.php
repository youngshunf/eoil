<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统通知';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">


    <p>
        <?= Html::a('发送系统通知', ['create-message'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'content',

           ['attribute'=>'created_at',
           'label'=>'时间',
           'format'=>['date', 'php:Y-m-d H:i:s']
           ],
       

               [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
            	'template'=>'{update-message}{delete-message}',
	             'buttons'=>[
					'update-message'=>function ($url,$model,$key){
					
					       return  Html::a('修改 | ', $url, ['title' => '修改通知'] );					       												   
				},
					'delete-message'=>function ($url,$model,$key){
					return  Html::a('删除 ', $url, ['title' => '删除通知', 'data-confirm'=>'是否确定删除该通知？'] );
					},
					
				]
           	],
        ],
    ]); ?>

</div>
</div>
