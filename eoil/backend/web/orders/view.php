<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'seller_uid',
            'buyer_uid',
            'order_type',
            'orderno',
            'type',
            'goodsid',
            'goods_price',
            'cateid',
            'goods_name',
            'number',
            'is_seller_pay',
            'is_buyer_pay',
            'buyer_deposit',
            'seller_deposit',
            'amount',
            'seller_pay_time:datetime',
            'seller_confirm_time:datetime',
            'is_seller_confirm',
            'is_buyer_confirm',
            'break_uid',
            'break_time:datetime',
            'break_type',
            'cancel_uid',
            'cancel_type',
            'status',
            'buyer_pay_time:datetime',
            'deal_time:datetime',
            'buyer_confirm_time:datetime',
            'cancel_time:datetime',
            'remark',
            'year',
            'year_month',
            'year_month_day',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
