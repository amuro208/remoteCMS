<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" ng-controller="AppCtrl"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en" ng-controller="AppCtrl"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en" ng-controller="AppCtrl"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-controller="AppCtrl"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
  <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $name;?></title>

  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="static/css/bootstrap.min.css<?php echo $version;?>" type="text/css" />
  <link rel="stylesheet" href="static/vendor/modules/angular-block-ui/angular-block-ui.min.css<?php echo $version;?>" type="text/css" />

  <link ng-repeat="stylesheet in stylesheets" ng-href="{{stylesheet}}" type="text/css" rel="stylesheet" />
  <script>var csrf_value = '';</script>
  <script>var version = '<?php echo $version;?>';</script>
  <script>var environment = '';</script>

  <script src="static/vendor/modernizr-2.6.2.min.js<?php echo $version;?>"></script>
  <script src="static/vendor/modules/moment.min.js<?php echo $version;?>"></script>
</head>
<body ng-class="{'compact':app.settings.compact}">

  <!--[if lt IE 8]>
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <div class="app" id="app"
       ng-class="{'app-header-fixed':app.settings.headerFixed, 'app-aside-fixed':app.settings.asideFixed, 'app-aside-folded':app.settings.asideFolded, 'app-aside-dock':app.settings.asideDock, 'container':app.settings.container, 'compact':app.settings.compact}"
      ui-view></div>
  <script data-main="static/js/main.js<?php echo $version;?>" src="static/vendor/requirejs/require.min.js<?php echo $version;?>"></script>

</body>
</html>
