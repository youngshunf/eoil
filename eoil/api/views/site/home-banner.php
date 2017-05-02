<?php
use common\models\CommonUtil;
/* @var $this yii\web\View */
?>

		<?php foreach ($news as $v){?>
		<div class="swiper-slide news" data-newsid="<?= $v->newsid?>">
		<img src="<?= yii::$app->params['photoUrl'].$v->path.'mobile/'.$v->photo ?>" class="img-responsive" >
		</div>
		
    <?php }?>
    
