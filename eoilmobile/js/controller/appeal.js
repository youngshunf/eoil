var pubApp = angular.module('eoil', [])

.controller('pubCtrl', function($scope) {
	var initParam = function() {
		$scope.formData = {
			imgs: [],
			content: ''
		};
		

	}
	initParam();
	$scope.remove=function(index){
     $scope.formData.imgs.splice(index,1);
	}

	$scope.submit = function(){
		
		if($scope.formData.imgs.length < 1 ) {
			mui.alert('请至少上传一张凭证');
			return false;
		}
		
		if(!$scope.formData.content) {
			mui.alert('请填写申诉理由');
			return false;
		}
		
		var self=plus.webview.currentWebview();
		var orderid=self.orderid;
		$scope.formData.orderid=orderid;
		console.log(JSON.stringify($scope.formData));
		var data = {
			data: angular.toJson($scope.formData, true)
		};
		plus.nativeUI.showWaiting('正在提交,请稍后...');
		$.ajax({
			type: "post",
			url: app.getAuthUrl(config.submitAppealUrl),
			data: data,
			success: function(rs) {
				console.log(rs);
				plus.nativeUI.closeWaiting();
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					mui.alert('您的申诉已经提交，请等待平台进行处理!');
					mui.back();
				}
			},
			error: function(e) {
				plus.nativeUI.closeWaiting();
				console.log(e.status);
				mui.alert('提交失败,请稍候重试!')
			}
		});
	}

	$scope.addPhoto = function() {
		var btnArray = [{
			title: "拍照"
		}, {
			title: "相册选择"
		}];
		plus.nativeUI.actionSheet({
			cancel: "取消",
			buttons: btnArray
		}, function(event) {
			var index = event.index;
			switch(index) {
				case 1:
					plus.camera.getCamera().captureImage(function(p) {
						plus.io.resolveLocalFileSystemURL(p, function(entry) {
							var localUrl = entry.toLocalURL();
							appendFile(localUrl);
						}, function(e) {
							console.log("读取拍照文件错误：" + e.message);
						});

					});
					break;
				case 2:
					plus.gallery.pick(function(p) {
						appendFile(p);
					});

					break;

			}
		}, false);

	}

	var appendFile = function(p) {
		console.log(p);
		if(p) {
			plus.nativeUI.showWaiting();
			//压缩图片
			lrz(p, {
					width: 1024
				})
				//处理成功
				.then(function(rst) {
					plus.nativeUI.closeWaiting();
					$scope.$apply(function() {
						$scope.formData.imgs.push(rst.base64);
					});
				})
				// 处理失败
				.catch(function(err) {
					plus.nativeUI.closeWaiting();
					console.log('图片压缩失败!');
				});
		}
	};

});