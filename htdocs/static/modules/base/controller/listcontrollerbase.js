'use strict';

define(['angular','app','config.lazyload','config.router'],function(angular,app){

  app.controller('BaseNewListController',
  [         '$scope','$rootScope','$location','$log','$filter','ngTableParams',
    function($scope,  $rootScope,  $location,  $log,  $filter,  ngTableParams){

      $scope.listData = [];
      $scope.listService = null;
      $scope.removePager = false;

      $scope.createTableParams = function(options,listdata){
        var defaultOptions = {
          page: 1,            // show first page
          count: $scope.app.settings.defaultPageSize,   // count per page
          sorting: {
            id: 'desc',  // initial sorting,
          }
        };

        if($rootScope.listParams != null){
          defaultOptions = $rootScope.listParams;
          options.sorting = $rootScope.listParams.sorting;
        }

        var tableOptions = angular.extend({},defaultOptions,options);
        var pages = $scope.pages;
        if($scope.removePager){
          pages = [];
        }

        return new ngTableParams(tableOptions, {
          debugMode: false,
          total : $scope.listData.length, // length of data
          counts : pages,
          getData : function($defer, params) {

            $rootScope.listParams = angular.copy(params.$params);

            if($scope.listService.isPageMode()){
              $scope.listService.listData(false,$rootScope.listParams).then(function(result){
                //result.code
                //result.message
                //result.total
                //result.page
                //result.pageSize
                //result.data
                if(result.code == "OK"){
                  params.total(result.total);
                  $defer.resolve(result.data);
                }else{
                  $defer.reject(result.message);
                }

              });
            }else{
              var filteredData = params.filter() ?
                                  $filter('filter')($scope.listData, params.filter()) :
                                  $scope.listData;

              var orderedData = params.sorting() ?
                                  $filter('orderBy')(filteredData, params.orderBy()) :
                                  filteredData;

              params.total(orderedData.length); // set total for recalc pagination

              $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
          }
        });
      }
    }
  ]);

  app.controller('BaseListController',
  [         '$scope','$location','$controller','$log','$filter',
    function($scope,  $location,  $controller,  $log,  $filter){

      $controller('BaseNewListController',{$scope:$scope});
      $scope.listService = null;
      $scope.listTableOptions = null;

      $scope.$watch('listTableOptions',function(options){
        if($scope.listService.D) $log.info("BaseListController.$watch - listTableOptions");

        if(options == null){
          $log.error("listTableOptions is empty.");
          return;
        }

        $scope.listTableParams = $scope.createTableParams(options,$scope.listData);

        if($scope.listService.promise != null){
          $scope.listService.promise.then(function(){
            if($scope.listService.isPageMode()){
              $scope.reloadListByPage($scope.listService.getAllDatasByPage());
            }else{
              $scope.reloadListByAll($scope.listService.getAllDatas());
            }
          });
        }else{
          if($scope.listService.isPageMode()){

          }
        }

        $scope.$on('reloadData', function(event, args) {
          if($scope.listService.isPageMode()){
            $scope.reloadListByPage($scope.listService.getAllDatasByPage());
          }else{
            $scope.reloadListByAll($scope.listService.getAllDatas());
          }
        });
      });

      $scope.lastData = null;
      $scope.selectData = function(data) {
        /*
        if($scope.listService.D) $log.info("BaseListController.selectData");
        if($scope.lastData) {
          $scope.lastData.selected = false;
        }
        data.selected = true;
        $scope.lastData = null;
        $scope.lastData = data;
        */
      };

      $scope.reloadList = function(listdata){
        $scope.reloadListByAll(listdata);
      }

      $scope.reloadListByAll = function(listdata){
        if($scope.listService.D) $log.info("BaseListController.reloadListByAll");
        if(listdata == null) return;
        $scope.listData = listdata;
        $scope.listTableParams.reload();
        $scope.listTableParams.total($scope.listData.length);
      };

      $scope.reloadListByPage = function(result){
        if($scope.listService.D) $log.info("BaseListController.reloadListByPage");
        if(result == null) return;
        $scope.listData = result.data;
        $scope.listTableParams.reload();
        $scope.listTableParams.total(result.total);
      };

      $scope.$on("unauthenticated",function(){
        $location.path("/access/401");
      });
  }]);

});
