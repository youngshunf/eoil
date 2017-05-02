<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'mobile',
            'name',
            'nick',
            ['attribute'=>'is_auth',
              'filter'=>['0'=>'未验证','1'=>'已验证'],
               'value'=>function ($model){
               return CommonUtil::getDescByValue('user', 'is_auth', $model->is_auth);
            }
            ],
            
                [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
             	'options'=>['width'=>'200px'],
            	'template'=>'{view}{update}{delete}',
	             'buttons'=>[
					'view'=>function ($url,$model,$key){
	                     return  Html::a('查看 | ', $url, ['title' => '查看详细'] );
					},
					'update'=>function ($url,$model,$key){
					
					       return  Html::a('修改 |', $url, ['title' => '修改用户'] );					       												   
				},
					'delete'=>function ($url,$model,$key){
					return  Html::a('删除', $url, ['title' => '删除用户', 'data' => [
                                        'confirm' => '您确定要删除此用户?',
                                        'method' => 'post',
                                    ],] );
					},
					'reset-password'=>function ($url,$model,$key){
					return  Html::a(' 重置密码', $url, ['title' => '重置密码', 'data' => [
					    'confirm' => '您确定重置此用户的密码吗?',
					    'method' => 'post',
					],] );
					},
				]
           	],
        ],
    ]); ?>
</div>
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