<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h5><?= Html::encode($this->title) ?></h5>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
<!-- 	 <p class="red"> *不选择时间，导出全部订单</p> -->
 <!--   <form action="<?= Url::to(['export-orders'])?>" method="post" id="export-form" > -->
 <!--    <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>"> -->
<!--      <div class="input-group"> -->
<!--          <span class="input-group-addon">开始时间</span> -->
<!--          <input type="date" class="form-control" name="startTime" id="startTime"> -->
<!--          <span class="input-group-addon">结束时间</span> -->
<!--          <input type="date" class="form-control" name="endTime" id="endTime"> -->
<!--          <span class="input-group-addon btn btn-success" id="export">导出</span> -->
<!--       </div> -->
<!--     </form> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            ['attribute'=>'seller.name',
                'label'=>'供货商姓名'
             ],
            ['attribute'=>'seller.mobile',
            'label'=>'供货商手机号'
                ],
            'user.name',
            'user.mobile',
            'orderno',
            'goods_name',
             'number',
            'amount',
            ['attribute'=>'status',
                'filter'=>['0'=>'待付款','1'=>'待发货','2'=>'待确认收货','3'=>'已完成','98'=>'已退款' ,'99'=>'已取消'],
                'options'=>['width'=>'150px'],
                'value'=>function ($model){
              return CommonUtil::getDescByValue('orders', 'status', $model->status); 
           }],
           ['attribute'=>'type',
           'filter'=>['1'=>'供货保证金','2'=>'进货保证金'],
           'options'=>['width'=>'150px'],
           'value'=>function ($model){
           return CommonUtil::getDescByValue('orders', 'type', $model->type);
           }],
            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                'template'=>'{view}{delete}'
           ],
        ],
    ]); ?>

</div>
<script>
 $(document).ready(function(){
	 $("#export").click(function(){
		    if($("#endTime").val()<$("#startTime").val()){
		        modalMsg("结束时间不能小于开始时间");
		    }
		    showWaiting("正在导出,请稍候...");
		    $("#export-form").submit();
		});
 });            

</script>