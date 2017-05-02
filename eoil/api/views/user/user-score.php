<?php

use common\models\CommonUtil;

?>	

<?php 
if(!empty($score)){
foreach ($score as $k=>$v){?>
	<li class="mui-table-view-cell score-rec">
	<table width="100%">
		<tr>
			<td width="5%"><span class="mui-icon mui-icon-circle"></span></td>
			<td width="40%"><p><?= CommonUtil::fomatDate($v->created_at)?></p></td>
			<td width="45%"><p><?= $v->desc?></p></td>
			<td width="10%"> <p><span class="up-score"><?= $v->score?></span></p></td>
		</tr>
	</table>
</li>

<?php }}else{?>
<li class="mui-table-view-cell score-rec">
	<p>暂时没有积分哦</p>
</li>

<?php }?>