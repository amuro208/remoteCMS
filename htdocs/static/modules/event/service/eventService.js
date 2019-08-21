'use strict';

angular.module('app').service('eventService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
    "dataUrl":'index.php/eventdata/data/format/json',
    "dataIdUrl":'index.php/eventdata/data/id/:id/format/json',
  });

  return service;
}]);
