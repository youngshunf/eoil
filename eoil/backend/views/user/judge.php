<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title ='用户形象诊断';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.user-info{
	padding:10px
}
.user-info p{
	text-align:left
}
</style>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
    <div class="row">
    <div class="col-sm-6">
    <div class="goods-img">
     <div class="row">
     <div class="col-xs-6">
       <p>五官照</p>
      <a href="#" target="_blank">
       <img alt="主图"  style="max-width: 100%" src="<?= yii::$app->params['photoUrl'].$model->userData->path1.$model->userData->photo1?>" class="img-responsive">
      </a>
     </div>
     <div class="col-xs-6">
       <p>全身照</p>
      <a href="#" target="_blank">
       <img alt="主图" style="max-width: 100%" src="<?= yii::$app->params['photoUrl'].$model->userData->path2.$model->userData->photo2?>" class="img-responsive">
      </a>
     </div>
     <div class="col-xs-12">
     <div class="user-info" >
      <p>性别 : <?= CommonUtil::getDescByValue('user', 'sex', $model->userData->sex)?></p>
      <p>年龄 : <?= $model->userData->age?></p>
      <p>体重 : <?= $model->userData->weight?></p>
      <p>身高 : <?= $model->userData->tall?></p>
      <p>职业 : <?= $model->userData->post?></p>
      <p>期望的风格 : <?= CommonUtil::getDescByValue('style', 'style', $model->userData->style)?></p>
      <p>体型 : <?= $model->userData->shape?></p>
      </div>
     </div>
     </div>
       
    </div>
 	
 	
     </div>
    
    
    <div class="col-sm-6">
    <div class="goods-intro">
 </div>
 	<form action="<?= Url::to(['submit-judge'])?>" method="post">
 	<input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
 	<input type="hidden" name="data_id" value="<?= $model->id?>">
 	<input type="hidden" name="user_guid" value="<?= $model->user_guid ?>">
    <div class="goods-intro">
      <div class="row">
      <div class="col-xs-6">
       <div class="label-select"> <span class="label bg-danger">量感</span> :  
      <input type="radio" name="sense" value='1' <?php if($action=='update'&&$model->userData->sense==1) echo 'checked'?> > 大 
       <input type="radio" name="sense" value='2' <?php if($action=='update'&&$model->userData->sense==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="sense" value='3' <?php if($action=='update'&&$model->userData->sense==3) echo 'checked'?>><span>小</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger">曲直</span> :  
       <input type="radio" name="straight" value='1' <?php if($action=='update'&&$model->userData->straight==1) echo 'checked'?>><span>直</span> 
       <input type="radio" name="straight" value='2' <?php if($action=='update'&&$model->userData->straight==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="straight" value='3' <?php if($action=='update'&&$model->userData->straight==3) echo 'checked'?>><span>曲</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger"> 动静</span> :  
       <input type="radio" name="movement" value='1' <?php if($action=='update'&&$model->userData->movement==1) echo 'checked'?>><span>动</span> 
       <input type="radio" name="movement" value='2' <?php if($action=='update'&&$model->userData->movement==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="movement" value='3' <?php if($action=='update'&&$model->userData->movement==3) echo 'checked'?>><span>静</span> 
        </div>
        
      </div>
      
        <div class="col-xs-6">
       <div class="label-select"> <span class="label bg-danger">冷暖</span> :  
       <input type="radio" name="cold_warm" value='1' <?php if($action=='update'&&$model->userData->cold_warm==1) echo 'checked'?>><span>冷</span> 
       <input type="radio" name="cold_warm" value='2' <?php if($action=='update'&&$model->userData->cold_warm==2) echo 'checked'?>><span>暖</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger">明度</span> :  
       <input type="radio" name="lightness" value='1' <?php if($action=='update'&&$model->userData->lightness==1) echo 'checked'?>><span>深</span> 
       <input type="radio" name="lightness" value='2' <?php if($action=='update'&&$model->userData->lightness==2) echo 'checked'?>><span>浅</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger"> 纯度</span> :  
       <input type="radio" name="purity" value='1' <?php if($action=='update'&&$model->userData->purity==2) echo 'checked'?>><span>艳</span> 
       <input type="radio" name="purity" value='2' <?php if($action=='update'&&$model->userData->purity==2) echo 'checked'?>><span>柔</span> 
        </div>
      </div>
      <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">肤色</span> :  
       <input type="radio" name="skin_color" value='1' <?php if($action=='update'&&$model->userData->skin_color==1) echo 'checked'?>><span>自然白皙红润</span> 
       <input type="radio" name="skin_color" value='2' <?php if($action=='update'&&$model->userData->skin_color==2) echo 'checked'?>><span>自然色</span> 
       <input type="radio" name="skin_color" value='3' <?php if($action=='update'&&$model->userData->skin_color==3) echo 'checked'?>><span>自然偏黄</span> 
       <input type="radio" name="skin_color" value='4' <?php if($action=='update'&&$model->userData->skin_color==4) echo 'checked'?>><span>暗黄</span> 
        </div>
        </div>
        
       <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">体型</span> :  
       <input type="radio" name="shape" value='1' <?php if($action=='update'&&$model->userData->shape==1) echo 'checked'?>><span>H</span> 
       <input type="radio" name="shape" value='2' <?php if($action=='update'&&$model->userData->shape==2) echo 'checked'?>><span>A</span> 
       <input type="radio" name="shape" value='3' <?php if($action=='update'&&$model->userData->shape==3) echo 'checked'?>><span>T</span> 
       <input type="radio" name="shape" value='4' <?php if($action=='update'&&$model->userData->shape==4) echo 'checked'?>><span>O</span> 
       <input type="radio" name="shape" value='5' <?php if($action=='update'&&$model->userData->shape==5) echo 'checked'?>><span>X</span> 
        </div>
        </div>
        
         
        
         <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">适合风格</span> :  
       <input type="radio" name="style" value='1' <?php if($action=='update'&&$model->userData->style==1) echo 'checked'?>><span>少女</span> 
       <input type="radio" name="style" value='2' <?php if($action=='update'&&$model->userData->style==2) echo 'checked'?>><span>少年</span> 
       <input type="radio" name="style" value='3' <?php if($action=='update'&&$model->userData->style==3) echo 'checked'?>><span>自然</span> 
       <input type="radio" name="style" value='4' <?php if($action=='update'&&$model->userData->style==4) echo 'checked'?>><span>优雅</span> 
       <input type="radio" name="style" value='5' <?php if($action=='update'&&$model->userData->style==5) echo 'checked'?>><span>古典</span> 
        <input type="radio" name="style" value='6' <?php if($action=='update'&&$model->userData->style==6) echo 'checked'?>><span>自然异域</span> 
         <input type="radio" name="style" value='7' <?php if($action=='update'&&$model->userData->style==7) echo 'checked'?>><span>前卫</span> 
         <input type="radio" name="style" value='8' <?php if($action=='update'&&$model->userData->style==8) echo 'checked'?>><span>浪漫</span> 
         <input type="radio" name="style" value='9' <?php if($action=='update'&&$model->userData->style==9) echo 'checked'?>><span>戏剧</span> 
        </div>
        </div>
        
         
         <div class="col-xs-12">
       <p class="center"> <button class="btn btn-danger   type="submit"><?= $action=='new'?'提交诊断':'修改诊断'?> </button></p>
       </div>
      </div>
     
    </div>
    </form>
    
    </div>
    
    </div>
</div>
</div>


