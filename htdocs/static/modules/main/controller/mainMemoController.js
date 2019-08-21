'use strict';

angular.module('app').controller('MainMemoController',
[       '$scope','$controller','customerService','employeeService','customerMemoService',
function($scope,  $controller,  customerService,  employeeService,  customerMemoService){

  $controller('DialogBaseController',{$scope:$scope});

  //customerService.promise.then(function(){
  //  $scope.customerTypeAHeadData = customerService.getTypeAHeadData();
  //});

  customerService.getTypeAHeadData().then(function(data){
    $scope.customerTypeAHeadData = data;
  });

  employeeService.promise.then(function(answer){
    $scope.employeeOptions = employeeService.getOptions();
  });

  $scope.showMemoForm = false;

  $scope.createMemo = function(){
    $scope.showMemoForm = true;
    $scope.memoData = {};
  }

  $scope.cancelMemo = function(){
    $scope.showMemoForm = false;
  }

  $scope.saveMemo = function(form){
    $scope._saveConfirmDialog().result.then(function(){
      //Yes
      $scope.memoData.fromId = $scope.getUser().employeeId;
      $scope.memoData.memoDate = $scope.today;
      if($scope.memoData.toId != null && $scope.memoData.toId != ""){
        $scope.memoData.statusCode = "OP";
      }else{
        $scope.memoData.statusCode = "CL";
      }
      customerMemoService.createData($scope.memoData).then(function(data){
        $scope.showMemoForm = false;
      });

      form.$setPristine(true);
    },function(){
      //NO
    });
  }

  $scope.reloadMemoList = function(){
    var user = $scope.getUser();
    customerMemoService.listDataByParams({
      filter:{
        toId:user.employeeId,
        statusCode:'OP'
      }
    }).then(function(datalist){
      $scope.memoListData = datalist;
    });
  }

  $scope.doneMemo = function(memo){
    $scope._doneConfirmDialog().result.then(function(){
      //Yes
      memo.statusCode = "CL";
      customerMemoService.updateData(memo).then(function(){
        $scope.reloadMemoList();
      });

    },function(){
      //NO
    });
  };

  $scope.onItemSelected = function(value) {
    //$scope.associationData.refId = value;
  };

  $scope.onClickedNewCustomer = function(){
    //$scope.customersearch = "";
  }

  $scope.reloadMemoList();
}]);
