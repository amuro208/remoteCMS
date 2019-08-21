'use strict';

define(['angular','app','config.lazyload','config.router'],function(angular,app){

  app.controller(
    'DialogBaseController',
    [       '$scope','$translate','dialogs',
    function($scope,  $translate,  dialogs) {
      $scope._changeConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_CHANGE'));
      }
      $scope._deleteConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_DELETE'));
      };
      $scope._saveConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_SAVE'));
      };
      $scope._doneConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_DONE'));
      };
      $scope._cancelConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_CANCEL'));
      };
      $scope._rejectConfirmDialog = function(){
        return dialogs.confirm(
          $translate.instant('DIALOGS_CONFIRMATION'),
          $translate.instant('DIALOGS_CONFIRMATION_REJECT'));
      };
    }
    ]
  );

  app.controller(
    'BaseController',
    [       '$rootScope','$scope','$http','$location','$modal','$log','$controller','$timeout','$state','$window',
    function($rootScope,  $scope,  $http,  $location,  $modal,  $log,  $controller,  $timeout,  $state,  $window) {

      $controller('DialogBaseController',{$scope:$scope});

      $scope.mode = "list";
      $scope.lastStatus = "";
      $scope.originData = "";
      $scope.modifiedData = "";

      //define list & detail url....
      $scope.routeUrl = null;
      $scope.basicService = null;

      $scope.getMode = function(){
        return $scope.mode;
      }
      $scope.getLastStatus = function(){
        return $scope.lastStatus;
      }
      $scope.getOriginData = function(){
        return $scope.originData;
      }
      $scope.getModifiedData = function(){
        return $scope.modifiedData;
      }

      ////////////////////////////////////////////////////////////////////////////////////
      // Authorization
      ////////////////////////////////////////////////////////////////////////////////////
      $scope.$on("unauthenticated",function(){
        $location.path("/access/401");
      });

      ////////////////////////////////////////////////////////////////////////////////////
      // Date-Picker Optoins
      ////////////////////////////////////////////////////////////////////////////////////
      $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
      };

      $scope.setForm = function(form){
        $scope.myForm = form;
      }

      ////////////////////////////////////////////////////////////////////////////////////
      // CRUD Process Interface with View
      ////////////////////////////////////////////////////////////////////////////////////

      ///////////////////////////////////////////////////////////////////
      //----------------LIST DATA----------------
      ///////////////////////////////////////////////////////////////////
      /*
      in order to return to the list of data.
      the interface of UI.
      */
      $scope.listData = function(form){

        if(form == null){
		 console.log("#_mainListData form == null" +$scope.myForm);
          $scope._preListData($scope.myForm);
          $scope._mainListData($scope.myForm);
          $scope._postListData($scope.myForm);
        }else{
		 console.log("#_mainListData form != null"+form);
          $scope._preListData(form);
          $scope._mainListData(form);
          $scope._postListData(form);
        }
      };

      /*
      this function is called before dialog.
      */
      //Modify Page -> List Page
      $scope._preListData = function(form){

      }

      /*
      this function is called in order to process.
      */
      //Modify Page -> List Page
      $scope._mainListData = function(form){
        $scope.disabledEventPropagation(window.event);

        if(form == null){
          $scope.doList(null);
		  console.log("#_mainListData doList");
        }else{
          /*
          if(!$scope.isUnchanged()){
            $scope._changeConfirmDialog().result.then(function(btn){
              //YES
            },function(btn){
              //NO
              $scope.mode = "list";
              $scope.lastStatus = "NOCHANGE";
              form.$setPristine(true);
              $scope._toListPage();
            });
          }else{
          */
            $scope.mode = "list";
            $scope.lastStatus = "NOCHANGE";
            form.$setPristine(true);
            $scope._toListPage();
			console.log("#_mainListData No Changes");
          //}
        }
      };
      $scope._toListPage = function(){

        if($scope.routeUrl != null){
          if($scope.routeUrl.list != null){
            if($scope.routeUrl.list.indexOf("#") == -1){
              $window.location = "#"+$scope.routeUrl.list;
			  console.log("#"+$scope.routeUrl.list);
            }else{
              $window.location = $scope.routeUrl.list;
			  console.log($scope.routeUrl.list);
            }
          }
        }
      }

      /*
      this function is called after dialog.
      */
      //Modify Page -> List Page
      $scope._postListData = function(form){

      };

      ///////////////////////////////////////////////////////////////////
      //----------------CREATE DATA----------------
      ///////////////////////////////////////////////////////////////////
      $scope.createData = function(){
        $scope._preCreateData();
        $scope._mainCreateData();
        $scope._postCreateData();

        /*
        in order to clear the change of data.
        */
        $scope.originData = angular.copy($scope.modifiedData);

        if($scope.routeUrl != null){
          if($scope.routeUrl.detail != null){
            if($scope.routeUrl.list.indexOf("#") == -1){
              $window.location = "#"+$scope.routeUrl.detail;
			  console.log("$window.location : "+"#"+$scope.routeUrl.detail);
            }else{
              $window.location = $scope.routeUrl.detail;
			  console.log("$window.location : "+$scope.routeUrl.detail);
            }
          }
        }

      };

      //List Page -> Modify Page
      $scope._preCreateData = function(){

      };

      //List Page -> Modify Page
      $scope._mainCreateData = function(){
        $scope.disabledEventPropagation(window.event);
        $scope.mode = "create";
        $scope.originData = {};
        $scope.modifiedData = {};
      };

      //List Page -> Modify Page
      $scope._postCreateData = function(data){

      };

      ///////////////////////////////////////////////////////////////////
      //----------------MODIFY DATA----------------
      ///////////////////////////////////////////////////////////////////
      $scope.modifyData = function(data){

        $scope._preModifyData(data);
        $scope._mainModifyData(data);
        $scope._postModifyData(data);

        $scope.originData = angular.copy($scope.modifiedData);

        if($scope.routeUrl != null){
          if($scope.routeUrl.detail != null){
            $location.path($scope.routeUrl.detail);
			         console.log("$window.location : "+$scope.routeUrl.detail);
            //$scope.$apply();
          }
        }
      };

      //List Page -> Modify Page
      $scope._preModifyData = function(data){

      };

      //List Page -> Modify Page
      $scope._mainModifyData = function(data){
        $scope.disabledEventPropagation(window.event);
        $scope.mode = "modify";
        $scope.originData = angular.copy(data);
        $scope.modifiedData = angular.copy(data);
      };

      //List Page -> Modify Page
      $scope._postModifyData = function(data){

      };

      ///////////////////////////////////////////////////////////////////
      //----------------VIEW DATA----------------
      ///////////////////////////////////////////////////////////////////
      $scope.viewData = function(data){
        $scope._preModifyData(data);
        $scope._mainModifyData(data);
        $scope._postModifyData(data);

        $scope.originData = angular.copy($scope.modifiedData);
      };

      ///////////////////////////////////////////////////////////////////
      //----------------DELETE DATA----------------
      ///////////////////////////////////////////////////////////////////
      $scope.deleteData = function(data){
        $scope._preDeleteData(data);
        $scope._mainDeleteData(data);
        $scope._postDeleteData(data);

        /*
        in order to clear the change of data.
        */
        $scope.originData = angular.copy($scope.modifiedData);
      };

      $scope._preDeleteData = function(data){

      };

      $scope._mainDeleteData = function(data){
        $scope.disabledEventPropagation(window.event);
        $scope._deleteConfirmDialog().result.then(function(btn){
          //'You confirmed "Yes."';
          $scope.doDelete(data).then(function(){
            $scope.$broadcast('reloadData');
          });
        },function(btn){
          //'You confirmed "No."';
        });
      };

      $scope._postDeleteData = function(data){

      };

      ///////////////////////////////////////////////////////////////////
      //----------------SAVE DATA----------------
      ///////////////////////////////////////////////////////////////////
      /*
      In order to save data.
      this will call doCreate or doUpdate depending on mode.
      */
      $scope.saveData = function(form){
        if(form == null){
          $scope._preSaveData($scope.myForm);
          $scope._mainSaveData($scope.myForm);
          $scope._postSaveData($scope.myForm);
        }else{
          $scope._preSaveData(form);
          $scope._mainSaveData(form);
          $scope._postSaveData(form);
        }

      };

      $scope._preSaveData = function(form){

      };

      $scope._mainSaveData = function(form){
        $scope.disabledEventPropagation(window.event);
        $scope._saveConfirmDialog().result.then(function(btn){
          if($scope.mode == "create"){
            $scope.doCreate($scope.modifiedData).then(function(){
              $scope.listData();
            });
          }else{
            $scope.doModify($scope.modifiedData).then(function(){
              $scope.listData();
            });
          }
          if(form != null) form.$setPristine(true);
        },function(btn){
          //'You confirmed "No."';
        });
      };

      $scope._postSaveData = function(form){

      };
      ////////////////////////////////////////////////////////////////////////////////////

      ////////////////////////////////////////////////////////////////////////////////////
      // CRUD Process Interface with Servive
      ////////////////////////////////////////////////////////////////////////////////////

      ///////////////////////////////////////////////////////////////////
      // List
      ///////////////////////////////////////////////////////////////////
      /*
      in order to refresh the list of data.
      the interface between UI and Service.
      */
      $scope.doList = function(data,reload){
        if(reload == null) reload = false;
        if($scope.basicService == null){
          if(D) $log.info("doList is not implemented.");
        }else{
          data = $scope._preList(data);
          return $scope.basicService.listData(reload).then(function(listdata){
            $scope._postList(listdata);
          });
        }
      };

      /*
      this function is called before calling service.
      */
      $scope._preList = function(data){
        return data;
      };

      /*
      this function is called after getting returned value from the server.
      */
      $scope._postList = function(listdata){

      };

      ///////////////////////////////////////////////////////////////////
      // Create
      ///////////////////////////////////////////////////////////////////
      /*
      in order to create data.
      the interface between UI and Service.
      */
      $scope.doCreate = function(data){
        if($scope.basicService == null){
          if(D) $log.info("doCreate is not implemented.");
        }else{
          data = $scope._preCreate(data);
          return $scope.basicService.createData(data).then(function(data){
            $scope.originData = angular.copy(data);
            $scope.modifiedData = angular.copy(data);
            $scope.mode = "modify";
            //$scope.$broadcast('reloadData');
            $scope._postCreate(data);
          },
          function(error){},
          function(progress){});
        }
      }

      /*
      this function is called before calling service.
      */
      $scope._preCreate = function(data){
        return data;
      }

      /*
      this function is called after getting returned value from the server.
      */
      $scope._postCreate = function(data){

      }

      ///////////////////////////////////////////////////////////////////
      // Modify
      ///////////////////////////////////////////////////////////////////
      /*
      in order to update data.
      the interface between UI and Service.
      */
      $scope.doModify = function(data){
        if($scope.basicService == null){
          if(D) $log.info("doModify is not implemented.");
        }else{
          data = $scope._preModify(data);
          return $scope.basicService.updateData(data).then(function(data){
            $scope.originData = angular.copy(data);
            $scope.modifiedData = angular.copy(data);
            //$scope.$broadcast('reloadData');
            $scope._postModify(data);
          },
          function(error){},
          function(progress){});
        }
      }

      /*
      this function is called before calling service.
      */
      $scope._preModify = function(data){
        return data;
      }

      /*
      this function is called after getting returned value from the server.
      */
      $scope._postModify = function(data){

      }

      ///////////////////////////////////////////////////////////////////
      // Delete
      ///////////////////////////////////////////////////////////////////
      /*
      in order to delete data.
      the interface between UI and Service.
      */
      $scope.doDelete = function(data){
        if($scope.basicService == null){
          if(D) $log.info("doDelete is not implemented.");
        }else{
          data = $scope._preDelete(data);
          return $scope.basicService.deleteData(data).then(function(data){
            //$scope.$broadcast('reloadData');
            $scope._postDelete(data);
          },
          function(error){},
          function(progress){});
        }
      }

      /*
      this function is called before calling service.
      */
      $scope._preDelete = function(data){
        return data;
      }

      /*
      this function is called after getting returned value from the server.
      */
      $scope._postDelete = function(data){

      }

      ////////////////////////////////////////////////////////////////////////////////////
      // Utils
      ////////////////////////////////////////////////////////////////////////////////////
      $scope.log = function(message){
        if($scope.D) $log.log(message);
      }
      $scope.info = function(message){
        if($scope.D) $log.info(message);
      }
      $scope.debug = function(message){
        if($scope.D) $log.debug(message);
      }
      $scope.warn = function(message){
        if($scope.D) $log.warn(message);
      }
      $scope.error = function(message){
        if($scope.D) $log.error(message);
      }

      $scope.disabledEventPropagation = function(evt){
        if(evt == null) return;
        if (evt.stopPropagation){
          evt.stopPropagation();
        }else if(window.event){
          window.event.cancelBubble=true;
        }
      }

      $scope.isUnchanged = function(){
        if($scope.modifiedData == null) return false;
        if($scope.originData == null) return false;

        return compareObjects(
          $scope.originData,
          $scope.modifiedData
        );
      }

      $scope.getTree = function(data, primaryIdName, parentIdName) {
          if (!data || data.length == 0 || !primaryIdName || !parentIdName)
              return [];

          var tree = [],
          rootIds = [],
          item = data[0],
          primaryKey = item[primaryIdName],
          treeObjs = {},
          tempChildren = {},
          parentId,
          parent,
          len = data.length,
          i = 0;

          while (i < len) {
              item = data[i++];
              primaryKey = item[primaryIdName];

              if (tempChildren[primaryKey]) {
                  item.children = tempChildren[primaryKey];
                  delete tempChildren[primaryKey];
              }

              treeObjs[primaryKey] = item;
              parentId = item[parentIdName];

              if (parentId) {
                  parent = treeObjs[parentId];

                  if (!parent) {
                      var siblings = tempChildren[parentId];
                      if (siblings) {
                          siblings.push(item);
                      }
                      else {
                          tempChildren[parentId] = [item];
                      }
                  }
                  else if (parent.children) {
                      parent.children.push(item);
                  }
                  else {
                      parent.children = [item];
                  }
              }else {
                  rootIds.push(primaryKey);
              }
          }

          for (var i = 0; i < rootIds.length; i++) {
              tree.push(treeObjs[rootIds[i]]);
          };

          return tree;
      };

      $scope.getTree2 = function(data, primaryIdName, parentIdName) {
          if (!data || data.length == 0 || !primaryIdName || !parentIdName)
              return [];

          var tree = [],
          rootIds = [],
          item = data[0],
          primaryKey = item[primaryIdName],
          treeObjs = {},
          tempChildren = {},
          parentId,
          parent,
          len = data.length,
          i = 0;

          while (i < len) {
              item = data[i++];
              items.nodes = [];
              primaryKey = item[primaryIdName];

              if (tempChildren[primaryKey]) {
                  item.children = tempChildren[primaryKey];
                  delete tempChildren[primaryKey];
              }

              treeObjs[primaryKey] = item;
              parentId = item[parentIdName];

              if (parentId) {
                  parent = treeObjs[parentId];

                  if (!parent) {
                      var siblings = tempChildren[parentId];
                      if (siblings) {
                          siblings.push(item);
                      }
                      else {
                          tempChildren[parentId] = [item];
                      }
                  }
                  else if (parent.nodes) {
                      parent.nodes.push(item);
                  }
                  else {
                      parent.nodes = [item];
                  }
              }else {
                  rootIds.push(primaryKey);
              }
          }

          for (var i = 0; i < rootIds.length; i++) {
              tree.push(treeObjs[rootIds[i]]);
          };

          return tree;
      };
    }
    ]
  );
});

