
var pubApp=angular.module('eoil',['eoilServices'])

.controller('orderCtrl',function($scope,httpService){
	$scope.sellerOrders=[];
	$scope.buyerOrders=[];
	$scope.statusMap={
		'0':'待付款',
		'1':'买家已支付',
		'2':'已生效',
		'3':'已成交',
		'4':'待评价',
		'5':'已完成',
		'97':'申诉',
		'98':'订单已关闭',
		'99':'已取消'
	}
	$scope.indicator=0;
	$scope.photoIndex=1;
	$scope.changeIdx=function(index){
		$scope.indicator=index;
	}
	function init(){
		$.ajax({
			type:"post",
			url:app.getAuthUrl(config.getSellerOrderUrl),
			success:function(rs){
				console.log(rs);
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					$scope.$apply(function(){
						$scope.sellerOrders=rs.data;
					})
				}
			},
			error:function(e){
				console.log(e.status);
			}
		});
		$.ajax({
			type:"post",
			url:app.getAuthUrl(config.getBuyerOrderUrl),
			success:function(rs){
				console.log(rs);
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					$scope.$apply(function(){
						$scope.buyerOrders=rs.data;
					})
				}
			},
			error:function(e){
				console.log(e.status);
			}
		});
	}
	init();
	$scope.goodsDetail=function(item){
		console.log(item);
		mui.openWindow({
			url:'../goods-detail.html',
			extras:{
				goodsid:item.goods.id
			}
		})
	}
	$scope.orderDetail=function(item){
		console.log(item);
		mui.openWindow({
			url:'order-detail.html',
			extras:{
				orderid:item.order.id
			}
		})
	}
	$scope.appealOrder=function(item){
		mui.openWindow({
			url:'appeal.html',
			extras:{
				orderid:item.order.id
			}
		})
	}
	$scope.withdrawOrder=function(item){
		var data={
			orderid:item.order.id
		};
		plus.nativeUI.confirm('保证金退还后用户不能再下单，您确定要退还保证金吗?',function(e){
			if(e.index==1){
			mui.ajax({
			type:"post",
			url:app.getAuthUrl(config.withdrawOrderUrl),
			data:{
				data:data
			},
			success:function(rs){
				console.log(rs);
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					mui.alert('操作成功,您的保证金将在7个工作日内退还到您的钱包，请注意查收.');
					init();
					
				}else{
					mui.toast('操作失败');
				}
			},
			error:function(e){
				console.log(e.status);
				mui.toast('操作失败:'+e.status);
			}
		})
			}
		},'提示',['取消','确定']);
		
	}
	
	$scope.confirmOrder=function(item){
		
		var data={
			orderid:item.order.id
		};
		plus.nativeUI.confirm('双方确认履约后,保证金将在7日内退回各自账户，您确定确认履约吗?',function(e){
			if(e.index==1){
			mui.ajax({
			type:"post",
			url:app.getAuthUrl(config.confirmOrderUrl),
			data:{
				data:data
			},
			success:function(rs){
				console.log(rs);
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					init();
					mui.alert('操作成功,您的保证金将在7日内退回您的钱包,请注意查收.');
					
					
				}else{
					mui.toast('操作失败');
				}
			},
			error:function(e){
				console.log(e.status);
				mui.toast('操作失败:'+e.status);
			}
		})
			}
		},'提示',['取消','确定']);
	}
	$scope.cancelOrder=function(item){
		var data={
			orderid:item.order.id
		};
		plus.nativeUI.confirm('您确定要取消订单吗?',function(e){
			if(e.index==1){
			mui.ajax({
			type:"post",
			url:app.getAuthUrl(config.cancelOrderUrl),
			data:{
				data:data
			},
			success:function(rs){
				console.log(rs);
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					mui.alert('操作成功,订单已取消');
					init();
					
				}else{
					mui.toast('操作失败');
				}
			},
			error:function(e){
				console.log(e.status);
				mui.toast('操作失败:'+e.status);
			}
		})
			}
		},'提示',['取消','确定']);
	}
	window.addEventListener('show',function(){
		console.log('show');
		init();
	});
		
});
