'use strict';

angular.module('app').service('menuroleService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);

  service.init({
    "dataUrl":'index.php/menuroledata/data/roleid/:roleid/format/json',
    "dataIdUrl":'index.php/menuroledata/data/id/:id/format/json',
    "batchUrl":''
  });

  //service.dataUrl = 'index.php/menuroledata/data/roleid/:roleid/format/json';

  service.listDataByRoleId = function(roleid){
    var self = this;

    var deferred = $q.defer();
    var url = self.dataUrl.replace(':roleid',roleid);

    $http.get(url).success(function (data) {
      if(data instanceof Array){
        for(var i in data){
          data[i].selected = false;
        }
      }else{
        data.selected = false;
      }
      self.setAllDatas(data);
      deferred.resolve(data);
    }).error(function(msg, code) {
      deferred.reject(msg);
      $log.error(msg, code);
    });

    return deferred.promise;
  };

  return service;
}]);
