'use strict';

angular.module('app').controller('StatisticListController',
[       '$scope','statisticService','$controller','$q','codeService','$http','$stateParams',
function($scope,  statisticService,  $controller,  $q,  codeService,  $http, $stateParams) {

  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = statisticService;
  if($stateParams.project != null && $stateParams.project != undefined){
    $scope.listService.dataUrl = 'index.php/report/statistic/data/projectCode/'+$stateParams.project+'/format/json';
    console.log("$scope.listService.dataUrl : "+$scope.listService.dataUrl);
  }
  $scope.listTableOptions = {
    count:1000,
    sorting: {
      rn:'asc'
    }
  };

  $scope.csvDownload = function(){
    var url = 'index.php/report/statistic/data/format/csv';
    if($stateParams.project != null && $stateParams.project != undefined){
      url = 'index.php/report/statistic/data/projectCode/'+$stateParams.project+'/format/csv';
    }

    $http({method: 'GET', url: url}).
      success(function(data, status, headers, config) {
        var element = angular.element('<a/>');
        element.attr({
          href: 'data:attachment/csv;charset=utf-8,' + encodeURI(data),
          target: '_blank',
          download: 'statistic.csv'
        })[0].click();
      }).
      error(function(data, status, headers, config) {
        // if there's an error you should see it here
      });
  };

  $scope.csvAllRawDownload = function(){
    var url = 'index.php/report/statistic/allrawdata/format/csv';
    if($stateParams.project != null && $stateParams.project != undefined){
      url = 'index.php/report/statistic/allrawdata/projectCode/'+$stateParams.project+'/format/csv';
    }
    $http({method: 'GET', url: url}).
    success(function(data, status, headers, config) {
      var element = angular.element('<a/>');
      element.attr({
        href: 'data:attachment/csv;charset=utf-8,' + encodeURI(data),
        target: '_blank',
        download: 'AllRawData.csv'
      })[0].click();
    }).
    error(function(data, status, headers, config) {
      // if there's an error you should see it here
    });
  };

}]);
