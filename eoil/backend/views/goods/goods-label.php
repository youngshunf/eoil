<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =$goodsDetail->atb_item_details->aitaobao_item_detail->item->title;
$aitaobao_item_detail=$goodsDetail->atb_item_details->aitaobao_item_detail->item;
$this->params['breadcrumbs'][] = $this->title;
?>
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
    <a href="<?= $aitaobao_item_detail->detail_url?>" target="_blank">
       <img alt="主图" src="<?= $goodsDetail->atb_item_details->aitaobao_item_detail->item->pic_url?>" class="img-responsive">
     </a>
       
    </div>
 	
 	
     </div>
    
    
    <div class="col-sm-6">
    <div class="goods-intro">
 	<p >价格: <span class="red">￥ <?=$aitaobao_item_detail->price ?></span></p>
 	<p >平邮:<?=$aitaobao_item_detail->post_fee ?> 快递: <?=$aitaobao_item_detail->express_fee ?>  邮政: <?=$aitaobao_item_detail->ems_fee ?></p>
 	</div>
 	<form action="<?= Url::to(['submit-label'])?>" method="post">
 	<input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
 	<input type="hidden" name="open_iid" value="<?= $aitaobao_item_detail->open_iid?>">
    <div class="goods-intro">
      <div class="row">
      <div class="col-xs-6">
       <div class="label-select"> <span class="label bg-danger">量感</span> :  
      <input type="radio" name="sense" value='1' <?php if($action=='update'&&$goods->sense==1) echo 'checked'?> > 大 
       <input type="radio" name="sense" value='2' <?php if($action=='update'&&$goods->sense==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="sense" value='3' <?php if($action=='update'&&$goods->sense==3) echo 'checked'?>><span>小</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger">曲直</span> :  
       <input type="radio" name="straight" value='1' <?php if($action=='update'&&$goods->straight==1) echo 'checked'?>><span>直</span> 
       <input type="radio" name="straight" value='2' <?php if($action=='update'&&$goods->straight==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="straight" value='3' <?php if($action=='update'&&$goods->straight==3) echo 'checked'?>><span>曲</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger"> 动静</span> :  
       <input type="radio" name="movement" value='1' <?php if($action=='update'&&$goods->movement==1) echo 'checked'?>><span>动</span> 
       <input type="radio" name="movement" value='2' <?php if($action=='update'&&$goods->movement==2) echo 'checked'?>><span>中</span> 
       <input type="radio" name="movement" value='3' <?php if($action=='update'&&$goods->movement==3) echo 'checked'?>><span>静</span> 
        </div>
        
      </div>
      
        <div class="col-xs-6">
       <div class="label-select"> <span class="label bg-danger">冷暖</span> :  
       <input type="radio" name="cold_warm" value='1' <?php if($action=='update'&&$goods->cold_warm==1) echo 'checked'?>><span>冷</span> 
       <input type="radio" name="cold_warm" value='2' <?php if($action=='update'&&$goods->cold_warm==2) echo 'checked'?>><span>暖</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger">明度</span> :  
       <input type="radio" name="lightness" value='1' <?php if($action=='update'&&$goods->lightness==1) echo 'checked'?>><span>深</span> 
       <input type="radio" name="lightness" value='2' <?php if($action=='update'&&$goods->lightness==2) echo 'checked'?>><span>浅</span> 
        </div>
        <div class="label-select"> <span class="label bg-danger"> 纯度</span> :  
       <input type="radio" name="purity" value='1' <?php if($action=='update'&&$goods->purity==2) echo 'checked'?>><span>艳</span> 
       <input type="radio" name="purity" value='2' <?php if($action=='update'&&$goods->purity==2) echo 'checked'?>><span>柔</span> 
        </div>
      </div>
      <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">肤色</span> :  
       <input type="radio" name="skin_color" value='1' <?php if($action=='update'&&$goods->skin_color==1) echo 'checked'?>><span>自然白皙红润</span> 
       <input type="radio" name="skin_color" value='2' <?php if($action=='update'&&$goods->skin_color==2) echo 'checked'?>><span>自然色</span> 
       <input type="radio" name="skin_color" value='3' <?php if($action=='update'&&$goods->skin_color==3) echo 'checked'?>><span>自然偏黄</span> 
       <input type="radio" name="skin_color" value='4' <?php if($action=='update'&&$goods->skin_color==4) echo 'checked'?>><span>暗黄</span> 
        </div>
        </div>
        
       <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">适合体型</span> :  
       <input type="radio" name="shape" value='1' <?php if($action=='update'&&$goods->shape==1) echo 'checked'?>><span>H</span> 
       <input type="radio" name="shape" value='2' <?php if($action=='update'&&$goods->shape==2) echo 'checked'?>><span>A</span> 
       <input type="radio" name="shape" value='3' <?php if($action=='update'&&$goods->shape==3) echo 'checked'?>><span>T</span> 
       <input type="radio" name="shape" value='4' <?php if($action=='update'&&$goods->shape==4) echo 'checked'?>><span>O</span> 
       <input type="radio" name="shape" value='5' <?php if($action=='update'&&$goods->shape==5) echo 'checked'?>><span>X</span> 
        </div>
        </div>
        
         
        
         <div class="col-xs-12">
       <div class="label-select"> <span class="label bg-danger">服装风格</span> :  
       <input type="radio" name="style" value='1' <?php if($action=='update'&&$goods->style==1) echo 'checked'?>><span>少女</span> 
       <input type="radio" name="style" value='2' <?php if($action=='update'&&$goods->style==2) echo 'checked'?>><span>少年</span> 
       <input type="radio" name="style" value='3' <?php if($action=='update'&&$goods->style==3) echo 'checked'?>><span>自然</span> 
       <input type="radio" name="style" value='4' <?php if($action=='update'&&$goods->style==4) echo 'checked'?>><span>优雅</span> 
       <input type="radio" name="style" value='5' <?php if($action=='update'&&$goods->style==5) echo 'checked'?>><span>古典</span> 
        <input type="radio" name="style" value='6' <?php if($action=='update'&&$goods->style==6) echo 'checked'?>><span>自然异域</span> 
         <input type="radio" name="style" value='7' <?php if($action=='update'&&$goods->style==7) echo 'checked'?>><span>前卫</span> 
         <input type="radio" name="style" value='8' <?php if($action=='update'&&$goods->style==8) echo 'checked'?>><span>浪漫</span> 
         <input type="radio" name="style" value='9' <?php if($action=='update'&&$goods->style==9) echo 'checked'?>><span>戏剧</span> 
        </div>
        </div>
        
          <div class="col-xs-12">
       <div class="label-select"><label> <span class="label bg-danger">场合分类</span> :  
       <input type="checkbox" name="occasion_cate[]" value='1' <?php if($action=='update'&&strpos($goods->occasion_cate, '1')!==false) echo 'checked'?>><span>专业职场</span> 
       <input type="checkbox" name="occasion_cate[]" value='2' <?php if($action=='update'&&strpos($goods->occasion_cate, '2')!==false) echo 'checked'?>><span>休闲职场</span> 
       <input type="checkbox" name="occasion_cate[]" value='3' <?php if($action=='update'&&strpos($goods->occasion_cate, '3')!==false) echo 'checked'?>><span>严肃社交</span> 
       <input type="checkbox" name="occasion_cate[]" value='4' <?php if($action=='update'&&strpos($goods->occasion_cate, '4')!==false) echo 'checked'?>><span>休闲社交</span> 
       <input type="checkbox" name="occasion_cate[]" value='5' <?php if($action=='update'&&strpos($goods->occasion_cate, '5')!==false) echo 'checked'?>><span>严肃生活</span> 
        <input type="checkbox" name="occasion_cate[]" value='6' <?php if($action=='update'&&strpos($goods->occasion_cate, '6')!==false) echo 'checked'?>><span>休闲生活</span> 
         <input type="checkbox" name="occasion_cate[]" value='7' <?php if($action=='update'&&strpos($goods->occasion_cate, '7')!==false) echo 'checked'?>><span>时尚生活</span> 
         <input type="checkbox" name="occasion_cate[]" value='8' <?php if($action=='update'&&strpos($goods->occasion_cate, '8')!==false) echo 'checked'?>><span>运动生活</span> 
         </label>
        </div>
        
        </div>
         <div class="col-xs-12">
       <div class="label-select"><p> <span class="label bg-danger">产品分类</span> : </p>
        <select name="cate" class="form-control">
        <?php foreach ($cate as $v){?>
        <option value="<?= $v->id?>"  <?php if($action=='update'&&$goods->cateid==$v->id) echo 'selected'?>><?= $v->name?></option>
        <?php }?>
        </select> 
        </div>
        </div>
         <div class="col-xs-12">
       <p class="center"> <button class="btn btn-danger   type="submit"><?= $action=='new'?'提交数据':'修改数据'?> </button></p>
       </div>
      </div>
     
    </div>
    </form>
    
    </div>
    
    </div>
    <div class="box-header width-border">
          <h5>宝贝详情</h5>  
    </div>
    <div class="row">
    <div class="col-xs-12">
    <?= $aitaobao_item_detail->desc ?>
    </div>
    </div>
</div>
</div>


