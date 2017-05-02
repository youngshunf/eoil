angular.module('eoil.services', [])
.factory('my',function(){
	var my=localStorage.getItem('$user');
	return JSON.parse(my);
})
.factory('httpService',function($http,$q,my){
		this.postData=function(url,userStr){
			 var deferred=$q.defer();
	 	    var promise=deferred.promise;
			 console.log(my);

			 var apiUrl=authUrl+'?access-token='+my.access_token;
			 var params=angular.toJson(userStr,true);
			  $http({
				 url:apiUrl,
				 method:'POST',
				 data:params,
				 timeout:6000
			 }).success(function(res){
			 	deferred.resolve(res);
			 }).error(function(e){
			 	deferred.reject(e);
			 });
			 return promise;
	}
})
.factory('Chats', function() {
  // Might use a resource here that returns a JSON array

  // Some fake testing data
  var chats = [{
    id: 0,
    name: 'Ben Sparrow',
    lastText: 'You on your way?',
    face: 'img/ben.png'
  }, {
    id: 1,
    name: 'Max Lynx',
    lastText: 'Hey, it\'s me',
    face: 'img/max.png'
  }, {
    id: 2,
    name: 'Adam Bradleyson',
    lastText: 'I should buy a boat',
    face: 'img/adam.jpg'
  }, {
    id: 3,
    name: 'Perry Governor',
    lastText: 'Look at my mukluks!',
    face: 'img/perry.png'
  }, {
    id: 4,
    name: 'Mike Harrington',
    lastText: 'This is wicked good ice cream.',
    face: 'img/mike.png'
  }];

  return {
    all: function() {
      return chats;
    },
    remove: function(chat) {
      chats.splice(chats.indexOf(chat), 1);
    },
    get: function(chatId) {
      for (var i = 0; i < chats.length; i++) {
        if (chats[i].id === parseInt(chatId)) {
          return chats[i];
        }
      }
      return null;
    }
  };
});
