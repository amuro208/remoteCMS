'use strict';

angular.module('app').controller('LocalUserController',
    [       '$scope','$rootScope','localuserService','$controller',
    function($scope,  $rootScope,  localuserService,  $controller) {

    $rootScope.listParams = null;
    $scope.moduleName = "app.user.total";
    
    $controller('BaseController', { $scope: $scope });
    $scope.basicService = localuserService;
    $scope.routeUrl = {
      "list":"/app/localuser/list",
      "detail":"/app/localuser/detail"
    };
}]);
