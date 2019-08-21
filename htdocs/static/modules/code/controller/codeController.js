'use strict';

angular.module('app').controller('CodeController',
    [       '$scope','$rootScope','codeService','$controller',
    function($scope,  $rootScope,  codeService,  $controller) {

    $rootScope.listParams = null;

    $scope.moduleName = "app.system.code";
    $controller('CodeDataHandlerController',{$scope:$scope});
}]);
