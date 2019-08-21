'use strict';

angular.module('app').service('userEventService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  service.initWithPage({
    "dataUrl":'index.php/userdata/data/format/json',
    "dataIdUrl":'index.php/userdata/data/id/:id/format/json',
  });

  return service;
}]);
