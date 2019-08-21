'use strict';

define(['app','config','config.lazyload'],function(app){
  /**
  * Config for the router
  */
  //angular.module('app')

  app.run(
    [          '$rootScope', '$state', '$stateParams',
      function ($rootScope,   $state,   $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }
    ]
  )
  .config(
    [          '$stateProvider', '$urlRouterProvider',
      function ($stateProvider,   $urlRouterProvider) {

          $urlRouterProvider
              .otherwise('/app/main');
          $stateProvider
              .state('app', {
                  abstract: true,
                  url: '/app',
                  templateUrl: 'static/tpl/app.html'+version,
                  controller: 'AppCtrl',
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/code/service/codeService.js'+version,
                             'static/modules/systemoption/service/systemoptionService.js'+version,
                             'static/js/directives/validDate.js'+version,
                          ]);
                      }]
                  }
              })

              .state('app.main', {
                  url: '/main',
                  template: '<div ui-view></div>',
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/css/board.css'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
              // Profile
              ////////////////////////////////////////////////////////////////////////////
              .state('app.profile', {
                  url: '/profile',
                  templateUrl: 'static/modules/profile/profile.html',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/modules/profile/controller/profileController.js'+version,
                        'static/css/custom.css'+version,
                      ]);
                    }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
              // System
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system',{
                  url: '/system',
                  template: '<div ui-view></div>',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                      ]);
                    }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
              // System - Code
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system.code',{
                  url: '/code',
                  controller:'CodeController',
                  template:'<div class=""><div ui-view class="fade-in-down"></div></div>',
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/code/service/codeService.js'+version,
                             'static/modules/code/controller/codeDataHandlerController.js'+version,
                             'static/modules/code/controller/codeController.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
              .state('app.system.code.list',{
                  url: '/list',
                  templateUrl: 'static/modules/code/code_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/modules/code/controller/codeListController.js'+version,
                      ]);
                    }]
                  }
              })
              .state('app.system.code.detail',{
                  url: '/detail',
                  templateUrl: 'static/modules/code/code_detail.html'+version,
              })


              ////////////////////////////////////////////////////////////////////////////
              // System - Menu
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system.menu',{
                  url: '/menu',
                  templateUrl: 'static/modules/menu/system_menu.html'+version,
                  resolve: {
                      deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                              'static/modules/menu/service/menuService.js'+version,
                              'static/modules/menu/controller/menuDataHandlerController.js'+version,
                              'static/modules/menu/controller/menuController.js'+version,
                              'static/css/custom.css'+version,
                          ]);
                      }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
              // System - Role
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system.role',{
                  url: '/role',
                  controller: 'RoleController',
                  template:'<div class=""><div ui-view class="fade-in-down"></div></div>',
                  resolve: {
                      deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                              'static/modules/menu/service/menuService.js'+version,
                              'static/modules/role/service/roleService.js'+version,
                              'static/modules/role/service/menuroleService.js'+version,

                              'static/modules/role/controller/roleDataHandlerController.js'+version,
                              'static/modules/role/controller/roleTreeHandlerController.js'+version,
                              'static/modules/role/controller/roleController.js'+version,

                              'static/css/custom.css'+version,
                          ]);
                      }]
                  }
              })
              .state('app.system.role.list',{
                  url: '/list',
                  templateUrl: 'static/modules/role/role_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/modules/role/controller/roleListController.js'+version,
                      ]);
                    }]
                  }
              })
              .state('app.system.role.detail',{
                  url: '/detail',
                  templateUrl: 'static/modules/role/role_detail.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/js/directives/treeGrid.js'+version,
                        'static/vendor/angular/angular-bootstrap-grid-tree/treeGrid.css'+version,
                        'static/css/custom.css'+version,
                      ]);
                    }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
               // SystemUser
               ////////////////////////////////////////////////////////////////////////////
               .state('app.system.user',{
                   url: '/user',
                   template:'<div class=""><div ui-view class="fade-in-down"></div></div>',
                   resolve: {
                       deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                           return $ocLazyLoad.load([

                               'static/modules/systemuser/service/systemuserService.js'+version,
                               'static/modules/role/service/roleService.js'+version,
                               'static/modules/systemuser/service/systemuserroleService.js'+version,

                               'static/vendor/modules/ng-tags-input/ng-tags-input.css'+version,
                               'static/js/directives/treeGrid.js'+version,
                               'static/vendor/angular/angular-bootstrap-grid-tree/treeGrid.css'+version,

                               'static/modules/systemuser/controller/systemuserController.js'+version,
                               'static/modules/systemuser/controller/systemUserRolePanelController.js'+version,

                               'static/css/custom.css'+version,
                           ]);
                       }]
                   }
               })
               .state('app.system.user.list',{
                   url: '/list',
                   templateUrl: 'static/modules/systemuser/systemuser.html'+version,
                   resolve: {
                     deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                       return $ocLazyLoad.load([
                       ]);
                     }]
                   }
               })

              ////////////////////////////////////////////////////////////////////////////
              // System - Setting
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system.systemoption',{
                  url: '/systemoption',
                  controller:'SystemOptionController',
                  template:'<div class=""><div ui-view class="fade-in-down"></div></div>',
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/systemoption/service/systemoptionService.js'+version,
                             'static/modules/systemoption/controller/systemoptionDataHandlerController.js'+version,
                             'static/modules/systemoption/controller/systemoptionController.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
              .state('app.system.systemoption.list',{
                  url: '/list',
                  templateUrl: 'static/modules/systemoption/systemoption_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/modules/systemoption/controller/systemoptionListController.js'+version,
                      ]);
                    }]
                  }
              })
              .state('app.system.systemoption.detail',{
                  url: '/detail',
                  templateUrl: 'static/modules/systemoption/systemoption_detail.html'+version,
              })

              ////////////////////////////////////////////////////////////////////////////
              // System - Project
              ////////////////////////////////////////////////////////////////////////////
              .state('app.system.event',{
                  url: '/event',
                  controller:'EventController',
                  template:'<div class=""><div ui-view class="fade-in-down"></div></div>',
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/event/service/eventService.js'+version,
                             'static/modules/event/controller/eventDataHandlerController.js'+version,
                             'static/modules/event/controller/eventController.js'+version,
                             'static/js/filters/codeValue.js'+version,
                             'static/js/filters/optionValue.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
              .state('app.system.event.list',{
                  url: '/list',
                  templateUrl: 'static/modules/event/event_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                        'static/modules/event/controller/eventListController.js'+version,
                      ]);
                    }]
                  }
              })
              .state('app.system.event.detail',{
                  url: '/detail',
                  templateUrl: 'static/modules/event/event_detail.html'+version,
              })


              ////////////////////////////////////////////////////////////////////////////
              // LocalUser
              ////////////////////////////////////////////////////////////////////////////
              .state('app.localuser',{
                  url: '/localuser',
                  controller:'LocalUserController',
                  template: '<div ui-view></div>',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/localuser/service/localuserService.js'+version,
                         'static/modules/localuser/controller/localuserController.js'+version,
                         'static/modules/localuser/controller/localuserDataHandlerController.js'+version,
                      ]);
                    }]
                  }
              })

              .state('app.localuser.total',{
                  url: '/total/:maderation',
                  templateUrl: 'static/modules/localuser/localuser_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/localuser/controller/localuserListController.js'+version,
                         'static/js/directives/fancybox.js'+version,
                         'static/css/custom.css'+version,
                      ]);
                    }]
                  },
              })
              ////////////////////////////////////////////////////////////////////////////
              // LocalRfidScan
              ////////////////////////////////////////////////////////////////////////////
              .state('app.localrfidscan',{
                  url: '/localrfidscan',
                  controller:'LocalRfidScanController',
                  template: '<div ui-view></div>',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/localrfidscan/service/localrfidscanService.js'+version,
                         'static/modules/localrfidscan/controller/localrfidscanController.js'+version,
                         'static/modules/localrfidscan/controller/localrfidscanDataHandlerController.js'+version,
                      ]);
                    }]
                  }
              })

              .state('app.localrfidscan.list',{
                  url: '/list',
                  templateUrl: 'static/modules/localrfidscan/localrfidscan_list.html'+version,
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/localrfidscan/controller/localrfidscanListController.js'+version,
                         'static/js/directives/fancybox.js'+version,
                         'static/css/custom.css'+version,
                      ]);
                    }]
                  },
              })

              ////////////////////////////////////////////////////////////////////////////
              // User
              ////////////////////////////////////////////////////////////////////////////
              .state('app.statistic',{
                  url: '/statistic/project/:project',
                  templateUrl: 'static/modules/statistic/statistic_list.html'+version,
                  controller: 'StatisticController',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/statistic/controller/statisticListController.js'+version,
                         'static/modules/statistic/controller/statisticController.js'+version,
                         'static/modules/statistic/service/statisticService.js'+version,
                         'static/css/custom.css'+version,
                      ]);
                    }]
                  }
              })

              ////////////////////////////////////////////////////////////////////////////
              // User
              ////////////////////////////////////////////////////////////////////////////
              .state('app.user',{
                  url: '/user',
                  template: '<div ui-view></div>',
                  controller: 'UserController',
                  resolve: {
                    deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                      return $ocLazyLoad.load([
                         'static/modules/user/controller/userDataHandlerController.js'+version,
                         'static/modules/user/controller/userController.js'+version,
                         'static/modules/user/service/userService.js'+version,
                         'static/js/directives/fancybox.js'+version,
                      ]);
                    }]
                  }
              })

