<?php
use common\models\CommonUtil;
/* @var $this yii\web\View */
?>

		<ul class="mui-table-view">
		<?php foreach ($news as $v){?>
		<li class="mui-table-view-cell mui-media news" data-newsid="<?= $v->newsid?>">
				<img class="mui-media-object mui-pull-left" class="img-responsive" src="<?= yii::$app->params['photoUrl'].$v->path.'thumb/'.$v->photo  ?>">
				<div class="mui-media-body">
					<div class="title" ><?= @$v->title?></div>
					<p class='mui-ellipsis'><span class="sub-txt"><?= CommonUtil::fomatDate(@$v->created_at)?></span></p>
				</div>
		</li>
    <?php }?>
    </ul>
