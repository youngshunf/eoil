<?php

use common\models\CommonUtil;
use common\models\GoodsPhoto;
?>	
 
<ul class="mui-table-view">
		<?php foreach ($goods as $v){
		   $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
		    ?>
		<li class="mui-table-view-cell mui-media goods" data-id="<?= $v->id?>">
			<a href="javascript:;">
				<img class="mui-media-object mui-pull-left" src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>">
				<div class="mui-media-body">
					<div class="title "><?= $v->name?>
					<p><span class="red">￥ <?= $v->price ?></span>  <?= $v->unit?></p>
					<p class="sub-txt"><span class="mui-icon mui-icon-location sub-txt"></span><?= $v->address?></p>
					<p class="sub-txt">
					<?php 
					if($v->user->is_auth==1){
					if($v->userAuth->user_type==1){?>
					<span><?=  CommonUtil::truncateName($v->userAuth->name)?> </span>
					<?php }elseif ($v->userAuth->user_type==2){?>
					<span><?= $v->userAuth->company_name?> </span>
					<?php } }?> 
					 <?= CommonUtil::fomatTime($v->created_at)?> </p></div>
					
				</div>
			</a>
		</li>
    <?php }?>
    </ul>
