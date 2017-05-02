<?php 


use yii\widgets\Breadcrumbs;
use common\models\News;
use yii\helpers\Url;
use common\models\CommonUtil;
?>
<!-- 先引用main.php布局文件， -->
<?php $this->beginContent('@api/views/layouts/main.php');?>
    <div class="container ">
       <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
    <div class="row">
              <div class="col-lg-9 col-md-9"> 
                
              
                     
                <?= $content ?>
             
                </div>
                
			<div class="col-lg-3  col-md-3">
			<div class="panel-white">
        <?php 
        $recomendNews=News::find()->andWhere(['is_recommend'=>1])->limit(10)->orderBy('created_at')->all();
        $hotNews=News::find()->limit(10)->orderBy('count_view desc')->all();
        ?>
        
        <h5>推荐资讯</h5>
        <ul class="mui-table-view">
        <?php 
        foreach ($recomendNews as $model){
        ?>
        <li class="mui-table-view-cell">
        <a href="<?= Url::to(['view','id'=>$model['newsid']])?>">
         <p><?= $model->title?></p>    
		</a>
		</li>
        <?php }?>
        </ul>
        
    		</div>
    		
    		<div class="panel-white">
    		<h5>一周热门</h5>
    		<ul class="mui-table-view">
    		      <?php 
        foreach ($hotNews as $model){
        ?>
        <li class="mui-table-view-cell">
        <a href="<?= Url::to(['view','id'=>$model['newsid']])?>">
         <p><?= $model->title?></p>    
		</a>
		</li>
        <?php }?>
        </ul>
    		</div>
    		
            </div>
      
         </div>
      </div>
<?php $this->endContent();?>
