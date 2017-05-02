var oldback=mui.back;
var maxLenght=9;
var photos=[];
var placeholder=null;
$('.image-list').click(function(){
//$(document).on('click','.image-list',function(){
	var that=$(this);
	 placeholder=that.find('.image-item');
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
			    placeholder.css('backgroundImage','url(' + rst.base64+ ')');
				
				var imagetype=placeholder.data('imgtype');
				console.log(imagetype)
				plus.storage.setItem('persondata-'+imagetype,rst.base64);
				plus.nativeUI.closeWaiting();
			        })
			     // 处理失败
			   .catch(function (err){
			   	plus.nativeUI.closeWaiting();
           			console.log('图片压缩失败!');
       			 });
			}
		};
		
		});
		
	