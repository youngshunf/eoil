<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
use yii\helpers\Url;
use common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-white">

    <h5><?= Html::encode($this->title) ?></h5>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<ul id="myTab" class="nav nav-tabs">
   <li class="active">
      <a href="#month" data-toggle="tab">
         按月统计
      </a>
   </li>
   <li><a href="#year" data-toggle="tab">按年统计</a></li>
</ul>
<div id="myTabContent" class="tab-content">
   <div class="tab-pane fade in active" id="month">
   <br>
     <div class="input-group">
         <span class="input-group-addon">统计月份</span>
         <input type="date" class="form-control" name="month" >
         <span class="input-group-addon btn btn-success" id="monthBtn">查询</span>
      </div>
      <?= GridView::widget([
        'dataProvider' => $monthOrders,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'year_month_day',
            ['attribute'=>'全部订单',
            'value'=>function ($model){
            return Order::find()->andWhere([ 'year_month_day'=>$model->year_month_day])->count();
            }],
            ['attribute'=>'待付款',
                'value'=>function ($model){
              return Order::find()->andWhere(['status'=>0, 'year_month_day'=>$model->year_month_day])->count(); 
           }],
             ['attribute'=>'待发货',
                'value'=>function ($model){
              return Order::find()->andWhere(['status'=>1, 'year_month_day'=>$model->year_month_day])->count(); 
           }],
           ['attribute'=>'待收货',
           'value'=>function ($model){
           return Order::find()->andWhere(['status'=>2, 'year_month_day'=>$model->year_month_day])->count();
           }],
           ['attribute'=>'已完成',
           'value'=>function ($model){
           return Order::find()->andWhere(['status'=>3, 'year_month_day'=>$model->year_month_day])->count();
           }],
        ],
    ]); ?>
   </div>
   <div class="tab-pane fade" id="year">
   
    <br>
     <div class="input-group">
         <span class="input-group-addon">统计年份</span>
         <input type="date" class="form-control" name="year" >
         <span class="input-group-addon btn btn-success" id="yearBtn">查询</span>
      </div>
      
    <?= GridView::widget([
        'dataProvider' => $yearOrders,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'year_month',
            ['attribute'=>'全部订单',
            'value'=>function ($model){
            return Order::find()->andWhere([ 'year_month'=>$model->year_month])->count();
            }],
            ['attribute'=>'待付款',
                'value'=>function ($model){
              return Order::find()->andWhere(['status'=>0, 'year_month'=>$model->year_month])->count(); 
           }],
             ['attribute'=>'待发货',
                'value'=>function ($model){
              return Order::find()->andWhere(['status'=>1, 'year_month'=>$model->year_month])->count(); 
           }],
           ['attribute'=>'待收货',
           'value'=>function ($model){
           return Order::find()->andWhere(['status'=>2, 'year_month'=>$model->year_month])->count();
           }],
           ['attribute'=>'已完成',
           'value'=>function ($model){
           return Order::find()->andWhere(['status'=>3, 'year_month'=>$model->year_month])->count();
           }],
        ],
    ]); ?>
     </div>
</div>

</div>

<script type="text/javascript">
$('#monthBtn').click(function(){
	var month=$('input[name=month]').val();
	if(!month){
		modalMsg('请选择查询月份');
		return ;
	}
	location.href="statistic?month="+month;

});

$('#yearBtn').click(function(){
	var year=$('input[name=year]').val();
	if(!year){
		modalMsg('请选择查询年份');
		return ;
	}
	location.href="statistic?year="+year;

});

</script>
