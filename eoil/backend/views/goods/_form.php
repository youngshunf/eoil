<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wenyuan\ueditor\Ueditor;
use yii\web\View;
use kartik\widgets\DateTimePicker;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model common\models\AuctionGoods */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/lrz.bundle.js', ['position'=> View::POS_HEAD]);
?>

<div class="row">
 
    <?php $form = ActiveForm::begin(['id'=>'goods-form','options' => ['enctype' => 'multipart/form-data','onsubmit'=>'return check()']]); ?>
    <div class="col-md-12">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 256]) ?>
    <?= $form->field($model, 'cateid')->dropDownList(ArrayHelper::map($cate, 'id', 'name'))->label('商品分类') ?>
     <?= $form->field($model, 'price')->textInput(['maxlength' => 10]) ?>
    <?= $form->field($model, 'stock')->textInput(['maxlength' => 10]) ?>
     




    </div>
   <div class="col-md-12">
        <div class="form-group">
         <label>内容</label>
          <?= Ueditor::widget(['id'=>'desc',
                'model'=>$model,
                'attribute'=>'desc',
                'ucontent'=>$model->desc,
                ]);  ?>
        </div>
        
      <div class="form-group">
        <label class="control-label"> 封面图片(推荐尺寸:720*400)</label>
        <div class="img-container">
        <?php if(empty($model->photo)){?>
                <div class="uploadify-button"> 
                </div>
        <?php }else{?>
            <img alt="封面图片" src="<?= yii::$app->params['photoUrl'].$model->path.'thumb/'.$model->photo?>" class="img-responsive">
        <?php }?>
        </div>
       <input type="file" name="photo"  class="hide"  id="photo">
       </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">


$('.img-container').click(function(){
    $('#photo').click();
})

document.getElementById('photo').addEventListener('change', function () {
    var that = this;
    lrz(that.files[0], {
        width: 700
    })
        .then(function (rst) {
            var img        = new Image();            
            img.className='img-responsive';
            img.src = rst.base64;    
            img.onload = function () {
           	 $('.img-container').html(img);
            };                 
            return rst;
        });
});

function check(){

	var required=0;
    $('.required').find('input').each(function(){
		if(!$(this).val()){
			required++;
		}
    });
    if(required!=0){
   	 modalMsg('请填写完再提交');
     return false;
    }
	
	<?php if(empty($model->photo)){?>
    if(!$('#photo').val()){
        modalMsg('请上传照片');
        return false;
    }
    <?php }?>
  
    showWaiting('正在提交,请稍候...');
    return true;
}

</script>