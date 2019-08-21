'use strict';

angular.module('app').controller('RoleDataHandlerController',
[       '$scope','$controller','$log','roleService',
function($scope,  $controller,  $log,  roleService) {

  $controller('BaseController', { $scope: $scope });
  console.log("RoleDataHandlerController");
  $scope.basicService = roleService;
  $scope.routeUrl = {
    "list":"/app/system/role/list",
    "detail":"/app/system/role/detail"
  };
  ///////////////////////////////////////////////////
  // CRUD Process Interface with View
  ///////////////////////////////////////////////////
  $scope._postCreateData = function(){
    //console.log("_postCreateData");
	setTimeout(function(){$scope.$broadcast('reloadTree',$scope.modifiedData);},100);
    
  }

  $scope._postModifyData = function(){
    setTimeout(function(){$scope.$broadcast('reloadTree',$scope.modifiedData);},100);
  }

  ////////////////////////////////////////////////////////////
  // Overrided CRUD PROCESS
  ////////////////////////////////////////////////////////////
  $scope._preCreate = function(data){
    var menudata = roleService.reverseTree($scope.tree_data);
    data.menudata = menudata;
    return data;
  }

}]);
