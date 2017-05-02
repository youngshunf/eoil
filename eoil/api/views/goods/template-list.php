<?php

use common\models\CommonUtil;
use common\models\GoodsPhoto;
?>	
 <?php if(!empty($goods)){?>
<ul class="mui-table-view">
		<?php foreach ($goods as $v){
		   $photo=GoodsPhoto::findOne(['goodsid'=>$v->goodsid]);
		    ?>
		<li class="mui-table-view-cell mui-media " >
					<div class="mui-slider-right mui-disabled ">
						<a class="mui-btn mui-btn-red del-temp" data-id="<?= $v->id?>">删除</a>
					</div>
					<div class="mui-slider-handle template" data-id="<?= $v->id?>" style="max-width: 100%;">
					  <div class="cart-container-left">
					  <img class="img-responsive"  src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>">
					  	</div>
					  	<div class="cart-container-right">
					  	<div ><p><?= $v->name?></p>
    					<p><span class="red">￥ <?= $v->price ?></span>  <?= $v->unit?></p>
    					<p class="sub-txt"><span class="mui-icon mui-icon-location sub-txt"></span><?= $v->address?></p>
					  	</div>
					  	<div class="clear"></div>
					</div>
		</li>
    <?php }?>
    </ul>
   <?php }else{?>
    <div class="empty-cart pay-result"> 
		<p class="text-center">您还没有模板,可以直接发布商品.</p>
	   <p class="text-center" style="margin-top: 20px;"><span class="iconfont icon-jia1 success pub-new"></span></p>
	</div>
  <?php }?>