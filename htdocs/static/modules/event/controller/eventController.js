'use strict';

angular.module('app').controller('EventController',
    [       '$scope','$rootScope','eventService','$controller',
    function($scope,  $rootScope,  eventService,  $controller) {

    $rootScope.listParams = null;

    $scope.moduleName = "app.system.event";
    $controller('EventDataHandlerController',{$scope:$scope});
}]);
