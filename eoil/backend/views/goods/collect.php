<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchGoods */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品采集';
$this->params['breadcrumbs'][] = $this->title;
$totalPage=intval($resp->total_results/40);
?>
<div class="box box-danger">

    <div class="box-header width-border">
        <div class="box-title" >
            <?= Html::encode($this->title) ?>
        </div>
    </div>
    <div class="box-body">
     <nav>
  <ul class="pagination">
   <li >
    <form action="<?= Url::to(['collect'])?>" method="get" id="search-form" >
     <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken()?>">
      <input type="hidden" name="sort" value="all">
      <input type="hidden" name="sortDetail" value="all">
      <input type="hidden" name="page" value="1">
      <div class="input-group" style="margin-bottom:10px">
          <span class="input-group-addon" >关键词</span>
          <input type="text" class="form-control" name="keyword"  value="<?= $keyword?>" placeholder="请输入关键词搜索" >
          <span class="input-group-addon " id="submit-search">搜索</span>
       </div>
     </form>
    </li>
     <li class="<?= $sort=='1'?'active':''?>">
      <a href="javascript:;" class=" goods-sort" data-sort="1" data-sortdetail="<?= $sortDetail?>">
        <span aria-hidden="true">综合排序</span>
      </a>
    </li>
    <li class="<?= $sort=='2'?'active':''?>">
       <a href="javascript:;" class="goods-sort " data-sort="2" data-sortdetail="<?= $sortDetail?>">
        <span aria-hidden="true"><?php if($sort=='2'){
          if($sortDetail=='price_desc'){
              echo '价格从高到低';
          }elseif ($sortDetail=='price_asc'){
              echo '价格从低到高';
          }
        }else{
         echo '价格';
        }?></span>
      </a>
    </li>
    <li class="<?= $sort=='3'?'active':''?>"> <a href="javascript:;" class="goods-sort " data-sort="3" data-sortdetail="<?= $sortDetail?>">
    <?php if($sort=='3'){
              echo '信用从高到低';
        }else{
         echo '信用';
        }?></a></li>
    <li class="<?= $sort=='4'?'active':''?>">
       <a href="javascript:;" class="goods-sort " data-sort="4" data-sortdetail="<?= $sortDetail?>">
        <span aria-hidden="true"><?php if($sort=='4'){
          if($sortDetail=='commissionNum_desc'){
              echo '销量从高到低';
          }elseif ($sortDetail=='commissionNum_asc'){
              echo '销量从低到高';
          }
        }else{
         echo '销量';
        }?></span>
      </a>
    </li>
     
  </ul>
</nav>

    <ul class="list-group media-list ">
    <?php foreach ($resp->items->aitaobao_item as $v){?>
      <li class="list-group-item media">
        <div class="media-left">
          <a href="#">
            <img class="media-object" src="<?=$v->pic_url?>" >
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><?= $v->title?> </h4>
          <p><span class="red ">￥ <?= $v->price?></span></p>
          <p><?= $v->nick?></p>
          <p><?= $v->open_iid?></p>
          <p><?= $v->item_location?> <a href="<?= Url::to(['goods-label'])?>?open_iid=<?= $v->open_iid ?>" class="btn btn-danger pull-right">贴标签</a></p>
          
        </div>
      </li>
      <?php }?>
    </ul>
   <nav>
  <ul class="pagination">
   <li class="page" data-page="1" >
      <a href="javascript:;" aria-label="first">
        <span aria-hidden="true">首页</span>
      </a>
    </li>
    <li class="page" data-page="<?= $page-1?>" >
      <a href="javascript:;" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <?php $deltaPage=$page%10;
    for($i=1;$i<=10;$i++){
        $cPage=$page-$deltaPage+$i;
    ?>
    <li class="page <?= $page==$cPage?'active':''?>" data-page="<?= $cPage?>" ><a href="javascript:;"><?= $cPage?></a></li>
    <?php }?>
    <li class="page" data-page="<?= $page+1?>"  >
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
     

    <li class="page">
      <a href="#" aria-label="Next">
        <span aria-hidden="true">共 <?= $totalPage?> 页</span>
      </a>
    </li>
  </ul>
</nav>
</div>
</div>
<script type="text/javascript">
   $('#submit-search').click(function(){
     if(!$('input[name=keyword').val()){
      modalMsg('请输入关键词搜索!');
      return false;
     }
     $('#search-form').submit();
   });

   $('.goods-sort').click(function(){
		var sort=$(this).data('sort');
		var sortDetail=$(this).data('sortdetail');
		$("input[name=sort]").val(sort);
		$("input[name=sortDetail]").val(sortDetail);
		$('#search-form').submit();
   });
   $('.page').click(function(){
		var page=$(this).data('page');
		$("input[name=page]").val(page);
		$('#search-form').submit();
 });
</script>

