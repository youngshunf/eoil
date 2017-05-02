<?php
use common\models\CommonUtil;
use common\models\GoodsPhoto;
/* @var $this yii\web\View */
?>

		<ul class="mui-table-view mui-grid-view mui-grid-9">
		<?php foreach ($goods as $v){
		   $photo=GoodsPhoto::findOne(['goodsid'=>$v->id]);
		    ?>
		<li class="mui-table-view-cell mui-col-xs-6 mui-media goods" data-id="<?= $v->id?>">
		<table style="width: 100%;">
			<tr>
				<td width="70%">
				<div style="text-align: left;"><p class="mui-ellipsis-2" ><?= $v->name?></p></div>
				<div style="font-size: 12px;text-align: left;">
					<p ><span class="red">￥<?= $v->price ?></span> </p>
					 <span>  <?= $v->unit?></span>
				</div>
				</td>
				<td width="30%">
					<img src="<?= yii::$app->params['photoUrl'].$photo->path.'thumb/'.$photo->photo?>" class="img-responsive" style="padding: 0;" />
				</td>
			</tr>
		</table>
		
		</li>
	    <?php }?>
    </ul>
