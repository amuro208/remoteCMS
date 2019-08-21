'use strict';

angular.module('app').controller('UserListController',
[       '$scope','$location','userService','$controller','$q','$http',
function($scope,  $location,  userService,  $controller,  $q,  $http) {

  $controller('BaseListController',{$scope:$scope});
  $scope.title = "User - Total";
  $scope.listData = [];
  $scope.listService = userService;

  $scope.listTableOptions = {
    page:1,
    sorting: {
      id:'desc'
    }
  };
  $scope.getTableTitle = function(d){
    alert("getTableTitle : "+d);
    return "MERO";
  };
  $scope.onClickApproved = function(data){
    if(data.isApproved == true)
      data.isApproved = "Y";
    else
      data.isApproved = "N";
    $scope.listService.updateData(data);
  };

  $scope.onClickSentEamil = function(data){
    if(data.isSentEmail == true)
      data.isSentEmail = "Y";
    else
      data.isSentEmail = "N";
    $scope.listService.updateData(data);
  };

}]);
