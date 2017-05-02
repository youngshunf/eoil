<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品管理';
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
            'name',
            'price',
            ['attribute'=>'发布者',
            'value'=>function ($model){
               if($model->user->is_auth==1){
                   if($model->userAuth->user_type==1){
                       return $model->userAuth->name;
                   }else{
                       return $model->userAuth->company_owner;
                   } 
               }else{
                   return $model->user->name;
               }
              
            }
            ],
            'user.mobile',
            ['attribute'=>'是否车类','value'=>function ($model){
                return $model->is_car==0?'否':'是';
            }],
            ['attribute'=>'created_at',
              'format'=>['date','php:Y-m-d H:i:s']
             ],

            ['class' => 'yii\grid\ActionColumn','header'=>'操作',
                
                'template'=>'{view}{update}{goods-rec}{delete}',
                'buttons'=>[
                    'view'=>function ($url,$model,$key){
                    return  Html::a('查看 | ', $url, ['title' => '查看商品'] );
                    },
                    'update'=>function ($url,$model,$key){
                    	
                    return  Html::a('修改 |', $url, ['title' => '修改商品'] );
                    },
                    'goods-rec'=>function ($url,$model,$key){
                     if($model->is_rec==0){
                         return  Html::a(' 推荐 |', $url, ['title' => '推荐'] );
                     }else{
                         return  Html::a(' 取消推荐 |', $url, ['title' => '取消推荐'] );
                     }
                   
                    },
                    'delete'=>function ($url,$model,$key){
                    return  Html::a('删除 ', $url, ['title' => '删除分类', 'data-confirm'=>'是否确定删除该商品？','data-method'=>'post'] );
                    },
                    ],
             ],
        ],
    ]); ?>

</div>
</div>
