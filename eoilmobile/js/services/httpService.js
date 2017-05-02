var httpService=angular.module('eoilServices',[]);
httpService.service('httpService',['$http','$q',
	function($http,$q){
	var self=this;
	 self.getUserInfo=function(){
	 	 var user=localStorage.getItem('$user') || '';
	 	 if(user){
	 	 	user=JSON.parse(user);
	 	 }
	 	 return user;
	 }
	 self.postData=function(url,data){
	 	console.log(JSON.stringify(data));
	 	var user=this.getUserInfo();
	 	 var deferred=$q.defer();
	 	 var promise=deferred.promise;
	     if(!user){
				deferred.reject('用户信息为空');
	 	     	return promise;
		}
	     url=url+'?access-token='+user.access_token;
	     var data={
	     	 data:angular.toJson(data,true)
	     };
			  $http({
				 url:url,
				 method:'POST',
				 data:data,
				 timeout:6000
			 }).success(function(res){
			 	deferred.resolve(res);
			 }).error(function(e){
			 	deferred.reject(e);
			 });
			 
			 return promise;
	 }
	 
}]);
