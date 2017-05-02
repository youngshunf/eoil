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
					<p><?= CommonUtil::fomatTime($v->created_at)?></p></div>
					<p><span class="red">￥ <?= $v->price ?></span>  <?= $v->unit?></p>
				</div>
			</a>
		</li>
    <?php }?>
    </ul>
