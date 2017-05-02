<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UnitSet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-set-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'keep_expire')->textInput(['maxlength' => 6]) ?>

	<?= $form->field($model, 'withdraw_deposit')->textInput(['maxlength' => 12]) ?>
	<?= $form->field($model, 'deposit_rate')->textInput(['maxlength' => 12]) ?>
	<?= $form->field($model, 'car_deposit_rate')->textInput(['maxlength' => 12]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
