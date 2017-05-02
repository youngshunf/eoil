<?php

$this->title = 'e油网后台';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
    
         
        <div class="col-lg-4">
        <div class="panel-white">
                <h2>用户管理</h2>
                <p>管理会员</p>

                <p><a class="btn btn-primary" href="<?= yii::$app->urlManager->createUrl('user/index')?>">用户管理 &raquo;</a></p>
            </div>
            </div>
         
            <div class="col-lg-4">
            <div class="panel-white">
                <h2>产品管理</h2>

                <p>管理产品</p>

                <p><a class="btn btn-primary" href="<?= yii::$app->urlManager->createUrl('goods/index')?>">产品管理 &raquo;</a></p>
            </div>
            </div>
           
        
            
            
        </div>

    </div>
</div>
