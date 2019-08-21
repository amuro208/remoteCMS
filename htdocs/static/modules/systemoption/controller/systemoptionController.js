'use strict';

angular.module('app').controller('SystemOptionController',
    [       '$scope','$rootScope','systemoptionService','$controller',
    function($scope,  $rootScope,  systemoptionService,  $controller) {

    $rootScope.listParams = null;

    $scope.moduleName = "app.system.systemoption";
    $controller('SystemOptionDataHandlerController',{$scope:$scope});
}]);
