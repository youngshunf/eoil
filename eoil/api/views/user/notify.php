<?php

use common\models\CommonUtil;

?>	
 <ul class="mui-table-view" style="padding-top: 0">
 <?php foreach ($notify as $v){?>
<li class="mui-table-view-cell mui-media">
		<div class="mui-media-body">
			<p class='mui-ellipsis'>
				<b>支付通知</b>
			</p>
			<p>
				<?= $v->content?>
			</p>
			<p>
				<span class="sub mui-pull-right"><?= CommonUtil::fomatTime($v->created_at)?></span>
			</p>
		</div>
	</li>
	<?php }?>
</ul>