<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '系统设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
	
	<div class="row">
	<div class="col-md-6">
	 <h5>商品单位设置</h5>
    <p>
        <?= Html::a('新增单位', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'desc',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
               'template'=>'{update}{delete}',
                'buttons'=>[
                    'update'=>function ($url,$model,$key){
                        return  Html::a('修改 |', $url, ['title' => '修改设置'] );
                     },
                     'delete'=>function ($url,$model,$key){
                     return  Html::a('删除 ', $url, ['title' => '删除设置','data-confirm'=>'你确定要删除这个单位吗？'] );
                     },
                ]
            ]
            ]
    ]); ?>
    </div>
    <div class="col-md-6">
	 <h5>系统设置</h5>
	<p>
        <?= Html::a('修改设置', ['update-sysset','id'=>$sysSet->id], ['class' => 'btn btn-success']) ?>
    </p>
	

<?= DetailView::widget([
        'model' => $sysSet,
        'attributes' => [
            'keep_expire',
            'withdraw_deposit',
            'deposit_rate',
            'car_deposit_rate',
        ],
    ]) ?>
  
    </div>
     </div>

</div>
</div>
