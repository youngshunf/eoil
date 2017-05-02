<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOrders */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'seller_uid',
            'buyer_uid',
            'order_type',
            'orderno',
            // 'type',
            // 'goodsid',
            // 'goods_price',
            // 'cateid',
            // 'goods_name',
            // 'number',
            // 'is_seller_pay',
            // 'is_buyer_pay',
            // 'buyer_deposit',
            // 'seller_deposit',
            // 'amount',
            // 'seller_pay_time:datetime',
            // 'seller_confirm_time:datetime',
            // 'is_seller_confirm',
            // 'is_buyer_confirm',
            // 'break_uid',
            // 'break_time:datetime',
            // 'break_type',
            // 'cancel_uid',
            // 'cancel_type',
            // 'status',
            // 'buyer_pay_time:datetime',
            // 'deal_time:datetime',
            // 'buyer_confirm_time:datetime',
            // 'cancel_time:datetime',
            // 'remark',
            // 'year',
            // 'year_month',
            // 'year_month_day',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
