'use strict';

angular.module('app').controller('SystemUserRolePanelController',
[       '$scope','systemuserroleService','roleService','$controller','$filter','ngTableParams',
function($scope,  systemuserroleService,  roleService,  $controller,  $filter,  ngTableParams) {

  $scope.currentSystemUser = null;
  $scope.showRolePanel = false;

  //For User Role List
  $controller('BaseListController',{$scope:$scope});
  $scope.listService = systemuserroleService;
  $scope.removePager = true;
  $scope.listTableOptions = {
  };

  roleService.listData().then(function(datalist){
    $scope.roleOptions = roleService.getOptions();
  });

  //From SystemUserController....
  $scope.$on('reloadRoleList',function($event,data){
    $scope.currentSystemUser = data;
    $scope.reloadRoleList(data);
  });

  $scope.reloadRoleList = function(branch){
    systemuserroleService.listDataByParams({
      filter:{
        aid:$scope.currentSystemUser.id
      }
    }).then(function(listdata){
      $scope.reloadList(listdata);
    });
  }

  $scope.openRole = function(){
    $scope.showRolePanel = true;
    $scope.modifiedData = {};
  };

  $scope.addRole = function(){
    $scope.showRolePanel = false;
    systemuserroleService.createData({
      aid:$scope.currentSystemUser.id,
      roleId:$scope.modifiedData.roleId
    }).then(function(){
      $scope.reloadRoleList();
    });
    $scope.modifiedData = {};
  };

  $scope.deleteRole = function(data){
    systemuserroleService.deleteData(data).then(function(data){
      $scope.reloadRoleList();
    });
  }

  $scope.cancelRole = function(){
    $scope.showRolePanel = false;
    $scope.modifiedData = {};
  };

}]);