/*
              .state('app.user.total',{
                  url: '/total',
                  templateUrl: 'static/modules/user/user_list.html'+version,
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/user/controller/userListController.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
i*/
              .state('app.user.event',{
                  url: '/project/:project/event/:event',
                  templateUrl: 'static/modules/user/user_list.html'+version,
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/user/service/userEventService.js'+version,
                             'static/modules/user/controller/userEventListController.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
              .state('app.user.detail',{
                  url: '/detail',
                  templateUrl: 'static/modules/user/user_detail.html'+version,
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/user/controller/userFileUploaderController.js'+version,
                          ]);
                      }]
                  },
              })

              .state('app.user.lk',{
                  url: '/lk',
                  templateUrl: 'static/modules/user_lk/user_list.html'+version,
                  resolve: {
                      deps: ['$ocLazyLoad', function( $ocLazyLoad ){
                          return $ocLazyLoad.load([
                             'static/modules/user/service/userEventService.js'+version,
                             'static/modules/user/controller/userEventListController.js'+version,
                             'static/css/custom.css'+version,
                          ]);
                      }]
                  },
              })
              ////////////////////////////////////////////////////////////////////////////

              .state('app.docs', {
                  url: '/docs',
                  templateUrl: 'static/tpl/docs.html'
              })
              // others
              .state('lockme', {
                  url: '/lockme',
                  templateUrl: 'static/tpl/page_lockme.html',
                  resolve: {
                    deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                      return $ocLazyLoad.load(
                        [
                          'static/modules/systemuser/service/systemuserService.js'+version,
                          'static/modules/auth/auth.js'+version,
                          'static/css/custom.css'+version,
                        ]);
                      }]
                    }
              })
              .state('access', {
                  url: '/access',
                  template: '<div ui-view class="fade-in-down"></div>'
              })
              .state('access.signin', {
                  url: '/signin',
                  templateUrl: 'static/tpl/page_signin.html',
                  resolve: {
                      deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                          return $ocLazyLoad.load(
                              [
                              	'static/modules/systemuser/service/systemuserService.js'+version,
                                'static/modules/auth/auth.js'+version,
                                'static/css/custom.css'+version,
                              ]);
                      }]
                  }
              })
              .state('access.signup', {
                  url: '/signup',
                  templateUrl: 'static/tpl/page_signup.html',
                  resolve: {
                      deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                          return $ocLazyLoad.load(
                              [
                                'static/modules/systemuser/service/systemuserService.js'+version,
                                'static/modules/auth/auth.js'+version,
                                'static/css/custom.css'+version,
                              ]);
                      }]
                  }
              })
              .state('access.forgotpwd', {
                  url: '/forgotpwd',
                  templateUrl: 'static/tpl/page_forgotpwd.html',
                  resolve: {
                      deps: ['$ocLazyLoad',function( $ocLazyLoad ){
                          return $ocLazyLoad.load(
                              [
                                'static/modules/systemuser/service/systemuserService.js'+version,
                                'static/modules/auth/auth.js'+version,
                                'static/css/custom.css'+version,
                              ]);
                      }]
                  }
              })
              .state('access.401', {
                  url: '/401',
                  templateUrl: 'static/tpl/page_401.html'
              })
              .state('access.403', {
                  url: '/403',
                  templateUrl: 'static/tpl/page_403.html'
              })
              .state('access.404', {
                  url: '/404',
                  templateUrl: 'static/tpl/page_404.html'
              })
              .state('access.500', {
                  url: '/500',
                  templateUrl: 'static/tpl/page_500.html'
              })

              /*
              .state('app.dashboard-v2', {
                  url: '/dashboard-v2',
                  templateUrl: 'static/tpl/app_dashboard_v2.html',
                  resolve: {
                    deps: ['$ocLazyLoad',
                      function( $ocLazyLoad ){
                        return $ocLazyLoad.load(['static/js/controllers/chart.js']);
                    }]
                  }
              })
              */
      }
    ]
  );

});
