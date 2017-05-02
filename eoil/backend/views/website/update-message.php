<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HomePhoto */

$this->title = '发送系统消息';
$this->params['breadcrumbs'][] = ['label' => '系统消息', 'url' => ['message']];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="box box-success">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <?= $this->render('_message_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
