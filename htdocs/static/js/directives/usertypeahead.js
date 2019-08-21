'use strict';

angular.module('app').directive('usertypeahead', function($timeout) {
  return {
    restrict: 'AEC',
    scope: {
      items: '=',
      prompt:'@',
      title: '@',
      subtitle:'@',
      model: '=',
      search: '=',
      onSelect:'&',
      onNewCustomer:'&'
    },
    templateUrl: 'TypeAheadTemplate.html',
    link:function(scope,elem,attrs){
      scope.handleSelection=function(selectedName,selectedItem){
        scope.model=selectedItem;
        scope.search=selectedName;
        scope.current=0;
        scope.selected=true;
        $timeout(function(){
          scope.onSelect({value:selectedItem});
        },200);
      };
      scope.addNewCustomer=function(){
        $timeout(function(){
          scope.onNewCustomer();
        },200);
      }
      scope.current=0;
      scope.selected=true;
      scope.isCurrent=function(index){
        return scope.current==index;
      };
      scope.setCurrent=function(index){
        scope.current=index;
      };
    }
  }
});
