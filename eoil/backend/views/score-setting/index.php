<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '积分设置';
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
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],

            'type',
            'score',
            'desc',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{update}',
                'buttons'=>[
                    'update'=>function ($url,$model,$key){
                    return  Html::a('修改', $url, ['title' => '修改设置'] );
                    },
                    ]
    ],
        ],
    ]); ?>

</div>
</div>
