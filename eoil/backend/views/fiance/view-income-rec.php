<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Wallet */

$this->title = $model->user->name.'的收入详情';
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
            'amount',
            'number',
            ['attribute'=>'status',
              'value'=> CommonUtil::getDescByValue('income_rec', 'status', $model->status)
             ],
            ['attribute'=>'remark',
            'format'=> 'html'
            ],
             ['attribute'=>'created_at',
             'format'=>['date','php:Y-m-d H:i:s']
             ],
             
        ],
    ]) ?>

</div>
</div>

