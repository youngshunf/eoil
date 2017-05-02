function getHomeList(){
	getHomeBanner();
	getHomeTop();
	getEoilTop();
	//getHomeNews();
	getRecGoods();
	getNewGoods();
	
}

function getHomeBanner(){
	mui.ajax({
	type:"post",
	url:config.getHomeBannerUrl,
	async:true,
	success:function(rs){
		$('#slider-item').html(rs);
		swiper = new Swiper('#home-slider', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        centeredSlides: true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
	    });
	},
	error:function(e){
		
		console.log("获取首页banner失败!"+e.status);
	}
	});
}
function getEoilTop(){
	mui.ajax({
	type:"post",
	url:config.getEoilTopUrl,
	async:true,
	success:function(rs){
		$('#eiol-item').html(rs);
		vswiper = new Swiper('#top-slider', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        direction: 'vertical',
	        centeredSlides: true,
	        loop:true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
	    });
	},
	error:function(e){
		
		console.log("获取首页banner失败!"+e.status);
	}
	});
}
function getHomeTop(){
	mui.ajax({
	type:"post",
	url:config.getHomeTopUrl,
	async:true,
	success:function(rs){
		$('#news-one').html(rs);
		
	},
	error:function(e){
		console.log("获取行业推荐失败!"+e.status);
	}
	});
}
function getHomeNews(){
	mui.ajax({
	type:"post",
	url:config.getHomeNewsUrl,
	async:true,
	success:function(rs){
		$('#news-two').html(rs);
		
	},
	error:function(e){
		console.log("获取新闻失败!"+e.status);
	}
	});
}
function getRecGoods(){
	mui.ajax({
	type:"post",
	url:config.getRecGoodsUrl,
	async:true,
	success:function(rs){
		$('#rec-goods').html(rs);
		
	},
	error:function(e){
		console.log("获取推荐商品失败!"+e.status);
	}
	});
}
function getNewGoods(){
	mui.ajax({
	type:"post",
	url:config.getNewGoodsUrl,
	async:true,
	success:function(rs){
		$('#new-goods').html(rs);
	},
	error:function(e){
		console.log("获取最新商品失败!"+e.status);
	}
	});
}
