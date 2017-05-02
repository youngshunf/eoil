<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => '财务管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.name',
            'user.mobile',
            'balance',
            'paid',
            'total_amount',
            'frozen',
        ],
    ]) ?>

</div>
</div>

<div class="box box-warning">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= $model->user->name ?>的收入记录
        </div>
    </div>
    <div class="box-body">
  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'amount',
            'number',
            ['attribute'=>'status',
              'value'=>function($model){
              return CommonUtil::getDescByValue('income_rec', 'status', $model->status);
                 }
             ],
            
            ['attribute'=>'created_at',
              'format'=>['date','php:Y-m-d H:i:s']
             ],

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{view-income-rec}',
                'buttons'=>[
                    'view-income-rec'=>function ($url,$model,$key){
                    return  Html::a('查看详情', $url, ['title' => '查看详情'] );
                    },
                    ]
                
    ],
        ],
    ]); ?>

</div>
</div>