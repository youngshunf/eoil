<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWallet */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-warning">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
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
            'user.name',
            'user.mobile',
            'user.alipay',
            'amount',
            ['attribute'=>'status',
            'value'=>function ($model){
                return CommonUtil::getDescByValue('withdraw', 'status', $model->status);
                }
            ],
            ['attribute'=>'created_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['attribute'=>'updated_at',
            'format'=>['date','php:Y-m-d H:i:s']
            ],
            

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{alipay-money}{refuse}',
                'buttons'=>[
                    'pay-money'=>function ($url,$model,$key){
                     if($model->status==1)
                        return  Html::a('支付宝付款 | ', $url, ['title' => '付款'] );
                        },
                    'refuse'=>function ($url,$model,$key){
                    if($model->status==1)
                     return  Html::a('驳回 | ', $url, ['title' => '驳回'] );
                    },
                    'bank-pay'=>function ($url,$model,$key){
                    if($model->status==1)
                        return  Html::a('银行付款', $url, ['title' => '银行付款'] );
                    },
                    ]
    ],
        ],
    ]); ?>

</div>
</div>