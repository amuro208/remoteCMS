'use strict';

angular.module('app').controller('AuthController',[
        '$scope','$http','$log','$location','jwtHelper','blockUI',
function($scope,  $http,  $log,  $location,  jwtHelper,  blockUI){

  $scope.user.password = "";

  $scope.signin=function(){

    blockUI.start("Loading...");

    $http.post(
      "index.php/auth/signin/",
      $.param({
        email : $scope.user.email,
        password : $scope.user.password,
        csrf_test_name : csrf_value,
      }),
      {headers : {'Content-Type': 'application/x-www-form-urlencoded'}}
    ).success(function(data){
console.log("token : "+data.token);
console.log("authority : "+data.authority);
      localStorage.setItem("id_token",data.token);
      localStorage.setItem("user_authority",JSON.stringify(data.authority));

      $scope.user = jwtHelper.decodeToken(data.token);
      $scope.user.name = $scope.user.firstName+" "+$scope.user.lastName;

      $scope.userAuthority = data.authority;

      $location.path("/");

      blockUI.stop();
    }).error(function(msg){
      blockUI.stop();
      console.log(msg);
      alert(msg.error);
    });

  }

  $scope.releaseLock = function(){
    blockUI.start("Loading...");

    var user = jwtHelper.decodeToken(localStorage.getItem("lock_token"));
    $http.post(
      "index.php/auth/signin/",
      $.param({
        email : user.email,
        password : $scope.user.password,
        csrf_test_name : csrf_value,
      }),
      {headers : {'Content-Type': 'application/x-www-form-urlencoded'}}
    ).success(function(data){

      localStorage.setItem("id_token",data.token);
      $scope.user={};
      $location.path("/");
      blockUI.stop();
    }).error(function(msg){
      blockUI.stop();
      console.log(msg);
      alert(msg.error);
    });

  }

  $scope.checkDuplicateUser = function(){

  }

  $scope.signup=function(){

    console.log($scope.user);
    blockUI.start("Loading...");
    $http.post(
      "index.php/auth/signup/",
      $.param({
        firstName : $scope.user.firstName,
        lastName : $scope.user.lastName,
        email : $scope.user.email,
        password : $scope.user.password,
        csrf_test_name : csrf_value,
      }),
      {headers : {'Content-Type': 'application/x-www-form-urlencoded'}}
    ).success(function(data){
      console.log(data);
      $location.path("/");
      blockUI.stop();
    });

  }

  $scope.forgetPassword = function(){
    blockUI.start("Loading...");
    $http.post(
      "index.php/auth/forgetPassword/",
      $.param({
        email : $scope.user.email,
        csrf_test_name : csrf_value,
      }),
      {headers : {'Content-Type': 'application/x-www-form-urlencoded'}}
    ).success(function(data){
      console.log(data);
      $location.path("/");
      blockUI.stop();
    });
  }
}]);
