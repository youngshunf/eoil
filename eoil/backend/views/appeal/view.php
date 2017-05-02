<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;

/* @var $this yii\web\View */
/* @var $model common\models\Appeal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '申诉', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">

    <p>
        <?= Html::a('#', ['处理', 'id' => $model->id], ['class' => 'btn btn-primary deal']) ?>
        
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'申诉者','value'=>$model->user->name],
            
            ['attribute'=>'type','value'=>CommonUtil::getDescByValue('appeal','type',$model->type)],
            'orderno',
            ['attribute'=>'result','value'=>CommonUtil::getDescByValue('appeal','result',$model->result)],
            'remark',
            'reason:ntext',
            ['attribute'=>'申诉时间','value'=>CommonUtil::fomatTime($model->created_at)],
            ['attribute'=>'处理时间','value'=>CommonUtil::fomatTime($model->updated_at)],
            
        ],
    ]) ?>
	<h5>申诉照片</h5>
	<div class="row">
	<?php foreach ($appealPhoto as $V){?>
	<div class="col-md-3">
	  <img alt="" src="<?= yii::$app->params['photoUrl'].$v->path.'mobile/'.$v->photo?>" class="img-responsive">
	</div>
	
	<?php }?>
	</div>
</div>
</div>
