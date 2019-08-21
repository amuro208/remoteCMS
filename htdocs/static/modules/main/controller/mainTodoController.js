'use strict';

angular.module('app').controller('MainTodoController',
[       '$scope','$controller','$q','customerService','employeeService','customerTodoService','$timeout',
function($scope,  $controller,  $q,  customerService,  employeeService,  customerTodoService,  $timeout){

  $controller('DialogBaseController',{$scope:$scope});

  $scope.memoTodo = function(todo){
    $scope.showTodoForm = true;
    $scope.todoData = todo;
    $scope.todoData.memo = todo.note;
    $scope.mode = "edit";
  }

  $scope.editTodo = function(form){
    $scope._changeConfirmDialog().result.then(function(){
      //Yes
      $scope.todoData.note = $scope.todoData.memo;
      customerTodoService.updateData($scope.todoData).then(function(){
        $scope.$broadcast("reloadTodoList");
        $scope.showTodoForm = false;
        $scope.mode = "";
      });
    },function(){
      //NO
    });
  }

  $scope.showTodoForm = false;
  $scope.showTodoTextForm = false;
  $scope.showTodoNumberForm = false;
  $scope.showTodoCurrencyForm = false;
  $scope.cancelConformTodo = function(){
    $scope.showTodoForm = false;
    $scope.showTodoTextForm = false;
    $scope.showTodoNumberForm = false;
    $scope.showTodoCurrencyForm = false;
    $scope.mode = "";
  }

  var currentTodo = null;
  $scope.confirmTodo = function(form){
    var todo = currentTodo;
    $scope._doneConfirmDialog().result.then(function(){
      //Yes
      todo.isDone = 'Y';
      todo.note = $scope.todoData.memo;
      todo.reserve2 = $scope.todoData.reserve2;

      $scope.updateTodoData(todo);

      $scope.showTodoForm = false;
      $scope.showTodoTextForm = false;
      $scope.showTodoNumberForm = false;
      $scope.showTodoCurrencyForm = false;

      currentTodo = null;
      $scope.todoData = {};
      $scope.mode = "";

    },function(){
      //NO
    });
  }

  $scope.updateTodoData = function(todo){
    todo.handledDate = $scope.today;
    customerTodoService.updateData(todo).then(function(){
      $scope.$broadcast("reloadTodoList");
    });
  }

  $scope.doneTodo = function(todo){
    if(todo.task.inputTypeCode == "CK"){
      $scope._doneConfirmDialog().result.then(function(){
        //Yes
        todo.isDone = 'Y';
        $scope.updateTodoData(todo);
      },function(){
        //NO
      });
    }else{
      //$scope.showTodoForm = true;
      if(todo.task.inputTypeCode == "TX"){
        $scope.showTodoTextForm = true; 
      }else if(todo.task.inputTypeCode == "NM"){
        $scope.showTodoNumberForm = true; 
      }else if(todo.task.inputTypeCode == "CT"){
        $scope.showTodoCurrencyForm = true; 
      }
      currentTodo = todo;
      $scope.todoData = {};
      $scope.mode = "confirm";
    }

  }

  $scope.cancelTodo = function(todo){
    $scope._cancelConfirmDialog().result.then(function(){
      //Yes
      todo.isCancel = 'Y';
      $scope.updateTodoData(todo);

    },function(){
      //NO
    });
  }

  $scope.rejectTodo = function(todo){
    $scope._rejectConfirmDialog().result.then(function(){
      //Yes
      todo.isReject = 'Y';
      $scope.updateTodoData(todo);

    },function(){
      //NO
    });
  }

}]);
