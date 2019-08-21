'use strict';

angular.module('app').controller('EventListController',
[       '$scope','$location','eventService','$controller','$q','$http','codeService',
function($scope,  $location,  eventService,  $controller,  $q,  $http,  codeService) {

  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = eventService;

  codeService.promise.then(function(){
    $scope.listTableOptions = {
      sorting: {
        id:'asc'
      }
    };

  });

}]);
