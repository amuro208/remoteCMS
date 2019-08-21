'use strict';

angular.module('app').controller('MainController',
[       '$scope','$compile','$http',
function($scope,  $compile,  $http) {

  $scope.todoPanelSize = 6;
  $scope.memoPanelSize = 6;

  if($scope.checkCreatableAuthority("app.main")){
    $scope.todoPanelSize = 8;
    $scope.memoPanelSize = 4;
  }

}]);
