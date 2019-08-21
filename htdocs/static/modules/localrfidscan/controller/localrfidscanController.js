'use strict';

angular.module('app').controller('LocalRfidScanController',
    [       '$scope','$rootScope','localrfidscanService','$controller',
    function($scope,  $rootScope,  localrfidscanService,  $controller) {

    $rootScope.listParams = null;
    $scope.moduleName = "app.user.total";
    
    $controller('BaseController', { $scope: $scope });
    $scope.basicService = localrfidscanService;
    $scope.routeUrl = {
      "list":"/app/localrfidscan/list",
      "detail":"/app/localrfidscan/detail"
    };
}]);
