angular.module('eoil.controllers', [])

.controller('DashCtrl', function($scope) {
	$scope.items=['1','2','3','4'];
})

.controller('OrderCtrl', function($scope, $ionicPopup,Chats) {
  // With the new view caching in Ionic, Controllers are only called
  // when they are recreated or on app start, instead of every page change.
  // To listen for when this page is active (for example, to refresh data),
  // listen for the $ionicView.enter event:
  //
  //$scope.$on('$ionicView.enter', function(e) {
  //});

  $scope.chats = Chats.all();
  $scope.moreData=true;
  $scope.loadMore=function(){
  	// alert('加载更多');
  	  console.log('加载更多');
  	 $scope.$broadcast('scroll.infiniteScrollComplete');
  	 $scope.moreData=false;
  }
  $scope.doRefresh=function(){
  	console.log($scope.chats,Chats.all());
  	_.concat($scope.chats,Chats.all());
  	 console.log($scope.chats);
  	 var confirmPopup = $ionicPopup.confirm({
       title: '下拉刷新',
       template: '你正在下拉刷新'
     });
     $scope.$broadcast('scroll.refreshComplete');
  }
  $scope.remove = function(chat) {
    Chats.remove(chat);
  };
})
.controller('PublishCtrl', function($scope, $state,Chats) {

  $scope.chats = Chats.all();
  $scope.remove = function(chat) {
    Chats.remove(chat);
  };
})
.controller('CartCtrl', function($scope, Chats) {

  $scope.chats = Chats.all();
  $scope.remove = function(chat) {
    Chats.remove(chat);
  };
})


.controller('ChatDetailCtrl', function($scope, $stateParams, Chats) {
  $scope.chat = Chats.get($stateParams.chatId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  };
});