function compareObjects(o, p)
{
  if(o == null || o == undefined) return false;
  if(p == null || p == undefined) return false;

  var i,
      keysO = Object.keys(o).sort(),
      keysP = Object.keys(p).sort();

  if (keysO.length !== keysP.length){
    return false;//not the same nr of keys
  }

  if (keysO.join('') !== keysP.join('')){
    return false;//different keys
  }

  for (i=0;i<keysO.length;++i)
  {
    if (o[keysO[i]] instanceof Array)
    {
      if (!(p[keysO[i]] instanceof Array))
        return false;
      //if (compareObjects(o[keysO[i]], p[keysO[i]] === false) return false
      //would work, too, and perhaps is a better fit, still, this is easy, too
      if (p[keysO[i]].sort().join('') !== o[keysO[i]].sort().join(''))
        return false;
    }
    else if (o[keysO[i]] instanceof Date)
    {
      if (!(p[keysO[i]] instanceof Date))
        return false;
      if ((''+o[keysO[i]]) !== (''+p[keysO[i]]))
        return false;
    }
    else if (o[keysO[i]] instanceof Function)
    {
      if (!(p[keysO[i]] instanceof Function))
        return false;
      //ignore functions, or check them regardless?
    }
    else if (o[keysO[i]] instanceof Object)
    {
      if (!(p[keysO[i]] instanceof Object))
        return false;
      if (o[keysO[i]] === o)
      {//self reference?
        if (p[keysO[i]] !== p)
          return false;
      }
      else if (compareObjects(o[keysO[i]], p[keysO[i]]) === false)
        return false;//WARNING: does not deal with circular refs other than ^^
    }
    else if (o[keysO[i]] !== p[keysO[i]]){//change !== to != for loose comparison
      return false;//not the same value
    }
  }
  return true;
}

var inArray = Array.prototype.indexOf ?
              function (val, arr) {
                 return arr.indexOf(val)
              } :
              function (val, arr) {
                var i = arr.length;
                while (i--) {
                   if (arr[i] === val) return i;
                }
                return -1;
              };

function titlecompare(a,b) {
  if (a.title < b.title)
    return -1;
  if (a.title > b.title)
    return 1;
  return 0;
}
