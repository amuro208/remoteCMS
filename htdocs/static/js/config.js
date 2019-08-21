'use strict';

define(['app'], function(app){

  app.config(
      [        '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
      function ($controllerProvider,   $compileProvider,   $filterProvider,   $provide) {
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
        app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
        app.factory    = $provide.factory;
        app.service    = $provide.service;
        app.constant   = $provide.constant;
        app.value      = $provide.value;
      }
    ])
    .config(function Config($httpProvider, jwtInterceptorProvider) {
      jwtInterceptorProvider.tokenGetter = function() {
        return localStorage.getItem('id_token');
      };

      $httpProvider.interceptors.push('jwtInterceptor');
    })
    .config(function ($provide, $httpProvider) {

      // Intercept http calls.
      $provide.factory('MyHttpInterceptor', function ($q,$rootScope,$timeout,$location) {
        return {
          // On request success
          request: function (config) {
            /*
            console.log(config); // Contains the data about the request before it is sent.
            */

            // Return the config or wrap it in a promise if blank.
            return config || $q.when(config);
          },

          // On request failure
          requestError: function (rejection) {
            /*
            console.log(rejection); // Contains the data about the error on the request.
            */

            // Return the promise rejection.
            return $q.reject(rejection);
          },

          // On response success
          response: function (response) {
            /*
            console.log(response); // Contains the data from the response.
            */

            // Return the response or promise.
            return response || $q.when(response);
          },

          // On response failture
          responseError: function (rejection) {
            /*
            console.log("############################responseError#################################");
            console.log(rejection); // Contains the data about the error.
            console.log("##########################################################################");
            */

            if (rejection.status === 401) {
              $timeout(function(){
                $location.path("/access/401");
              },500);
            }

            if (rejection.status === 403) {
              $timeout(function(){
                $location.path("/access/403");
              },500);
            }

            if (rejection.status === 500) {
              $timeout(function(){
                $location.path("/access/500");
              },500);
            }

            // Return the promise rejection.
            return $q.reject(rejection);
          }
        };
      });

      // Add the interceptor to the $httpProvider.
      $httpProvider.interceptors.push('MyHttpInterceptor');

    })
    .config(['$translateProvider', function($translateProvider){

        // Register a loader for the static files
        // So, the module will search missing translation tables under the specified urls.
        // Those urls are [prefix][langKey][suffix].
        $translateProvider.useStaticFilesLoader({
          prefix: 'static/l10n/',
          suffix: '.js'+version
        });
        // Tell the module what language to use by default
        $translateProvider.preferredLanguage('en');
        // Tell the module to store the language in the local storage
        $translateProvider.useLocalStorage();
    }])
    .config(['dialogsProvider',function(dialogsProvider){
        dialogsProvider.useBackdrop('static');
    		dialogsProvider.useEscClose(false);
    		dialogsProvider.useCopy(false);
    		dialogsProvider.setSize('sm');
    }])
    .config(function(blockUIConfig) {
      blockUIConfig.message = 'Please wait';
      blockUIConfig.delay = 100;
      blockUIConfig.autoBlock = false;
      //blockUIConfig.template = '<pre><code>{{ state | json }}</code></pre>';
    })
    .config(['$provide', function($provide){
      // this demonstrates how to register a new tool and add it to the default toolbar
      $provide.decorator('taOptions', ['$delegate', function(taOptions){
        // $delegate is the taOptions we are decorating
        // here we override the default toolbars and classes specified in taOptions.
        taOptions.toolbar = [
        ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
        ['bold', 'italics', 'underline', 'ul', 'ol', 'redo', 'undo', 'clear'],
        ['justifyLeft','justifyCenter','justifyRight'],
        ['html', 'insertImage', 'insertLink', 'unlink']
        //['html', 'insertImage', 'insertLink']
        ];
        taOptions.classes = {
          focussed: 'focussed',
          toolbar: 'btn-toolbar',
          toolbarGroup: 'btn-group',
          toolbarButton: 'btn btn-default',
          toolbarButtonActive: 'active',
          disabled: 'disabled',
          textEditor: 'form-control',
          htmlEditor: 'form-control'
        };
        taOptions.disableStyle=true;
        return taOptions; // whatever you return will be the taOptions
      }]);

      /*
      // this demonstrates changing the classes of the icons for the tools for font-awesome v3.x
      $provide.decorator('taTools', ['$delegate', function(taTools){
        taTools.bold.iconclass = 'icon-bold';
        taTools.italics.iconclass = 'icon-italic';
        taTools.underline.iconclass = 'icon-underline';
        taTools.ul.iconclass = 'icon-list-ul';
        taTools.ol.iconclass = 'icon-list-ol';
        taTools.undo.iconclass = 'icon-undo';
        taTools.redo.iconclass = 'icon-repeat';
        taTools.justifyLeft.iconclass = 'icon-align-left';
        taTools.justifyRight.iconclass = 'icon-align-right';
        taTools.justifyCenter.iconclass = 'icon-align-center';
        taTools.clear.iconclass = 'icon-ban-circle';
        taTools.insertLink.iconclass = 'icon-link';
        //taTools.unlink.iconclass = 'icon-link red';
        taTools.insertImage.iconclass = 'icon-picture';
        // there is no quote icon in old font-awesome so we change to text as follows
        delete taTools.quote.iconclass;
        taTools.quote.buttontext = 'quote';
        return taTools;
      }]);
      */

    }])
    ;

    return app;

});
