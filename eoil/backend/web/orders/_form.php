<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'seller_uid')->textInput() ?>

    <?= $form->field($model, 'buyer_uid')->textInput() ?>

    <?= $form->field($model, 'order_type')->textInput() ?>

    <?= $form->field($model, 'orderno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'goodsid')->textInput() ?>

    <?= $form->field($model, 'goods_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cateid')->textInput() ?>

    <?= $form->field($model, 'goods_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'is_seller_pay')->textInput() ?>

    <?= $form->field($model, 'is_buyer_pay')->textInput() ?>

    <?= $form->field($model, 'buyer_deposit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seller_deposit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seller_pay_time')->textInput() ?>

    <?= $form->field($model, 'seller_confirm_time')->textInput() ?>

    <?= $form->field($model, 'is_seller_confirm')->textInput() ?>

    <?= $form->field($model, 'is_buyer_confirm')->textInput() ?>

    <?= $form->field($model, 'break_uid')->textInput() ?>

    <?= $form->field($model, 'break_time')->textInput() ?>

    <?= $form->field($model, 'break_type')->textInput() ?>

    <?= $form->field($model, 'cancel_uid')->textInput() ?>

    <?= $form->field($model, 'cancel_type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'buyer_pay_time')->textInput() ?>

    <?= $form->field($model, 'deal_time')->textInput() ?>

    <?= $form->field($model, 'buyer_confirm_time')->textInput() ?>

    <?= $form->field($model, 'cancel_time')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year_month_day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
