'use strict';

angular.module('app').controller('LocalRfidScanListController',
[       '$scope','$location','localrfidscanService','$controller','$q','$http','$stateParams',
function($scope,  $location,  localrfidscanService,  $controller,  $q,  $http,  $stateParams) {
  
  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = localrfidscanService;
  $scope.title = "Local Scanned RFID";

  $scope.listTableOptions = {
    page:1,
    count:10,
    sorting: {
      id:'desc'
    }
  };

}]);
