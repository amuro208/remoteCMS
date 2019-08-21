'use strict';

angular.module('app').controller('LocalUserListController',
[       '$scope','$location','localuserService','$controller','$q','$http','$stateParams',
function($scope,  $location,  localuserService,  $controller,  $q,  $http,  $stateParams) {
  
  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = localuserService;
  $scope.title = "Local User";
  
  if($stateParams.maderation == "y"){
    $scope.title = "Local Maderation";
    $scope.maderateMode = true;
    $scope.listService.dataUrl = "index.php/localuserdata/data/maderation/y/format/json";
  }else{
    $scope.title = "Local User";
    $scope.maderateMode = false;
    $scope.listService.dataUrl = "index.php/localuserdata/data/format/json";
  }

  if($scope.maderateMode){
    $scope.listTableOptions = {
      page:1,
      count:1000,
      sorting: {
        id:'desc'
      }
    };
  }else{
    $scope.listTableOptions = {
      page:1,
      count:10,
      sorting: {
        id:'desc'
      }
    };
  }

  $scope.onClickApproved = function(data){
    if(data.isApproved == true) 
      data.isApproved = "Y";
    else
      data.isApproved = "N";
    $scope.listService.updateData(data);
  };

  $scope.onClickRemoteSynced = function(data){
    if(data.isRemoteSynced == true) 
      data.isRemoteSynced = "Y";
    else
      data.isRemoteSynced = "N";
    $scope.listService.updateData(data);
  };

  $scope.onClickMaderate = function(){
    var maxid = 0;
    var list = $scope.listService.getAllDatasByPage();
    for(var i in list.data){
      if(list.data[i].id > maxid){
        maxid = list.data[i].id;
      }
    }
    var url="index.php/localuserdata/maderate/maxid/"+maxid+"/format/json";
    $scope.listService.fetchDataFromUrl(url).then(function(){
      $scope.$broadcast("reloadData");
    });
  }

}]);
