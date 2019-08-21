'use strict';

angular.module('app').controller('MainController',
[       '$scope','$compile','$http','$location','$log',
        '$controller','$translate','dialogs','customerService',
function($scope,  $compile,  $http,  $location,  $log,
         $controller,  $translate,  dialogs,  customerService) {

  $('.sortable').sortable();

  $scope.done = function(){
    var dlg = dialogs.confirm(
                  $translate.instant('DIALOGS_CONFIRMATION'),
                  $translate.instant('DIALOGS_CONFIRMATION_DONE'));
    dlg.result.then(function(btn){
        //$scope.doDelete(entity);
    },function(btn){
        //$scope.confirmed = 'You confirmed "No."';
    });
  };

  $scope.cancel = function(){
    var dlg = dialogs.confirm(
                  $translate.instant('DIALOGS_CONFIRMATION'),
                  $translate.instant('DIALOGS_CONFIRMATION_CANCEL'));
    dlg.result.then(function(btn){
        //$scope.doDelete(entity);
    },function(btn){
        //$scope.confirmed = 'You confirmed "No."';
    });
  };

  customerService.promise.then(function(){
    $scope.customerTypeAHeadData = customerService.getTypeAHeadData();
  });

}]);
