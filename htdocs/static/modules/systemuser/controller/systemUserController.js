'use strict';

angular.module('app').controller('SystemUserController',
    [       '$scope','systemuserService','systemuserroleService','roleService','$log','$controller',
    function($scope,  systemuserService,  systemuserroleService,  roleService,  $log,  $controller) {

    $controller('BaseController', { $scope: $scope });
    $scope.moduleName = "app.system.user";

    $scope.tree_data = [{}];

    $scope.expanding_property = "email";
    $scope.col_defs = [
      { field: "firstName", displayName:"First Name", colWidth:"150px"},
      { field: "lastName", displayName:"Last Name", colWidth:"150px"},
      { field: "approval", displayName:"Approval", colWidth:"80px"},
    ];

    $scope.showUserRolePanel = false;

    $scope.onSelectedTree = function(branch){
      $scope.showUserRolePanel = true;
      $scope.$broadcast('reloadRoleList',branch);
    }

    systemuserService.listData(true).then(function(listdata){
      var treeData = systemuserService.getTree(listdata,"id","pid");
      $scope.tree_data = treeData;
    });


    $scope.showSystemUserPanel = false;


    $scope._postCreateData = function(){
      $scope.showSystemUserPanel = true;
    }
    $scope._postModifyData = function(data){
      $scope.showSystemUserPanel = true;
    }

    $scope.createSubData = function(scope){
      alert("createSubData");
      $scope.modifiedData = {};
      $scope.showSystemUserPanel = true;
      //$scope.modifiedData.pid = scope.$modelValue.id;
      $scope.mode = "create";
    }






    $scope.onCommand = function(command,branch){
      if(command == "modify"){
        $scope.showSystemUserPanel = true;
        //$scope.modifiedData = angular.copy(branch);
        //$scope.modifiedData.approval = ($scope.modifiedData.approval=='Y');
        //$scope.modifiedData.password = "";
        $scope.modifyData(branch);

      }
      if(command == "delete"){
        systemuserService.deleteData($scope.modifiedData).then(function(data){
          var alldatas = systemuserService.getAllDatas();
          for(var i in alldatas){
            if(alldatas[i].id == data.id){
              alldatas.splice(i,1);
            }
          }
          systemuserService.setAllDatas(alldatas);
          var treeData = systemuserService.getTree(alldatas,"id","pid");
          $scope.tree_data = treeData;
        });
      }
    }

    $scope.cancelSystemUser = function(){
      $scope.showSystemUserPanel = false;
    }

    $scope.editSystemUser = function(){
      $scope.showSystemUserPanel = false;
      $scope.modifiedData.approval = $scope.modifiedData.approval?'Y':'N';

      systemuserService.updateData($scope.modifiedData).then(function(data){
        var alldatas = systemuserService.getAllDatas();
        for(var i in alldatas){
          if(alldatas[i].id == data.id){
            alldatas[i] = data;
          }
        }
        systemuserService.setAllDatas(alldatas);
        var treeData = systemuserService.getTree(alldatas,"id","pid");
        $scope.tree_data = treeData;
      });
    }

}]);
