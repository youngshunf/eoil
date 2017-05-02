<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
?>

 <div class="panel-white"> 
<div class="">
  <h4><?= Html::encode($model->title) ?></h4>
</div>
  

   
    <?= $model->content?>
    <div class="news-info ">
  <p> <span class="glyphicon glyphicon-time" ></span><?= CommonUtil::fomatDate($model->created_at)?>
    <span class="glyphicon glyphicon-eye-open pull-right" >  <?= $model->count_view?> </span></p>
</div>
</div>




