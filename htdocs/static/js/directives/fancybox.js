'use strict';

angular.module('app').directive('fancybox', function ($compile, $http) {
    return {
        restrict: 'A',

        controller: function($scope) {
            $scope.openVideoFancybox = function(url){
                console.log(url);
                $http.get(url).then(function(response) {
                    if (response.status == 200) {

                        //var template = angular.element(response.data);
                        //var compiledTemplate = $compile(template);
                        //compiledTemplate($scope);

                        $.fancybox.open({ content: response.data, type: 'html' });
                    }
                });
            }
            $scope.openImageFancybox = function(url){
                $.fancybox.open(
                  { href: url},
                  { padding : 10});              
            };
        }

    };
});
