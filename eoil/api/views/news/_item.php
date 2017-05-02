<?php

use yii\web\View;
use yii\widgets\LinkPager;
use common\models\CommonUtil;
use yii\helpers\Url;

?>

<a href="<?= Url::to(['view','id'=>$model['newsid']])?>">
   <ul class="mui-table-view">
    <li class="mui-table-view-cell mui-media " >
				<img class="mui-media-object mui-pull-left" class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'thumb/'.$model->photo  ?>">
				<div class="mui-media-body">
					<p class="" ><?= @$model->title?></p>
					
				     <p class="bottom-info " >
                       <?= CommonUtil::fomatDate($model->created_at)?>
                     </p>
                     <div class="clear"></div>
				</div>
	</li>
	</ul>
</a>
