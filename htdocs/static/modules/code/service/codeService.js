'use strict';

angular.module('app').service('codeService',
[         '$http','$q','BaseService',
function(  $http,  $q,  BaseService) {

  var service = angular.copy(BaseService);
  service.init({
  //service.initWithPage({
    "dataUrl":'index.php/codedata/data/format/json',
    "dataIdUrl":'index.php/codedata/data/id/:id/format/json',
    "batchUrl":'index.php/api/batch/stype/code/format/json'
  });

  service.getOptions = function(category){
    var datas = [];
    var allDatas = this.getAllDatas();
    for ( var x in allDatas) {
      var data = allDatas[x];
      if(data.category == category){
        datas.push({"name":data.name,"code":data.code});
      }
    }
    return datas;
  };

  service.getCodeName = function(category,code){
    if(category == undefined || category == null) return "";
    if(code == undefined || code == null) return "";

    var allDatas = this.getAllDatas();
    for ( var x in allDatas) {
      var data = allDatas[x];
      if(data.category == category && data.code == code){
        return data.name;
      }
    }
    return "";
  }

  return service;
}]);
