<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ScoreSetting */

$this->title = '修改积分设置: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '积分设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
