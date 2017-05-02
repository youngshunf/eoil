var pays={};
function getPaymentChannels(){
	// 获取支付通道
	plus.payment.getChannels(function(channels){
		for(var i in channels){
			var channel=channels[i];
			if(channel.id=='qhpay'||channel.id=='qihoo'){	// 过滤掉不支持的支付通道：暂不支持360相关支付
				continue;
			}
			pays[channel.id]=channel;
			checkServices(channel);
		}
	},function(e){
		mui.toast(e.message)
	});
};
// 检测是否安装支付服务
function checkServices(pc){
	if(!pc.serviceReady){
		var txt=null;
		switch(pc.id){
			case "alipay":
			txt="检测到系统未安装“支付宝快捷支付服务”，无法完成支付操作，是否立即安装？";
			break;
			case "wxpay":
			txt="系统未安装微信支付服务，无法完成支付，是否立即安装？";
			break;
		}
		plus.nativeUI.confirm(txt,function(e){
			if(e.index==0){
				pc.installService();
			}
		},pc.description);
	}
}

// 支付
function pay(id,order,orderid,orderType){
	console.log(id);
	if(id=='alipay'||id=='wxpay'){
		plus.payment.request(pays[id],order,function(result){
			console.log(JSON.stringify(result));
			var data={
				orderid:orderid,
				payType:id,
				orderType:orderType
			};
		  mui.ajax({
				url:app.getAuthUrl(config.getPaySuccessUrl),
				type:"post",
				data:{data:data},
				success:function(rs){
					console.log(rs);
					if(typeof rs=='string'){
						rs=JSON.parse(rs);
					}
					if(rs.result=='success'){
						mui.openWindow({
							url:'pay-result.html',
							extras:{
								result:'success'
							}
						})
					}else{
						mui.toast('获取支付结果失败!');
					}
				},
				error:function(e){
					console.log(e.status);
					mui.toast('获取支付结果失败!');
				}
			});
			
		},function(e){
			console.log(JSON.stringify(e));
			mui.toast("支付失败:["+e.code+"]："+e.message);
			mui.openWindow({
				url:'pay-result.html',
				extras:{
					result:'fail'
				}
			})
		});
	}else{
		plus.nativeUI.alert("当前环境不支持此支付通道");
		return;
	}
	
}