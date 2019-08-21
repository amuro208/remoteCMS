'use strict';

angular.module('app').service('localrfidscanService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  //service.init({
  service.initWithPage({
    "dataUrl":'index.php/localrfidscandata/data/format/json',
    "dataIdUrl":'index.php/localrfidscandata/data/id/:id/format/json',
  });

  return service;
}]);
