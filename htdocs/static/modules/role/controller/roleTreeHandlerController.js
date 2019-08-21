'use strict';

angular.module('app').controller('RoleTreeHandlerController',
[       '$scope','$controller','$timeout','menuService','roleService','menuroleService',
function($scope,  $controller,  $timeout,  menuService,  roleService,  menuroleService) {

  var tree;
  $scope.tree_data = [{}];
  $scope.my_tree = tree = {};
  $scope.expanding_property = "name";
  $scope.col_defs = [
    //{ field: "url", displayName:"URL", colWidth:"150px"},
  ];

  $scope.currentMenuroleData = null;
  $scope.currentRoleData = null;

  var listParams = {
    sorting:{
      "order":"ASC"
    }
  };

  $scope.$on('reloadTree',function(event,data){
   
    if($scope.mode == "create"){
      menuService.listDataByParams(listParams,menuService.dataUrl).then(function(listdata){
        var menulist = listdata;
        var treeData = menuService.getTree(menulist,"id","pid");
        $scope.tree_data = treeData;
		//console.log(treeData);
      });
    }else if($scope.mode == "modify"){
	  $scope.currentRoleData = data;
      menuroleService.listDataByRoleId(data.id).then(function(datalist){
        $scope.currentMenuroleData = datalist;
        menuService.listDataByParams(listParams,menuService.dataUrl).then(function(listdata){
          var menulist = listdata;
          for(var i in datalist){
            for(var j in menulist){

              if(menulist[j].id == datalist[i].menuId){
                menulist[j].readable = datalist[i].readable=="Y"?true:false;
                menulist[j].writable = datalist[i].writable=="Y"?true:false;
                menulist[j].confirmable = datalist[i].confirmable=="Y"?true:false;

                break;
              }
            }
          }

          var treeData = menuService.getTree(menulist,"id","pid");
          $scope.tree_data = treeData;
        });
      });
    }

    //$timeout(function(){
      //if($scope.my_tree != null){
		//console.log("$scope.my_tree "+$scope.my_tree);
        //$scope.my_tree.expand_all();
     // }
    //},500);

  });

  //After declear function on tree-grid directive;
  $scope.onChangeTreeNode = function(data){

    if(!$scope.checkCreatableAuthority("app.system.role")) return;

    if($scope.mode == "create"){
      console.log("create");
    }

    if($scope.mode == "modify"){

      var data2;
      var isFound = false;
      if($scope.currentMenuroleData){
        
        for(var i in $scope.currentMenuroleData){
          if($scope.currentMenuroleData[i].menuId == data.id){
            data2 = $scope.currentMenuroleData[i];
            data2.readable = data.readable;
            data2.writable = data.writable;
            data2.confirmable = data.confirmable;
            isFound = true;
            break;
          }
        }

        if(!isFound){
          data2 = {};
          data2.menuId = data.id;
          data2.roleId = $scope.currentRoleData.id;
          data2.readable = data.readable;
          data2.writable = data.writable;
          data2.confirmable = data.confirmable;
          
          menuroleService.updateData(data2).then(function(response){
            $scope.currentMenuroleData[$scope.currentMenuroleData.length] = response;
          });
        }else{
          menuroleService.updateData(data2).then(function(response){
          });
        }
      }
    }
    return true;
  };

}]);
