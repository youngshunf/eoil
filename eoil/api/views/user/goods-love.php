<?php

use common\models\GoodsPhoto;
use common\models\CommonUtil;
use common\models\Goods;

?>	

<?php if(!empty($goodsLove)){?>
<ul  class="mui-table-view">
 <?php foreach ($goodsLove as $k=>$v){
     $goodsPhoto=GoodsPhoto::findOne(['goodsid'=>$v->goodsid]);
     $goods=Goods::findOne($v->goodsid);
     if(!empty($goods)){
     ?>
				<li class="mui-table-view-cell">
					<div class="mui-slider-right mui-disabled">
						<a class="mui-btn mui-btn-red mui-delete-cart" data-id="<?= $v->id?>">删除</a>
					</div>
					<div class="mui-slider-handle  goods" data-id="<?= $v->goodsid?>"style="max-width: 100%;"  >
					  <div class="cart-container-left">
					  	<img src="<?= yii::$app->params['photoUrl'].$goodsPhoto->path.'mobile/'.$goodsPhoto->photo?>" />
					  	</div>
					  	<div class="cart-container-right">
					  	<p class="mui-ellipsis"><?= $v->goods->name?></p>
					  	<p ><span class="red">￥<?= $v->goods->price?></span> <?= @$v->goods->unit?></p>
					  	<p class="sub-txt"><span class="mui-icon mui-icon-location sub-txt"></span><?= $v->goods->address?></p>
					    <p class="sub-txt">
    					<?php 
    					if($goods->user->is_auth==1){
    					if($goods->userAuth->user_type==1){?>
    					<span><?= CommonUtil::truncateName($goods->userAuth->name)?> </span>
    					<?php }elseif ($goods->userAuth->user_type==2){?>
    					<span><?= $goods->userAuth->company_name?> </span>
    					<?php }}?> 
    					 </p>
					  	</div>
					  	<div class="clear"></div>
					</div>
		</li>
		<?php } }?>
		
	</ul>
	
	<?php }else{?>
	<div class="empty-cart"> 您还没有喜欢的商品哦，先去逛逛吧!</div>
	<?php }?>