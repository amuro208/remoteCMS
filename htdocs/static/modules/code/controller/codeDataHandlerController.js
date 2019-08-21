'use strict';

angular.module('app').controller('CodeDataHandlerController',
[       '$scope','$http','$controller','$log','codeService','$location',
function($scope,  $http,  $controller,  $log,  codeService,  $location) {

  $controller('BaseController', { $scope: $scope });
  console.log("CodeDataHandlerController");
  $scope.basicService = codeService;
  $scope.routeUrl = {
    "list":"/app/system/code/list",
    "detail":"/app/system/code/detail"
  };

}]);
