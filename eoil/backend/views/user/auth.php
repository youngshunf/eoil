<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CommonUtil;
use yii\helpers\Url;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户审核';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
			<div class="col-lg-12  col-md-12">
			<div class="leftmenu">
        <?php  
          $menuItems[] = ['label' => '个人用户', 'url' => ['/user/auth','userType'=>1],'active'=>$userType==1  ];    
          $menuItems[] = ['label' => '企业用户', 'url' => ['/user/auth','userType'=>2], 'active'=>$userType==2  ];
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills '],
                'items' => $menuItems,
            ]);      
		?>
		</div>
		
        </div>
        
         </div>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
    <?php if($userType==1){?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',
            'name',
            'id_code',
            ['attribute'=>'auth_result',
              'filter'=>['0'=>'未审核','1'=>'审核通过','2'=>'审核未通过'],
               'value'=>function ($model){
               return CommonUtil::getDescByValue('user_auth', 'auth_result', $model->auth_result);
            }
            ],
            [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
             	'options'=>['width'=>'200px'],
            	'template'=>'{view-auth}{auth-pass}{auth-deny}',
	             'buttons'=>[
					'view-auth'=>function ($url,$model,$key){
					   
	                     return  Html::a('查看 | ', $url, ['title' => '查看详细'] );
					},
					'auth-pass'=>function ($url,$model,$key){
					   if($model->auth_result==0||$model->auth_result==2)
					       return  Html::a('审核通过 |', $url, ['title' => '审核通过'] );					       												   
				},
					'auth-deny'=>function ($url,$model,$key){
					if($model->auth_result==0)
					return  Html::a('审核不通过', $url, ['title' => '审核不通过', 'data' => [
                                        'confirm' => '您确定审核不通过?',
                                        'method' => 'post',
                                    ],] );
					},
					
				]
           	],
        ],
    ]); ?>
    <?php }?>
    
    <?php if($userType==2){?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'序号'],
            'user.name',
            'user.mobile',
            'company_name',
            'company_owner',
            'owner_code',
            'company_credit_code',
            ['attribute'=>'auth_result',
              'filter'=>['0'=>'未审核','1'=>'审核通过','2'=>'审核未通过'],
               'value'=>function ($model){
               return CommonUtil::getDescByValue('user_auth', 'auth_result', $model->auth_result);
            }
            ],
            [	'class' => 'yii\grid\ActionColumn',
             	'header'=>'操作',
             	'options'=>['width'=>'200px'],
            	'template'=>'{view-auth}{auth-path}{auth-deny}',
	             'buttons'=>[
					'view-auth'=>function ($url,$model,$key){
	                     return  Html::a('查看 | ', $url, ['title' => '查看详细'] );
					},
					'auth-path'=>function ($url,$model,$key){
					
					       return  Html::a('审核通过 |', $url, ['title' => '审核通过'] );					       												   
				},
					'auth-deny'=>function ($url,$model,$key){
					return  Html::a('审核不通过', $url, ['title' => '审核不通过', 'data' => [
                                        'confirm' => '您确定审核不通过?',
                                        'method' => 'post',
                                    ],] );
					},
					
				]
           	],
        ],
    ]); ?>
    <?php }?>
</div>
</div>
