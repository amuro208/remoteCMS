'use strict';

angular.module('app').controller('MainTodoSortableController',
[       '$scope','customerTodoService','blockUI',
function($scope,  customerTodoService,  blockUI){

    if($scope.checkCreatableAuthority("app.main")){
      $scope.sortableOptions = {
        accept: function (sourceItemHandleScope, destSortableScope) {
          return sourceItemHandleScope.itemScope.sortableScope.$id != destSortableScope.$id;
        },
        dragStart:function(event){
        },
        dragEnd:function(event){
        },
        dragCancel:function(event){
        },
        itemMoved: function (event) {
          blockUI.start("Loading...");
          var dest_employee = event.dest.sortableScope.$parent.employee;
          var source_todo = event.source.itemScope.todo;
          customerTodoService.postDataToUrl(
            "index.php/customertododata/movetodo/format/json",
            {employeeId:dest_employee.id,todoId:source_todo.id,customerTermServiceId:source_todo.customerTermServiceId}
          ).then(function(){
            blockUI.stop();
            $scope.reloadList();
          },function(reason) {
            blockUI.stop();
            alert('Failed: ' + reason);
          });
        },
        orderChanged: function(event) {
        },
      };
    }else{
      $scope.sortableOptions = {
        accept: function (sourceItemHandleScope, destSortableScope) {
          return sourceItemHandleScope.itemScope.sortableScope.$id === destSortableScope.$id;
        },
        itemMoved: function (event) {

        },
        orderChanged: function(event) {
          var ndx = 0;
          var orderData = $scope.todoListData.map(function(i){
            i.reserve5 = ndx; ndx++;
            return i.customerTermServiceId;
          }).join(',');
          console.log(orderData);
          customerTodoService.postDataToUrl("index.php/customertododata/order/format/json",{order:orderData});
        },
      };
    }


    $scope.reloadList = function(){
      if($scope.checkCreatableAuthority("app.main")){
        //allemployeetodo
        var url = "index.php/customertododata/allemployeetodo/format/json";
        customerTodoService.fetchDataFromUrl(url).then(function(listdata){
          console.log(listdata);
          $scope.todoListOriginData = listdata;
          $scope.todoListData = angular.copy(listdata);
        });
      }else{
        var user = $scope.getUser();
        customerTodoService.listDataByParams({
          filter:{
            employeeId:user.employeeId,
            reserve1:'Y',
            handledDate:'NULL'
          },
          sorting:{
            'reserve5':'ASC'
          }
        }).then(function(datalist){
          $scope.todoListData = datalist;
        });
      }
    }

    $scope.$on("reloadTodoList",function(){
      $scope.reloadList();
    });

    $scope.reloadList();

}]);
