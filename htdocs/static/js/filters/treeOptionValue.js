
'use strict';

angular.module('app')
 .filter('treeOptionValue', function () {
   return function (input,options) {
     for(var i = 0; i < options.length ; i++){
       if(options[i].value == input && options[i].step == "1"){
         return options[i].text;
       }

       if(options[i].value == input && options[i].step == "2"){
         return " - " + options[i].text;
       }
     }
     return "";
   };
 });
