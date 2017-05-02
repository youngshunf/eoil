
$(document).on('tap','.goods-cart',function(){
	var id=$(this).data('id');
	console.log(id);
			$.ajax({
				type:"post",
				url:config.addCartUrl,
				data:{
					user:app.getUserState(),
					data:{
						id:id
					}
				},
				dataType:'json',
				success:function(rs){
					if(rs.result=='success'){
						mui.toast('加入购物车成功');
						localStorage.setItem('$user',JSON.stringify(rs.data));
					}else{
						mui.toast('您已经加入购物车了!');
					}
				},
				error:function(e){
					console.log(JSON.stringify(e));
				}
			});
})

$(document).on('tap','.goods-love',function(){
	var id=$(this).data('id');
	console.log(id);
			$.ajax({
				type:"post",
				url:config.goodsLoveUrl,
				data:{
					user:app.getUserState(),
					data:{
						id:id
					}
				},
				dataType:'json',
				success:function(rs){
					if(rs.result=='success'){
						mui.toast('商品喜欢成功!');
						localStorage.setItem('$user',JSON.stringify(rs.data));
					}else{
						mui.toast('您已经喜欢过了!');
					}
				},
				error:function(e){
					console.log(JSON.stringify(e));
				}
			});
})