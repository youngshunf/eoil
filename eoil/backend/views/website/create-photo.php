<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\HomePhoto */

$this->title = '发送系统消息';
$this->params['breadcrumbs'][] = ['label' => '系统消息', 'url' => ['message']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-photo-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_photo_form', [
        'model' => $model,
    ]) ?>

</div>
