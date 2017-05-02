<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_guid',
            'uid',
            'cateid',
            'created_at',
            // 'updated_at',
            // 'name',
            // 'desc:ntext',
            // 'photo',
            // 'price',
            // 'count_love',
            // 'stock',
            // 'address',
            // 'mobile',
            // 'qq',
            // 'weixin',
            // 'email:email',
            // 'lng',
            // 'lat',
            // 'is_rec',
            // 'unit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
