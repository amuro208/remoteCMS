'use strict';

angular.module('app').controller('UserDataHandlerController',
[       '$scope','$http','$controller','$log','userService','$location',
function($scope,  $http,  $controller,  $log,  userService,  $location) {

  $controller('BaseController', { $scope: $scope });
  $scope.basicService = userService;
  $scope.routeUrl = {
    "list":"/app/user/event/TOTAL",
    "detail":"/app/user/detail"
  };

}]);
