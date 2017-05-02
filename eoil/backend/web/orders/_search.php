<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchOrders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'seller_uid') ?>

    <?= $form->field($model, 'buyer_uid') ?>

    <?= $form->field($model, 'order_type') ?>

    <?= $form->field($model, 'orderno') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'goodsid') ?>

    <?php // echo $form->field($model, 'goods_price') ?>

    <?php // echo $form->field($model, 'cateid') ?>

    <?php // echo $form->field($model, 'goods_name') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'is_seller_pay') ?>

    <?php // echo $form->field($model, 'is_buyer_pay') ?>

    <?php // echo $form->field($model, 'buyer_deposit') ?>

    <?php // echo $form->field($model, 'seller_deposit') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'seller_pay_time') ?>

    <?php // echo $form->field($model, 'seller_confirm_time') ?>

    <?php // echo $form->field($model, 'is_seller_confirm') ?>

    <?php // echo $form->field($model, 'is_buyer_confirm') ?>

    <?php // echo $form->field($model, 'break_uid') ?>

    <?php // echo $form->field($model, 'break_time') ?>

    <?php // echo $form->field($model, 'break_type') ?>

    <?php // echo $form->field($model, 'cancel_uid') ?>

    <?php // echo $form->field($model, 'cancel_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'buyer_pay_time') ?>

    <?php // echo $form->field($model, 'deal_time') ?>

    <?php // echo $form->field($model, 'buyer_confirm_time') ?>

    <?php // echo $form->field($model, 'cancel_time') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'year_month') ?>

    <?php // echo $form->field($model, 'year_month_day') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
