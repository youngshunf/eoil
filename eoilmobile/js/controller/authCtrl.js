
var pubApp=angular.module('eoil',['eoilServices'])

.controller('authCtrl',function($scope,httpService){
	$scope.formData={
		imgs:[
		[{'p1':''},
		 {'p2':''},
		 {'p3':''}
		],
		[{'p1':''},
		 {'p2':''},
		 {'p3':''}
		]
		],
		name:'',
		id_code:'',
		company_name:'',
		company_owner:'',
		owner_code:'',
		company_credit_code:'',
	};
	$scope.indicator=0;
	$scope.photoIndex=1;
	$scope.changeIdx=function(index){
		$scope.indicator=index;
	}
	$scope.submit=function(){
//		$scope.$apply();
		var p1,p2,p3;
		if($scope.indicator==0){
			if(!$scope.formData.name){
				mui.alert('请填写姓名!');
				return false;
			}
			if(!$scope.formData.id_code){
				mui.alert('请填写身份证号!');
				return false;
			}
			if(!$scope.formData.imgs[0].p1){
				mui.alert('请上传身份证正面照片!');
				return false;
			}
			if(!$scope.formData.imgs[0].p2){
				mui.alert('请上传身份证反面照片!');
				return false;
			}
//			if(!$scope.formData.imgs[0].p3){
//				mui.alert('请上传手持身份证照片!');
//				return false;
//			}
		}
		
		if($scope.indicator==1){
			if(!$scope.formData.company_name){
				mui.alert('请填写公司名称!');
				return false;
			}
			if(!$scope.formData.company_owner){
				mui.alert('请填写法人姓名!');
				return false;
			}
			if(!$scope.formData.owner_code){
				mui.alert('请填写法人身份证号!');
				return false;
			}
			if(!$scope.formData.company_credit_code){
				mui.alert('请填写社会信用码!');
				return false;
			}
			if(!$scope.formData.imgs[$scope.indicator].p1){
				mui.alert('请上传营业执照照片!');
				return false;
			}
			if(!$scope.formData.imgs[$scope.indicator].p2){
				mui.alert('请上传税务登记证照片!');
				return false;
			}
			if(!$scope.formData.imgs[$scope.indicator].p3){
				mui.alert('请上传组织机构证照片!');
				return false;
			}
		}
		p1=localStorage.getItem('authp1');
		p2=localStorage.getItem('authp2');
		p3=localStorage.getItem('authp3');
		$scope.formData.userType=$scope.indicator+1;
		
		console.log(JSON.stringify($scope.formData));
		plus.nativeUI.showWaiting('正在提交,请稍候...');
		
			try{
				var imgs={
					p1:p1,
					p2:p2,
					p3:p3
				};
				
				var data={
					form:angular.toJson($scope.formData,true),
					imgs:imgs
				}
				$.ajax({
			type:"post",
			url:app.getAuthUrl(config.submitAuthUrl),
			data:{
				data:data
			},
			success:function(rs){
				console.log(rs)
				plus.nativeUI.closeWaiting();
				if(typeof rs =='string'){
					rs=JSON.parse(rs);
				}
				if(rs.result=='success'){
					mui.alert('您的认证信息已提交,请等待认证!');
					mui.back();
				}else{
					mui.alert('认证信息提交失败!');
				}
			},
			error:function(e){
				plus.nativeUI.closeWaiting();
				console.log(e.status);
				mui.alert('认证信息提交失败!');
			}
		});
//		httpService.postData(config.submitAuthUrl,$scope.formData).then(function(rs){
//			console.log(JSON.stringify(rs));
//			plus.nativeUI.closeWaiting();
//			if(typeof rs =='string'){
//					rs=JSON.parse(rs);
//				}
//				if(rs.result==1){
//					mui.alert('您的认证信息已提交,请等待认证!');
//					mui.back();
//				}else{
//					mui.alert('认证信息提交失败!');
//				}
//			
//		},function(e){
//			plus.nativeUI.closeWaiting();
//			console.log(e.status);
//		});
		}catch(e){
				plus.nativeUI.closeWaiting();
						//TODO handle the exception
						console.log(e);
					}
		}
	$scope.addPhoto=function(index){
		 $scope.photoIndex=index;
	    var btnArray = [{
				title: "拍照"
			},{
				title: "相册选择"
			}];
			plus.nativeUI.actionSheet({
				cancel: "取消",
				buttons: btnArray
			}, function(event) {
				var index = event.index;
				switch (index) {
					case 1:					
						plus.camera.getCamera().captureImage(function(p){
							plus.io.resolveLocalFileSystemURL( p, function ( entry ) {
								var localUrl=entry.toLocalURL();								
								appendFile(localUrl);
							}, function ( e ) {
								console.log( "读取拍照文件错误："+e.message );
							} );
								
						});	
						break;
					case 2:
						plus.gallery.pick(function(p){
				        appendFile(p);
				    });
						
						break;
					
				}			
		}, false);
		
		}
		
		var appendFile=function(p) {
			console.log(p);
			if (p) {
				plus.nativeUI.showWaiting();
				//压缩图片
				  lrz(p, {
			        width: 1024
			    })
				  //处理成功
			    .then(function (rst) {
			    	plus.nativeUI.closeWaiting();
				     $scope.$apply(function(){
				     	switch($scope.photoIndex){
				     		case 1:
				     		$scope.formData.imgs[$scope.indicator].p1=rst.base64;
				     		localStorage.setItem('authp1',rst.base64);
				     		break;
				     		case 2:
				     		$scope.formData.imgs[$scope.indicator].p2=rst.base64;
				     		localStorage.setItem('authp2',rst.base64);
				     		break;
				     		case 3:
				     		$scope.formData.imgs[$scope.indicator].p3=rst.base64;
				     		localStorage.setItem('authp3',rst.base64);
				     		break;
				     	}
				     	
				     });
			        })
			     // 处理失败
			   .catch(function (err){
			   	plus.nativeUI.closeWaiting();
           			console.log('图片压缩失败!');
       			 });
			}
		};
});
