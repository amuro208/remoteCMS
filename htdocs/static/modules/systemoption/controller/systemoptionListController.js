'use strict';

angular.module('app').controller('SystemOptionListController',
[       '$scope','$location','systemoptionService','$controller','$q','$http',
function($scope,  $location,  systemoptionService,  $controller,  $q,  $http) {
  
  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = systemoptionService;

  $scope.listTableOptions = {
    sorting: {
      id:'asc'
    }
  };

}]);
