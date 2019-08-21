'use strict';

angular.module('app').service('statisticService',
[         '$http','BaseService',
function(  $http,  BaseService) {

  var service = angular.copy(BaseService);
  service.initWithPage({
    "dataUrl":'index.php/report/statistic/data/',
    "dataIdUrl":'index.php/report/statistic/data',
    "batchUrl":''
  });

  return service;
}]);
