'use strict';

angular.module('app').controller('SystemOptionDataHandlerController',
[       '$scope','$http','$controller','$log','systemoptionService','$location',
function($scope,  $http,  $controller,  $log,  systemoptionService,  $location) {

  $controller('BaseController', { $scope: $scope });
  $scope.basicService = systemoptionService;
  $scope.routeUrl = {
    "list":"/app/system/systemoption/list",
    "detail":"/app/system/systemoption/detail"
  };

}]);
