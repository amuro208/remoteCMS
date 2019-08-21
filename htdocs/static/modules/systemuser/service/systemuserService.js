'use strict';

angular.module('app').service('systemuserService',
[         '$http','BaseService',
function(  $http,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
    "dataUrl":'index.php/accountdata/data/format/json',
    "dataIdUrl":'index.php/accountdata/data/id/:id/format/json',
    "batchUrl":''
  });

  return service;
}]);
