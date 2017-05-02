<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\CommonUtil;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title ='审核用户:'. $model->user->mobile;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
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
       <?php if($model->auth_result==0 || $model->auth_result==2){ 
        echo Html::a('审核通过', ['auth-pass', 'id' => $model->id], ['class' => 'btn btn-danger']);
        
      }?>
        <?php if($model->auth_result==0){ 
            echo Html::a('审核不通过', ['auth-deny', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '您确定要删除此用户?',
                    'method' => 'post',
                ],
            ]); 
        }?>
        
    </p>
    <?php if($model->user_type==1){?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.name',
            'user.nick',
            'user.mobile',
            'name',
            'id_code',
            ['attribute'=>'auth_result','value'=>CommonUtil::getDescByValue('user_auth', 'auth_result', $model->auth_result)],
             ['attribute'=>'created_at','value'=>CommonUtil::fomatTime($model->created_at)],
        ],
    ]) ?>
    
    <h5>身份证照片</h5>
    <div class="row">
    <div class="col-md-4">
    <p class="text-center">身份证正面照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo1 ?>"  class="img-responsive">
    </div>
    <div class="col-md-4">
    <p class="text-center">身份证反面照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo2 ?>"  class="img-responsive">
    </div>
    <div class="col-md-4">
    <p class="text-center">手持身份证照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo3 ?>"  class="img-responsive">
    </div>
    </div>
    <?php }?>
    
     <?php if($model->user_type==2){?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.name',
            'user.nick',
            'user.mobile',
            'company_name',
            'company_owner',
            'owner_code',
            'company_credit_code',
            ['attribute'=>'auth_result','value'=>CommonUtil::getDescByValue('user_auth', 'auth_result', $model->auth_result)],
             ['attribute'=>'created_at','value'=>CommonUtil::fomatTime($model->created_at)],
        ],
    ]) ?>
    
    <h5>企业认证照片</h5>
    <div class="row">
    <div class="col-md-4">
    <p class="text-center">营业执照照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo1 ?>"  class="img-responsive">
    </div>
    <div class="col-md-4">
    <p class="text-center">税务登记证照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo2 ?>"  class="img-responsive">
    </div>
    <div class="col-md-4">
    <p class="text-center">组织机构证照片</p>
    <img src="<?= yii::$app->params['photoUrl'].$model->path.$model->id_photo3 ?>"  class="img-responsive">
    </div>
    </div>
    <?php }?>

</div>
</div>

