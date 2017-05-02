<?php

use common\models\GoodsPhoto;
use common\models\CommonUtil;
?>	
       
       <?php if(!empty($cates)){?>
		<div  class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted" >
			<div class="mui-scroll">
		    <?php foreach ($cates as $k=>$v){?>
				
				<a class="mui-control-item goods-cate" href="#" data-cateid="<?= $v->id?>">
					<?= $v->name?>
				</a>
		
			<?php }?>
			</div>
		</div>
		<?php }?>
			
				 <ul class="mui-table-view">
				 <?php  foreach ($pGoods as $item){
				      $photo=GoodsPhoto::findOne(['goodsid'=>$item->id])?>
				 	<li class="mui-table-view-cell mui-media goods" data-id="<?= $item->id?>">
					<a href="javascript:;">
						<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>">
						<div class="mui-media-body">
							<div class="title ">
							<p><?= $item->name?></p>
							<p><span class="red">￥ <?= $item->price ?> </span> <span class="sub-txt"> <?= $item->unit?></span></p>
							<p class="sub-txt"><span class="mui-icon mui-icon-location sub-txt"></span><?= $item->address?></p>
							<p class="sub-txt">
					<?php 
					if($item->user->is_auth==1){
					if($item->userAuth->user_type==1){?>
					<span><?=  CommonUtil::truncateName($item->userAuth->name)?> </span>
					<?php }elseif ($item->userAuth->user_type==2){?>
					<span><?= $item->userAuth->company_name?> </span>
					<?php } }?> 
					 <?= CommonUtil::fomatTime($item->created_at)?> </p>
							</div>
						</div>
					</a>
				</li>
				<?php }?>
				 </ul>
				 <p class="hide" id="cate-name" data-name="<?= $cate->name?>"></p>
			  