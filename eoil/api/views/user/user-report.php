<?php

use common\models\CommonUtil;
use yii;

?>	

<?php if($user->is_submit_data==0){?>
	<div class="tip-content">
	您还未提交您的数据，请先提交数据，然后等待形象狮为您诊断。
	<p class="mui-center"><a class="mui-btn mui-btn-warning" href="../home/collect.html">提交数据</a></p>
	</div>
<?php }else if ($user->is_judge==0){?>
	<div class="tip-content">
	您的数据已提交,请等待形象狮为您诊断。
	</div>
<?php }else if(!empty($userJudge) && $user->is_judge==1){?>
<ul class="mui-table-view mui-grid-view mui-grid-9 report-img">
							<li class="mui-table-view-cell mui-media mui-col-xs-6 mui-col-sm-6">
								<a href="#" >
									<div class="mui-media-body">五官照</div>
									<img src="<?= @yii::$app->params['photoUrl'].$userData->path1.$userData->photo1?> " class="img-responsive" />
									
								</a>
							</li>
							<li class="mui-table-view-cell mui-media mui-col-xs-6 mui-col-sm-6">
								<a href="#" >
									<div class="mui-media-body">全身照</div>
									<img src="<?= @yii::$app->params['photoUrl'].$userData->path2.$userData->photo2?>" class="img-responsive" />
								</a>
							</li>
			</ul>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell">
					<p> 量感 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'sense', $userJudge->sense) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 曲直 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'straight', $userJudge->straight)?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 动静 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'movement', $userJudge->movement) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 冷暖 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'cold_warm', $userJudge->cold_warm) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p>明度 <span class="mui-pull-right"><?=@ CommonUtil::getDescByValue('style', 'lightness', $userJudge->lightness) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 纯度 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'purity', $userJudge->purity) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 体型 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'shape', $userJudge->shape) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 肤色<span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'skin_color', $userJudge->skin_color) ?></span> </p>
				</li>
				<li class="mui-table-view-cell">
					<p> 适合风格 <span class="mui-pull-right"><?= @CommonUtil::getDescByValue('style', 'style', $userJudge->style) ?></span> </p>
				</li>
</ul>
<?php }?>