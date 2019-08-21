'use strict';

angular.module('app')
  .filter('codeValue',['codeService',function (codeService) {
    return function (input,category) {
      return codeService.getCodeName(category,input);
    };
  }]);
