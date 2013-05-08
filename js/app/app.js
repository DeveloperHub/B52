'use strict';

/**
 * Application
 */

var app = angular.module('b52', [/*'b52Filters', 'b52Services',*/ 'menuServices' , 'categoryServices', 'itemServices']).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/menu', {templateUrl: 'partials/menu-list.html',   controller: MenuCtrl}).
      //when('/menu/:type', {templateUrl: 'partials/menu-detail.html',   controller: MenuDetailCtrl}).
      when('/categories/:type/parent', {templateUrl: 'partials/categories-list.html',   controller: CategoriesCtrl}).
      when('/items/:type/category', {templateUrl: 'partials/items-list.html',   controller: ItemsCtrl}).
      when('/items/:id/detail', {templateUrl: 'partials/item-detail.html',   controller: ItemsDetailCtrl}).
      //when('/menu/:type/:subtype', {templateUrl: 'partials/menu-detail.html',   controller: MenuDetailCtrl}).
      //when('/orders/:orderId', {templateUrl: 'partials/order.html', controller: OrdersCtrl}).
      otherwise({redirectTo: '/menu'});
      //otherwise({redirectTo: '/debug'});
}]);

