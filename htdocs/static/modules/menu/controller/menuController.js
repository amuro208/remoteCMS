'use strict';

angular.module('app').controller('SystemMenuController',
  [       '$scope','$log','$controller','menuService',
  function($scope,  $log,  $controller,  menuService) {

    $scope.moduleName = "app.system.menu";

    $controller("MenuDataHandlerController",{$scope:$scope});

    var listParams = {
      "sorting":{
        "order":"ASC"
      }
    };
    menuService.listDataByParams(listParams,menuService.dataUrl).then(function(datalist){
      var menuLoad = datalist;
      var treeData = menuService.getTree2(menuLoad,"id","pid");
      $scope.treeData = treeData;
    });

    $scope.$on('reloadData',function(){
      var menuLoad = menuService.getAllDatas();
      $scope.treeData = menuService.getTree2(menuLoad,"id","pid");
      $scope.showMenuPanel = false;
    });

}]);
