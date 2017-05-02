var auths={};
mui.plusReady(function(){
	getAuth();
})
function getAuth(){
	// 获取登录认证通道
	plus.oauth.getServices(function(services){
		for(var i in services){
			var service=services[i];
			console.log(service.id+": "+service.authResult+", "+service.userInfo);
		   auths[service.id]=service;
		}
	},function(e){
		console.log("获取登录认证失败："+e.message);
	});
}
// 登录认证
function authLogin(id){
	var auth=auths[id];
	if(auth){
		var w=null;
		if(plus.os.name=="Android"){
			w=plus.nativeUI.showWaiting();
		}
		document.addEventListener("pause",function(){
			setTimeout(function(){
				w&&w.close();w=null;
			},2000);
		}, false );
		auth.login(function(){
			w&&w.close();w=null;
			console.log("登录认证成功：");
			console.log(JSON.stringify(auth.authResult));
			userinfo(auth,id);
		},function(e){
			w&&w.close();w=null;
			mui.toast("登录认证失败!");
			console.log("["+e.code+"]："+e.message);
		});
	}else{
		mui.toast("无效的登录认证通道！",null,"登录");
	}
}
// 获取用户信息
function userinfo(a,loginType){
	a.getUserInfo(function(){
		console.log(JSON.stringify(a,a.userInfo));
		if(loginType=='qq'){
			a.userInfo.openid=a.authResult.openid;
		}
		var data={
				userInfo:a.userInfo,
				loginType:loginType,
				locInfo:app.getLocInfo()
			};
		  mui.ajax({
				url:config.authLoginUrl,
				type:"post",
				data:{data:data},
				success:function(rs){
					console.log(rs);
					if(typeof rs=='string'){
						rs=JSON.parse(rs);
					}
					if(rs.result=='success'){
						localStorage.setItem('$user',JSON.stringify(rs.data));
						if(!rs.data.mobile){
							mui.openWindow({
								url:'bind-mobile.html'
							});
						}
						mui.openWindow({
							id:'main'
						});
						mui.toast("登录成功！");
					}else{
						mui.toast("授权登录失败！");
					}
				
				},
				error:function(e){
					console.log(e);
				}
			});
		
	},function(e){
		console.log("获取用户信息失败：");
		console.log("["+e.code+"]："+e.message);
		mui.toast("获取用户信息失败！",null,"登录");
	});
}

function logout(auth){
	auth.logout(function(){
		console.log("注销\""+auth.description+"\"成功");
	},function(e){
		console.log("注销\""+auth.description+"\"失败："+e.message);
	});
}