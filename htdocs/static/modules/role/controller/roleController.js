'use strict';

angular.module('app').controller('RoleController',
    [       '$scope','$rootScope','$controller','$timeout','menuService','roleService','menuroleService',
    function($scope,  $rootScope,  $controller,  $timeout,  menuService,  roleService,  menuroleService) {

    $rootScope.listParams = null;
	$scope.moduleName = "app.system.role";
	console.log("RoleController");
	$controller('BaseController', { $scope: $scope });
    $controller('RoleDataHandlerController',{$scope:$scope});
    $controller('RoleTreeHandlerController',{$scope:$scope});
	


}]);
