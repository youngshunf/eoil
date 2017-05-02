<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UnitSet */

$this->title = '修改系统设置 ';
$this->params['breadcrumbs'][] = ['label' => '设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">


    <?= $this->render('_sysset_form', [
        'model' => $model,
    ]) ?>

</div>
</div>