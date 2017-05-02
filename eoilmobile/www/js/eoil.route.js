// app路由

angular.module('eoil.route', [])

.config(function($stateProvider, $urlRouterProvider) {

  $stateProvider

  .state('tab', {
    url: '/tab',
    abstract: true,
    templateUrl: 'templates/tabs.html'
  })
  .state('home', {
     url: '/home',
     abstract: true,
     templateUrl: 'templates/home.html'
   })

  // Each tab has its own nav history stack:

  .state('tab.dash', {
    url: '/dash',
    views: {
      'tab-dash': {
        templateUrl: 'templates/tab-dash.html',
        controller: 'DashCtrl'
      }
    }
  })

  .state('tab.order', {
      url: '/order',
      views: {
        'tab-order': {
          templateUrl: 'templates/tab-order.html',
          controller: 'OrderCtrl'
        }
      }
    })
  .state('tab.publish', {
      url: '/publish',
      views: {
        'tab-publish': {
          templateUrl: 'templates/tab-publish.html',
          controller: 'PublishCtrl'
        }
      }
    })
  .state('tab.cart', {
      url: '/cart',
      views: {
        'tab-cart': {
          templateUrl: 'templates/tab-cart.html',
          controller: 'CartCtrl'
        }
      }
    })
    .state('tab.chat-detail', {
      url: '/chats/:chatId',
      views: {
      	'tab-order':{
          templateUrl: 'templates/chat-detail.html',
          controller: 'ChatDetailCtrl'
         }
      }
    })

  .state('tab.account', {
    url: '/account',
    views: {
      'tab-account': {
        templateUrl: 'templates/tab-account.html',
        controller: 'AccountCtrl'
      }
    }
  });

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/tab/dash');

});
