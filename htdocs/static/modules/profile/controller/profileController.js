'use strict';

angular.module('app').controller('ProfileController',
[       '$scope','$controller','blockUI','$http',
function($scope,  $controller,  blockUI,  $http) {

  $scope.moduleName = "access.profile";

  $scope.saveProfile = function(form){
    var user = $scope.getUser();
    console.log(user);

    if(user.password != user.confirmPassword){
      alert("The passwords are not matched.");
      return;
    }

    blockUI.start("Updating...");
    var url = "index.php/auth/changePassword/";

    user.csrf_test_name = csrf_value;
    var postData = $.param({email: user.email,password:user.password});
    $http({
        method: 'POST',
        url: url,
        data: postData,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(function(response){
      user.password="";
      user.confirmPassword="";
      
      $scope.setUser(user);
      form.$setPristine();
      blockUI.stop();
    },
    function(response){
      blockUI.stop();
    });
    /*
    $http.post(url,ion(data,status,headers,config){

      user.password="";
      user.confirmPassword="";
      
      $scope.setUser(user);

      form.$setPristine();

      blockUI.stop();
    }).error(function(data,status,headers,config) {
      //deferred.reject({data:data,status:status});
    });
    */
  }

}]);
