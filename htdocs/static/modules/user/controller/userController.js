'use strict';

angular.module('app').controller('UserController',
    [       '$scope','$rootScope','userService','$controller','FileUploader',
    function($scope,  $rootScope,  userService,  $controller,  FileUploader) {

    $rootScope.listParams = null;
    $scope.moduleName = "app.user.event";

    $controller('UserDataHandlerController',{$scope:$scope});

    $scope.deleteUserFile = function(fileid){
      $scope.disabledEventPropagation(window.event);
      $scope._deleteConfirmDialog().result.then(function(btn){
        var url = "index.php/userfileupload/upload/"+fileid;
        userService._http_delete(url).then(function(data){
          if(data.status == "success"){
            $scope.viewData(data.user);
          }
        });
      });
    }

    $scope.onClickApproved2 = function(data){
      if(data.isApproved == true)
        data.isApproved = "Y";
      else
        data.isApproved = "N";
      userService.updateData(data).then(function(data){
        if(data.isApproved == "Y"){
          var sendEmailUrl = "index.php/sendemail/standard/"+data.id;
          userService._http_get(sendEmailUrl).then(function(data){

          });
        }
      });
    };

    $scope.onClickSentEmail2 = function(data){
      if(data.isSentEmail == true && data.isSentEmail != "N")
        data.isSentEmail = "Y";
      else
        data.isSentEmail = "N";
      userService.updateData(data);
    };

    $scope.onClickResendEmail = function(data){
      var sendEmailUrl = "index.php/sendemail/standard/"+data.id;
      userService._http_get(sendEmailUrl).then(function(data){   
      });
    };

}]);
