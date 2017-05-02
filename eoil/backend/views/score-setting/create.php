<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ScoreSetting */

$this->title = '新增积分';
$this->params['breadcrumbs'][] = ['label' => '积分设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
