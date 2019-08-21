'use strict';

angular.module('app').controller('MenuDataHandlerController',
[       '$scope','$log','$controller','menuService','$translate','dialogs',
function($scope,  $log,  $controller,  menuService,  $translate,  dialogs) {
  $controller('BaseController', { $scope: $scope });
  $scope.basicService = menuService;

  $scope._postCreateData = function(){
    $scope.showMenuPanel = true;
  }

  $scope._postModifyData = function(data){
    $scope.showMenuPanel = true;
  }

  $scope.createSubData = function(scope){
    $scope.modifiedData = {};
    $scope.showMenuPanel = true;
    $scope.modifiedData.pid = scope.$modelValue.id;
    $scope.mode = "create";
  }
  
  $scope.showMenuPanel = false;

  $scope.cancelMenu = function(){
    $scope.showMenuPanel = false;
  };
}]);
