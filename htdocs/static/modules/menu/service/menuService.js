'use strict';

angular.module('app').service('menuService',
[         '$http','BaseService',
function(  $http,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
    "dataUrl":'index.php/menudata/data/format/json',
    "dataIdUrl":'index.php/menudata/data/id/:id/format/json',
    "batchUrl":''
  });

  return service;
}]);
