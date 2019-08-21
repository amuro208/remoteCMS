'use strict';

angular.module('app').service('systemoptionService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  service.initWithPage({
    "dataUrl":'index.php/systemoptiondata/data/format/json',
    "dataIdUrl":'index.php/systemoptiondata/data/id/:id/format/json',
  });

  return service;
}]);
