<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '发布产品';
$this->params['breadcrumbs'][] = ['label' => '产品管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
      <h5><?= Html::encode($this->title) ?></h5>
    </div>
    <div class="box-body">
 

    <?= $this->render('_form', [
        'model' => $model,
        'cate'=>$cate
    ]) ?>

</div>
</div>
