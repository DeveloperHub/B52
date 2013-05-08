'use strict';

/**
 * Services
 */

// data server
//var server = 'http://b52test.apiary.io/api/v1/';
//var server = 'http://b52.apiary.io/api/v1/';

var server = 'http://b52mike.apiary.io/api/v1/';

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
    
  return $resource(server + 'menu', {}, {
    query: {method:'GET', params:{}, isArray:true}
  });
 });
  
  
 angular.module('categoryServices', ['ngResource']).
    factory('Category', function($resource){
    return $resource(server + 'categories/:type/:action', {}, {
      query: {method:'GET', params:{}, isArray:true},
      get: {method:'GET', params:{ action : '' }, isArray:false},
      getItems: {/*url: '/categories/items/:@type' ,*/ method:'GET', params:{ action : 'parent' }, isArray:true},
  });
 });
  

angular.module('itemServices', ['ngResource']).
    factory('Item', function($resource)
    {
        return $resource(server + 'items/:id:type/:action', {}, {
        query: {method:'GET', params:{}, isArray:true},
        get: {method:'GET', params:{}, isArray:false},
        getOnCategory: {method:'GET', params:{ action : 'category'}, isArray:true}
    });
 })
    
    
    //dev
    
angular.module('tablesServices', ['ngResource']).
    factory('Table', function($resource){
  return $resource('tables/:num.json', {}, {
    query: {method:'GET', params:{num:'tables'}, isArray:true}
  });
});


