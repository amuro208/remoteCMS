'use strict';

angular.module('app').service('systemuserroleService',
[         '$http','BaseService',
function(  $http,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
    "dataUrl":'index.php/accountroledata/data/aid/:aid/format/json',
    "dataIdUrl":'index.php/accountroledata/data/id/:id/format/json',
    "batchUrl":''
  });

  return service;
}]);
