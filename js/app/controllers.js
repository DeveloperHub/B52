'use strict';

/**
 * Controllers
 */

function MenuCtrl($scope, Menu) {
  
  
  console.log('menu');
  
  $scope.menus = Menu.query(
      function()
      {
         console.log( $scope.menus);
      }
      );
  
  //$scope.orderProp = 'age';
  
  //? jak se dostanu na basket
  $scope.test = function(arg)
  {
    alert('test kde jsem');
    //console.log(arg);
    console.log($scope.basket);
    //console.log($scope);
    
  }
}

function CategoriesCtrl($scope, $routeParams, Category ) 
{ 
    //$scope.current = MenuBase.get({type: $routeParams.type});
    
    
    //$routeParams.subtype = ($routeParams.subtype != null)  ?  $routeParams.subtype  : '';
  
    $scope.categoriesvisible = 'block';
    
    //$scope.categories = Category.query();
    
    console.log('argumenty type: ' + $routeParams.type);
    
    $scope.categories = Category.getItems({type: $routeParams.type , action : 'parent' }, function(cat) {
        //console.log('chci item:' + item.type);
        console.log($scope.categories);
        //$scope.menu.categoriesvisible = ( ( $scope.menu.categories == null) || $scope.menu.categories.length == 0) ? 'none' : 'block';
        //$scope.menu.itemsvisible = ( ( $scope.menu.items == null) || $scope.menu.items.length == 0) ? 'none' : 'block';
    });
    
    $scope.currentCategory = Category.get( {type: $routeParams.type } );
    
    return;
    
  /*
    $scope.menu = Menu.get({type: $routeParams.type , subtype : $routeParams.subtype }, function(item) {
        
    //$scope.mainImageUrl = phone.images[0];
    //console.log('chci item:' + item.type);
        
       // $scope.parent = $routeParams.type + '/';
    
    
        //console.log('cat:' + $scope.menu.categories.length);
        console.log($scope.menu);

         //$scope.menu.categoriesvisible = ( ( $scope.menu.categories == null) || $scope.menu.categories.length == 0) ? 'none' : 'block';
         //$scope.menu.itemsvisible = ( ( $scope.menu.items == null) || $scope.menu.items.length == 0) ? 'none' : 'block';
   
    });
*/
    
/*
  $scope.setImage = function(imageUrl) {
    $scope.mainImageUrl = imageUrl;
    
  }*/
}

function ItemsCtrl($scope, $routeParams, Item, Category ) 
{ 
    //$routeParams.subtype = ($routeParams.subtype != null)  ?  $routeParams.subtype  : '';
    
    //$scope.items = Item.query();
    
    console.log('argumenty v cat type: ' + $routeParams.type);
    
    //konkretni kategoeii
    $scope.currentCategory = Category.get( {type: $routeParams.type }, 
        function(item) {
        //console.log('chci item:' + item.type);
        console.log($scope.currentCategory);
        //$scope.menu.categoriesvisible = ( ( $scope.menu.categories == null) || $scope.menu.categories.length == 0) ? 'none' : 'block';
        //$scope.menu.itemsvisible = ( ( $scope.menu.items == null) || $scope.menu.items.length == 0) ? 'none' : 'block';
    });
    
    $scope.items = Item.getOnCategory({type: $routeParams.type }, function(item) {
        //console.log('chci item:' + item.type);
        console.log($scope.items);
        //$scope.menu.categoriesvisible = ( ( $scope.menu.categories == null) || $scope.menu.categories.length == 0) ? 'none' : 'block';
        //$scope.menu.itemsvisible = ( ( $scope.menu.items == null) || $scope.menu.items.length == 0) ? 'none' : 'block';
    });
}

function ItemsDetailCtrl ($scope, $routeParams, Item ) 
{ 
    //$scope.items = Item.query();
    
    console.log('argumenty type: ' + $routeParams.id);
    
    //ziskam radu items
    
    
    
     $scope.item = Item.get({id: $routeParams.id}, function(item) {
    //$scope.mainImageUrl = phone.images[0];
    
    console.log($scope.item);
    console.log(item);
    
    });
    
    
    /*
    $scope.item = Item.one({id:$routeParams.id}, function(item) {
        console.log('chci item:' + item);
        console.log($scope.item);
        //$scope.menu.categoriesvisible = ( ( $scope.menu.categories == null) || $scope.menu.categories.length == 0) ? 'none' : 'block';
        //$scope.menu.itemsvisible = ( ( $scope.menu.items == null) || $scope.menu.items.length == 0) ? 'none' : 'block';
    });
    */
    
   $scope.toBinItem = function(id) 
   {
       console.log('objednavam item: ' + id);
   }
    
}


function OrdersCtrl($scope, Order) {
  
  $scope.menus = Menu.query();
  //$scope.orderProp = 'age';
  
  //? jak se dostanu na basket
  $scope.test = function(arg)
  {
    alert('test kde jsem');
    //console.log(arg);
    console.log($scope.basket);
    //console.log($scope);
    
  }
}