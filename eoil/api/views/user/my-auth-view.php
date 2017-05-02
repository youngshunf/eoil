<?php

use common\models\CommonUtil;

?>	

      
         <ul class="mui-table-view">
             <li class="mui-table-view-cell">
					<p ><?= CommonUtil::getDescByValue('user_auth', 'user_type', $model->user_type)?><span class="mui-pull-right mui-badge mui-badge-danger"><?= CommonUtil::getDescByValue('user_auth', 'auth_result', $model->auth_result)?></span></p>
				</li>
				<?php if($model->user_type==1){?>
				<li class="mui-table-view-cell">
					<p >姓名:<?= $model->name?></p>
				</li>
<!-- 				<li class="mui-table-view-cell"> -->
	<!-- 				<p >身份证号:<?= $model->id_code?></p> -->
<!-- 				</li>
				<li class="mui-table-view-cell">
					<p >身份证正面</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo1 ?>" />
					</div>
				</li>
				<li class="mui-table-view-cell">
					<p >身份证背面</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo2 ?>" />
					</div>
				</li>
				<li class="mui-table-view-cell">
					<p >手持身份证</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo3 ?>" />
					</div>
				</li> -->
				<?php }elseif($model->user_type==2){?>
				<li class="mui-table-view-cell">
					<p >公司名称:<?= $model->company_name?></p>
				</li>
				<li class="mui-table-view-cell">
					<p >公司法人:<?= $model->company_owner?></p>
				</li>
			<!--	<li class="mui-table-view-cell">
					<p >法人身份证:<?= $model->owner_code?></p>
				</li> -->
				<li class="mui-table-view-cell">
					<p >社会信用代码:<?= $model->company_credit_code?></p>
				</li>
				<!-- <li class="mui-table-view-cell">
					<p >营业执照</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo1 ?>" />
					</div>
				</li>
				<li class="mui-table-view-cell">
					<p >税务登记证</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo2 ?>" />
					</div>
				</li>
				<li class="mui-table-view-cell">
					<p >组织机构证</p>
					<div class="flex-center">
						<img class="img-responsive" src="<?= yii::$app->params['photoUrl'].$model->path.'mobile/'.$model->id_photo3 ?>" />
					</div>
				</li> -->
				<?php }?>
	   </ul>