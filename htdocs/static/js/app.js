'use strict';

define([
    'angular','ngAnimate','ngCookies','ngResource','ngSanitize','ngTouch','ngStorage',
    'uiRouter','uiBootstrap','uiLoad','uiJq','uiValidate',
    'ocLazyLoad',
    'loader-static-files',
    'storage-cookie',
    'storage-local',
    'ngTagsInput',
    'ngDialogs',
    'ngTranslate',
    'ngDialogsTranslation',
    'ngCurrency',
    'ngTable',
    'ngWizard',
    'uiSelect',
    'uiTree',
    'uiSortable',
    'ngJWT',
    'ngBlockUI',
    'textAngular',
    'angular-file-upload',
    'fancybox'

  ],function(angular){
    return angular.module('app', [
        'ngAnimate','ngCookies','ngResource','ngSanitize','ngTouch','ngStorage',
        'ui.router','ui.bootstrap','ui.load','ui.jq','ui.validate',
        'oc.lazyLoad',
        'ngTagsInput',
        'dialogs.main',
        'pascalprecht.translate',
        'dialogs.default-translations',
        'ng-currency',
        'ngTable',
        'mgo-angular-wizard',
        'ui.select',
        'ui.tree',
        'ui.sortable',
        'angular-jwt',
        'blockUI',
        'textAngular',
        'angularFileUpload',

    ]);
});
