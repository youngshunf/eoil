<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ScoreSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="score-setting-form">

    <?php $form = ActiveForm::begin(); ?>
   <?php if($model->isNewRecord){?>
    <?= $form->field($model, 'type')->textInput(['maxlength' => '64']) ?>
    <?php }?>

    <?= $form->field($model, 'score')->textInput() ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
