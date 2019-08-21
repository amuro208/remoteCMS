'use strict';

angular.module('app')
 .filter('optionValue', function () {
   return function (input,options) {
     if(options == null || options.length == undefined) return "";
     for(var i = 0; i < options.length ; i++){
       if(options[i].value == input){
         return options[i].text;
       }
     }
     return "";
   };
 });
