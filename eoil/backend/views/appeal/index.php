<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchAppeal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '申诉管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            ['attribute'=>'type',
               'value'=>function ($model){
                return CommonUtil::getDescByValue('appeal', 'type', $model->type);
            }],
            'orderno',
             ['attribute'=>'result',
               'value'=>function ($model){
                return CommonUtil::getDescByValue('appeal', 'result', $model->result);
            }],
             'remark',
             'reason:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function ($url,$model,$key){
                    return  Html::a('查看 ', $url, ['title' => '查看'] );
                    },
                    ]
            ],
        ],
    ]); ?>

</div>
</div>
