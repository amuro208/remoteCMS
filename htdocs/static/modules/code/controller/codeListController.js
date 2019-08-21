'use strict';

angular.module('app').controller('CodeListController',
[       '$scope','$location','codeService','$controller','$q','$http',
function($scope,  $location,  codeService,  $controller,  $q,  $http) {
  
  $controller('BaseListController',{$scope:$scope});

  $scope.listData = [];
  $scope.listService = codeService;

  $scope.listTableOptions = {
    sorting: {
      category: 'asc',
      code:'asc'
    }
  };

  $scope.categories = function(column) {
       var def = $q.defer(),
           arr = [],
           names = [];
       codeService.promise.then(function(){
         var data = codeService.getAllDatas();
         angular.forEach(data, function(item){
             if (inArray(item.category, arr) === -1) {
                 arr.push(item.category);
                 names.push({
                      'id': item.category,
                     'title': item.category
                 });
             }
        });
        names.sort(titlecompare); 
        def.resolve(names);
      });
       
      return def;
  };

  $scope.csvDownload = function(){
    var url = 'index.php/codedata/data/format/csv';
    $http({method: 'GET', url: url}).
      success(function(data, status, headers, config) {
        var element = angular.element('<a/>');
        element.attr({
          href: 'data:attachment/csv;charset=utf-8,' + encodeURI(data),
          target: '_blank',
          download: 'Aging.csv'
        })[0].click();
      }).
      error(function(data, status, headers, config) {
        // if there's an error you should see it here
      });
  };

}]);
