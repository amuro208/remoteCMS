'use strict';

angular.module('app').service('localuserService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  //service.init({
  service.initWithPage({
    "dataUrl":'index.php/localuserdata/data/format/json',
    "dataIdUrl":'index.php/localuserdata/data/id/:id/format/json',
  });

  return service;
}]);
