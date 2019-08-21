'use strict';

define(['app','config','config.lazyload','config.router'],function(app){

  //Cear Cache Every Time.
  //app.run(['$templateCache', function ( $templateCache ) {
  //  $templateCache.removeAll(); }]);

  app.controller('AppCtrl',
  [          '$scope', '$translate','$filter','$localStorage','$window','$rootScope','$location','jwtHelper','$http',
    function( $scope,   $translate,  $filter,  $localStorage,  $window,  $rootScope,  $location,  jwtHelper,  $http) {

      $scope.D = false;
      $scope.userAuthority = null;
      $scope.environment = "development"; //production.

      //the variable related to DATE....
      $scope.minDate="1950-01-01";
      $scope.maxDate="2020-12-31";
      //$scope.dateFormat="yyyy-MM-dd";
      $scope.dateFormat="dd/MM/yyyy";
      $scope.datePlaceHolder="DD/MM/YYYY";
      $scope.today = $filter('date')(new Date(), 'yyyy-MM-dd');

      $scope.stylesheets = [
        'static/css/animate.css'+version,
        'static/css/font-awesome.min.css'+version,
        //'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        'static/css/simple-line-icons.css'+version,
        'static/css/font.css'+version,
        'static/css/app.css'+version,
        'static/css//selectize.default.css'+version,
        'static/vendor/modules/ng-table/ng-table.min.css'+version,
        'static/vendor/modules/ng-wizard/angular-wizard.min.css'+version,
        'static/vendor/modules/angular-ui-select/select.min.css'+version,
        'static/vendor/angular/angular-ui-tree/angular-ui-tree.min.css'+version,
        'static/vendor/modules/fancybox/fancybox.min.css'+version,
        ];

      // add 'ie' classes to html
      var isIE = !!navigator.userAgent.match(/MSIE/i);
      isIE && angular.element($window.document.body).addClass('ie');
      isSmartDevice( $window ) && angular.element($window.document.body).addClass('smart');

      //$scope.user = {name:"Hoyoul Youn"};

      $scope.pages = [10, 15, 20, 30, 50];

      //Wizard
      $scope.wizard = false;
      $scope.showWizard = function(){
        $scope.wizard = true;
      }

      $scope.finishedWizard = function(){
        $scope.wizard = false;
      }

      // config
      $scope.app = {
        name: 'CMS',
        version: '1.0.0',
        buildNo: '1',
        localServer: false,
        remoteServer: false,
        // for chart colors
        color: {
          primary: '#7266ba',
          info:    '#23b7e5',
          success: '#27c24c',
          warning: '#fad733',
          danger:  '#f05050',
          light:   '#e8eff0',
          dark:    '#3a3f51',
          black:   '#1c2b36'
        },
        isSettingOpened : false,
        settings: {
          themeID: 1,
          defaultPageSize:10,
          navbarHeaderColor: 'bg-black',
          navbarCollapseColor: 'bg-white-only',
          asideColor: 'bg-black',
          headerFixed: true,
          asideFixed: false,
          asideFolded: false,
          asideDock: false,
          container: false,
          compact: false,
        }
      }

      $http.get('/framework/index.php/systemoptiondata/initoptions/').then(function(response){
        if(response.status == 200){
          if(response.data.is_local_server == 'Y'){
             $scope.app.localServer = true;
          }else{
             $scope.app.remoteServer = true;
          }
          if(response.data.cms_version != undefined && response.data.cms_version != false){
            version = response.data.cms_version;
            $scope.app.version = response.data.cms_version;
          }
          if(response.data.cms_name != undefined && response.data.cms_name != false){
            $scope.app.name = response.data.cms_name;
          }
          if(response.data.environment != undefined && response.data.environment != false){
            environment = response.data.environment;
          }
          if(response.data.csrf_hash != undefined && response.data.csrf_hash != false){
            csrf_value = response.data.csrf_hash;
          }

        }
      },function(err){
      });

      // save settings to local storage
      if ( angular.isDefined($localStorage.settings) ) {
        $scope.app.settings = $localStorage.settings;
        if($scope.app.settings.defaultPageSize == null ||
           $scope.app.settings.defaultPageSize == undefined ||
           $scope.app.settings.defaultPageSize == ""){
          $scope.app.settings.defaultPageSize = 10;
        }
        $localStorage.settings = $scope.app.settings;
      } else {
        $localStorage.settings = $scope.app.settings;
      }

      $scope.$watch('app.settings', function(){
        if( $scope.app.settings.asideDock  &&  $scope.app.settings.asideFixed ){
          // aside dock and fixed must set the header fixed.
          $scope.app.settings.headerFixed = true;
        }
        // save to local storage
        $localStorage.settings = $scope.app.settings;
      }, true);

      // angular translate
      $scope.lang = { isopen: false };
      $scope.langs = {ko:'한국어', en:'English', cn:'中國語'};
      $scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "English";
      $scope.setLang = function(langKey, $event) {
        // set the current lang
        $scope.selectLang = $scope.langs[langKey];
        // You can change the language during runtime
        $translate.use(langKey);
        $scope.lang.isopen = !$scope.lang.isopen;
      };

      function isSmartDevice( $window )
      {
          // Adapted from http://www.detectmobilebrowsers.com
          var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
          // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
          return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
      }

      $scope.user = {};
      $scope.getUser = function(){return $scope.user;};
      $scope.setUser = function(user){$scope.user = user;};
      var token = localStorage.getItem("id_token");
      if(token != null && token != "" && token != "undefined"){
        $scope.user = jwtHelper.decodeToken(token);
        $scope.user.name = $scope.user.firstName+" "+$scope.user.lastName;
      }

      $scope.lockScreen = function(){
        var token = localStorage.getItem("id_token");
        if(token != null && token != "" && token != "undefined"){
          $scope.user = jwtHelper.decodeToken(token);
          $scope.user.name = $scope.user.firstName+" "+$scope.user.lastName;
        }

        localStorage.setItem("lock_token",localStorage.getItem("id_token"));
        localStorage.setItem("id_token","");

        $location.path("/lockme");
      }

      $scope.toggleSetting = function(){
        $scope.app.isSettingOpened = $scope.app.isSettingOpened ? false : true ;
      }

      $scope.signout=function(){
        localStorage.setItem("id_token","");
        $location.path("access/signin");
      }

      //Checking Authorization...
      $scope.checkAuth = function(){
        if(localStorage.getItem("id_token") != null && localStorage.getItem("id_token") != ""){
          return true;
        }
        return false;
      }

      if(!$scope.checkAuth()){
        $location.path("/access/signin");
        return;
      }


      /////////////////////////////////////////////////////////////////////////////////////
      //version comes from "main.js"
      /////////////////////////////////////////////////////////////////////////////////////
      $scope.version = version;
      $scope.versionUrl= function(url){
        return url+$scope.version;
      };
      /////////////////////////////////////////////////////////////////////////////////////

      //If there is no authoritiy, hide from menu.
      $scope.cacheAuthority = [];
      $scope.checkAuthority = function(stateName){
        //console.log("checkAuthority : "+stateName);
        var cache = $scope.cacheAuthority[stateName];
        if(cache != null){
          return cache["readable"] == "Y";
        }
        var menu = $scope.loadAuthorityData(stateName);
        return menu["readable"] == "Y";
      }

      $scope.checkCreatableAuthority = function(stateName){
        var cache = $scope.cacheAuthority[stateName];
        if(cache != null){
          return cache["writable"] == "Y";
        }
        var menu = $scope.loadAuthorityData(stateName);
        return menu["writable"] == "Y";
      }

      $scope.checkConfirmableAuthority = function(stateName){
        var cache = $scope.cacheAuthority[stateName];
        if(cache != null){
          return cache["confirmable"] == "Y";
        }
        var menu = $scope.loadAuthorityData(stateName);
        return menu["confirmable"] == "Y";
      }

      $scope.loadAuthorityData = function(stateName){
        if($scope.userAuthority == null){
          $scope.userAuthority = JSON.parse(localStorage.getItem("user_authority"));
        }
        //console.log("$scope.userAuthority : "+$scope.userAuthority);
        //for(var k in $scope.userAuthority){
        //  console.log($scope.userAuthority[k]);
        //}
        if(stateName == null) return false;
        var name = "/"+stateName.replace("app.","");
        while(true){
          if(name.indexOf(".") >= 0){
            name = name.replace(".","/");
          }else{
            break;
          }
        }

        var menu = $scope.userAuthority.menus[name];
        if(menu == null) return false;

        $scope.cacheAuthority[stateName] = menu;
        return menu;
      }

      $scope.roundToTwo = function(num) {
          return +(Math.round(num + "e+2")  + "e-2");
      }

  }]);
});
