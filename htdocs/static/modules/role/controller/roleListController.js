'use strict';

angular.module('app').controller('RoleListController',
[       '$scope','roleService','$controller',
function($scope,  roleService,  $controller) {

  $controller('BaseListController',{$scope:$scope});
  $scope.listData = [];
  $scope.listService = roleService;

  $scope.listTableOptions = {
    sorting: {
      name: 'asc',
    }
  };

}]);
