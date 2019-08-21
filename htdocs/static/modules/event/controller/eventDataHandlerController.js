'use strict';

angular.module('app').controller('EventDataHandlerController',
[       '$scope','$http','$controller','$log','eventService','$location','codeService',
function($scope,  $http,  $controller,  $log,  eventService,  $location,  codeService) {

  $controller('BaseController', { $scope: $scope });
  $scope.basicService = eventService;
  $scope.routeUrl = {
    "list":"/app/system/event/list",
    "detail":"/app/system/event/detail"
  };

  codeService.promise.then(function(){
    $scope.eventCodeOptions = codeService.getOptions("EVENT");
    $scope.siteCodeOptions = codeService.getOptions("SITE");
    $scope.projectCodeOptions = codeService.getOptions("PROJECT");

  });

}]);
