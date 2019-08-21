'use strict';

angular.module('app')
  .filter('customerValue',['customerService',function (customerService) {
    return function (input) {
      /*
      if(input != null && input != undefined){
        if(input instanceof String){
            var data = customerService.getDataById(input);
            if(data != null){
              return data.name1+" "+data.name2+" "+data.name3;
            }
        }
        return "";
      }
      */
      
      return "";
    };
  }]);
