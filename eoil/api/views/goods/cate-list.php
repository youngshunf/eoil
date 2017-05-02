

<ul class="mui-table-view mui-grid-view mui-grid-9">
<?php foreach ($cates as $v){?>
	<li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3 goods-cate" data-cateid="<?= $v->id?>"><a href="#">
	 <img src="<?= yii::$app->params['photoUrl'].$v->path.$v->photo?>" class="img-responsive" />
			<div class="mui-media-body"><?= $v->name?></div>
	</a>
	</li>
	<?php }?>
</ul>