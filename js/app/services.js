'use strict';

/**
 * Services
 */

// data server
var server = 'http://b52test.apiary.io/api/v1/';

// application
//var app = angular.module('b52Services', ['ngResource']);

/*
angular.module('menuBaseServices', ['ngResource']).
    factory('MenuBase', function($resource){
  return  $resource(server + 'menu', {}, {
    query: {method:'GET', params:{}, isArray:true}
    });
 });*/

 /*
angular.module('menuBaseServices', ['ngResource'])
.factory('MenuBase', function($resource) {
  return $resource('menus/menuBase.json',{ }, {
    getData: {method:'GET', isArray: false}
  });
});
 */ 

angular.module('menuServices', ['ngResource']).
    factory('Menu', function($resource){
    
  return $resource(server + 'menu/', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
 });
  
  
 angular.module('categoryServices', ['ngResource']).
    factory('Category', function($resource){
    return $resource(server + 'categories', {}, {
      query: {method:'GET', params:{}, isArray:true},
      get: {method:'GET', params:{}, isArray:true},
      getItems: {url: '/categories/items/:@type' , method:'GET', params:{}, isArray:true},
  });
 });
  

angular.module('itemServices', ['ngResource']).
    factory('Item', function($resource)
    {
        return $resource(server + 'items/:id/type/:type', {}, {
        query: {method:'GET', params:{}, isArray:true},
        //get: {method:'GET', params:{id:'{id}'}, isArray:true},
        get: {method:'GET', params:{}, isArray:false}
        //one: {url:server + 'items/detail' ,method:'GET', params:{id:'{id}'}, isArray:false}
    });
 })
    
    
    //dev
    
angular.module('tablesServices', ['ngResource']).
    factory('Table', function($resource){
  return $resource('tables/:num.json', {}, {
    query: {method:'GET', params:{num:'tables'}, isArray:true}
  });
});


