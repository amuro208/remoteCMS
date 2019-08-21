'use strict';

angular.module('app').service('roleService',
[         '$http','BaseService',
function(  $http,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
    "dataUrl":'index.php/roledata/data/format/json',
    "dataIdUrl":'index.php/roledata/data/id/:id/format/json',
    "batchUrl":''
  });
  return service;
}]);
