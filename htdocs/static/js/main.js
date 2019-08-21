'use strict';

var D = true;

require.config({
  baseUrl: 'static/js',
  urlArgs: version.replace("?",""),
  paths:{

    'jquery':'../vendor/jquery/jquery.min',
    'fancybox' : '../vendor/modules/fancybox/fancybox.min',

    'jqueryui':'../vendor/jquery/jquery-ui-1.10.3.custom.min',
    'underScore':'../vendor/modules/underscore/underscore-min',
    'angular':'../vendor/angular/angular.min',

    'ngAnimate':'../vendor/angular/angular-animate/angular-animate.min',
    'ngCookies':'../vendor/angular/angular-cookies/angular-cookies.min',
    'ngResource':'../vendor/angular/angular-resource/angular-resource.min',
    'ngSanitize':'../vendor/angular/angular-sanitize/angular-sanitize.min',
    'ngTouch':'../vendor/angular/angular-touch/angular-touch.min',

    'ngStorage':'../vendor/angular/ngstorage/ngStorage.min',
    'ngDialogs':'../vendor/angular/angular-dialog/dialogs.min',
    'ngDialogsTranslation':'../vendor/angular/angular-dialog/dialogs-default-translations.min',

    'ngTranslate':'../vendor/angular/angular-translate/angular-translate',
    'loader-static-files':'../vendor/angular/angular-translate/loader-static-files',
    'storage-cookie':'../vendor/angular/angular-translate/storage-cookie',
    'storage-local':'../vendor/angular/angular-translate/storage-local',

    'uiBootstrap':'../vendor/angular/angular-bootstrap/ui-bootstrap-tpls-0.11.2.min',
    'ocLazyLoad':'../vendor/angular/oclazyload/ocLazyLoad.min',

    'uiRouter':'../vendor/angular/angular-ui-router/angular-ui-router.min',
    'uiJq': 'directives/ui-jq',
    'uiFocus': 'directives/ui-focus',
    'uiFullscreen': 'directives/ui-fullscreen',
    'uiModule': 'directives/ui-module',
    'uiNav': 'directives/ui-nav',
    'uiScroll': 'directives/ui-scroll',
    'uiShift': 'directives/ui-shift',
    'uiToggleclass': 'directives/ui-toggleclass',
    'uiValidate': 'directives/ui-validate',
    'uiDatepickerLocaldate' : 'directives/datepickerLocaldate',
    'eatClickIf' : 'directives/eatClickIf',

    //'uiSortable' : '../vendor/modules/uiSortable/uiSortable',
    'uiSortable' : '../vendor/modules/ng-sortable/ng-sortable',

    'uiLoad': 'services/ui-load',
    'systemctrl': 'controllers/system',

    //****************************************************************************
    'AppBase': '../modules/base/controller/base',
    'AppServiceBase': '../modules/base/service/servicebase',
    'AppListControllerBase':'../modules/base/controller/listcontrollerbase',
    //****************************************************************************

    'ngTagsInput':'../vendor/modules/ng-tags-input/ng-tags-input',
    'ngJWT':'../vendor/modules/angular-jwt/angular-jwt.min',
    'ngCurrency':'../vendor/modules/ng-currency/ng-currency.min',
    'ngTable':'../vendor/modules/ng-table/ng-table',
    'ngWizard':'../vendor/modules/ng-wizard/angular-wizard.min',
    'uiSelect':'../vendor/modules/angular-ui-select/select.min',
    'uiTree':'../vendor/angular/angular-ui-tree/angular-ui-tree.min',
    'ngBlockUI':'../vendor/modules/angular-block-ui/angular-block-ui.min',

    'textAngularRangy':'../vendor/modules/textAngular/textAngular-rangy.min',
    'textAngularSanitize':'../vendor/modules/textAngular/textAngular-sanitize.min',
    'textAngular':'../vendor/modules/textAngular/textAngular.min',

    'angular-file-upload':'../vendor/modules/angular-file-upload/angular-file-upload',

  },
  shim:{
    'angular':{
      deps:['jquery'],
      exports:'angular'
    },
    'jqueryui':{
      deps:['jquery'],
    },
    'fancybox':{
      deps:['jquery'],
    },
    'ngTagsInput':{
      deps:['angular']
    },
    'ngAnimate':{
      deps:['angular']
    },
    'ngCookies':{
      deps:['angular']
    },
    'ngResource':{
      deps:['angular']
    },
    'ngSanitize':{
      deps:['angular']
    },
    'ngTouch':{
      deps:['angular']
    },
    'uiRouter':{
      deps:['angular']
    },
    'uiLoad':{
      deps:['angular']
    },
    'uiJq':{
      deps:['angular']
    },
    'uiValidate':{
      deps:['angular']
    },
    'ngStorage':{
      deps:['angular']
    },
    'uiBootstrap':{
      deps:['angular']
    },
    'ngTranslate':{
      deps:['angular']
    },
    'loader-static-files':{
      deps:['ngTranslate']
    },
    'storage-cookie':{
      deps:['ngTranslate']
    },
    'storage-local':{
      deps:['ngTranslate']
    },
    'ocLazyLoad':{
      deps:['angular']
    },
    'uiNav':{
      deps:['angular','app']
    },
    'uiFullscreen':{
      deps:['angular','app']
    },
    'uiToggleclass':{
      deps:['angular','app']
    },
    'ngDialogs':{
      deps:['angular']
    },
    'ngCurrency':{
      deps:['angular']
    },
    'ngTable':{
      deps:['angular']
    },
    'ngJWT':{
      deps:['angular']
    },
    'ngWizard':{
      deps:['angular','underScore']
    },
    'uiSelect':{
      deps:['angular']
    },
    'uiSortable':{
      deps:['angular','jquery','jqueryui']
    },
    'uiSortable2':{
      deps:['angular']
    },
    'uiTree':{
      deps:['angular']
    },
    'ngBlockUI':{
      deps:['angular']
    },
    'uiDatepickerLocaldate':{
      deps:['angular']
    },
    'eatClickIf':{
      deps:['angular','app']
    },
    'ngDialogsTranslation':{
      deps:['angular','ngDialogs','ngTranslate']
    },
    'textAngular':{
      deps:['angular','textAngularRangy','ngSanitize']
    },

    'angular-file-upload':{
      deps:['angular']
    },

  }
});

require( ['angular',
          'app',
          'config.lazyload',
          'config.router',
          'appctrl',
          'uiFullscreen',
          'uiToggleclass',
          'uiNav',
          'AppBase',
          'AppServiceBase',
          'AppListControllerBase',
          'eatClickIf'
          ],
  function (app) {
      angular.element(document).ready(function () {
    		angular.bootstrap(document, ['app']);
    	});
  }
);
