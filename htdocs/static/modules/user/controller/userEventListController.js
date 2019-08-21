'use strict';

angular.module('app').controller('UserListController',
[       '$scope','$location','userEventService','$controller','$q','$http','$stateParams',
function($scope,  $location,  userEventService,  $controller,  $q,  $http,  $stateParams) {

  $controller('BaseListController',{$scope:$scope});
  $scope.title = "User";// +$stateParams.project+"-"+$stateParams.event;
  $scope.templateUrl = function(){
      if($stateParams.project != null && $stateParams.project != undefined){
        if($stateParams.event != null && $stateParams.event != undefined){
          return 'static/modules/user/views/userlist_'+$stateParams.project+'_'+$stateParams.event+'.html';
        }else{
          return 'static/modules/user/views/userlist_'+$stateParams.project+'.html';
        }
      }else{
        return 'static/modules/user/views/userlist.html';
      }

  }
  $scope.listData = [];
  $scope.listService = userEventService;

  //for(var l in $stateParams){
  //  console.log("$stateParams : "+$stateParams[l]);
  //}

  if($stateParams.project != null && $stateParams.project != undefined){
    if($stateParams.event != null && $stateParams.event != undefined){
      $scope.listService.dataUrl = 'index.php/userdata/data/projectCode/'+$stateParams.project+'/eventCode/'+$stateParams.event+'/format/json';
    }else{
      $scope.listService.dataUrl = 'index.php/userdata/data/projectCode/'+$stateParams.project+'/format/json';
    }
  }else{
    $scope.listService.dataUrl = 'index.php/userdata/data/format/json';
  }


  //To Go Back to LIST with params.
  $scope.routeUrl.list = "/app/user/project/"+$stateParams.project+"/event/"+$stateParams.event;




  if($stateParams.event == "Maderation"){
    $scope.maderateMode = true;
    $scope.listTableOptions = {
      page:1,
      count:1000,
      sorting: {
        id:'desc'
      }
    };
  }else{
    $scope.maderateMode = false;
    $scope.listTableOptions = {
      page:1,
      count:10,
      sorting: {
        id:'desc'
      }
    };
  }

  $scope.downloadVideo = function(data){
    //console.log("Video Download");
    //var url = "http://www.sbspopweekend.com.au/downloadurl.php?acode="+data.acode;
    //$("#download_frame").attr("src",url)
  }

  $scope.onClickApproved = function(data){
    if(data.isApproved == true)
      data.isApproved = "Y";
    else
      data.isApproved = "N";
    $scope.listService.updateData(data);
  };

  $scope.onClickSentEamil = function(data){
    if(data.isSentEmail == true)
      data.isSentEmail = "Y";
    else
      data.isSentEmail = "N";
    $scope.listService.updateData(data);
  };

  $scope.onClickMaderate = function(){
    var maxid = 0;
    var list = $scope.listService.getAllDatasByPage();
    for(var i in list.data){
      if(list.data[i].id > maxid){
        maxid = list.data[i].id;
      }
    }
    var url="index.php/userdata/maderate/maxid/"+maxid+"/format/json";
    $scope.listService.fetchDataFromUrl(url).then(function(){
      $scope.$broadcast("reloadData");
    });
  }

  $scope.checkTitle = "Check";
  $scope.checkIcon = "check";
  $scope.checkAll = function(){
    if (!$scope.selectedAll) {
      $scope.selectedAll = true;
      $scope.checkTitle = "Uncheck";
      $scope.checkIcon = "unchecked";
    } else {
      $scope.selectedAll = false;
      $scope.checkTitle = "Check";
      $scope.checkIcon = "check";
    }

    var list = userEventService.getAllDatas();
    for(var i in list){
      list[i].selected = $scope.selectedAll;
    }
  }

  $scope.onClickDeleteAll = function(){
    console.log('onClickDeleteAll');
    console.log(userEventService.getAllDatas());

    $scope._deleteConfirmDialog().result.then(function(btn){
      //'You confirmed "Yes."';
      var list = userEventService.getAllDatas();
      var ids = "";
      for(var i in list){
        if(list[i].selected){
          console.log(list[i].id);
          ids += list[i].id + "_";
        }
      }
      var url="index.php/userdata/batch/ids/"+ids;
      $http.delete(url).success(function(data){
        console.log(data);
        $scope.$broadcast('reloadData');
      }).error(function(data,status,headers,config) {
        //deferred.reject({data:data,status:status});
      });

    },function(btn){
      //'You confirmed "No."';
    });

    $scope.selectedAll = false;
    $scope.checkTitle = "Check";
    $scope.checkIcon = "check";
  };

}]);
