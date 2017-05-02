<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\HomePhoto */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '网站管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-success">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <p>
        <?= Html::a('修改', ['update-siteinfo', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

   <?= $model->content?>
</div>
</div>