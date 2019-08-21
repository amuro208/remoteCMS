'use strict';

define(['angular','app','config.lazyload','config.router'],function(angular,app){

  app.service('BaseService',
  [         '$http','$rootScope','$q','$log','$location','$timeout','jwtHelper','blockUI',
   function ($http,  $rootScope,  $q,  $log,  $location,  $timeout,  jwtHelper,  blockUI) {

      var BaseService = {
        D:false,

        promise:null,
        isInit:null,
        isInitialized:false,
        isPageInitialized:false,

        allDatas:null,
        allDatasByPage:null,

        treeData:null,

        dataUrl:"",
        batchUrl:"",
        dataIdUrl:"",

        //authUser:null,

        ids:null,

        getDataUrl:function(){
          return this.dataUrl;
        },
        getIdDataUrl:function(){
          return this.dataIdUrl;
        },
        getIds:function(){
          return this.ids;
        },
        setIds:function(data){
          this.ids = data;
        },
        setAllDatas:function(data){
          this.allDatas = data;
        },
        getAllDatas:function(){
          return this.allDatas;
        },
        setAllDatasByPage:function(data){
          this.allDatasByPage = data;
          this.allDatas = data.data;
        },
        getAllDatasByPage:function(){
          return this.allDatasByPage;
        },
        setTreeData:function(data){
          this.treeData = data;
        },
        getTreeData:function(){
          return this.treeData;
        },
        getOptions:function(){
          if(this.D) $log.info("servicebase.getOptions");
          var self = this;
          var datas = [];
          var allDatas = self.getAllDatas();
          for ( var x in allDatas) {
            var data = allDatas[x];
            datas.push({"text":data.name,"value":data.id});
          }
          return datas;
        },

        ///////////////////////////////////////////////////////////////////
        // INITIALIZE
        ///////////////////////////////////////////////////////////////////
        init:function(options){
          if(this.D) $log.info("servicebase.init");
          blockUI.start("Loading...");
          var self = this;
          self.urls(options);

          var promise = self._http_get(self.dataUrl).then(function(data){
            if(self.D) $log.info(data);
            self.setAllDatas(data);
            self.isInitialized = true;
            blockUI.stop();
          },function(error){
            blockUI.stop();
          });
          self.promise = promise;
          self.isInit = promise;

          //self.initAuthUser();
        },
        initWithPage:function(options){
          if(this.D) $log.info("servicebase.initWithPage");
          var self = this;
          self.urls(options);
          //self.initAuthUser();
          self.isPageInitialized = true;
        },
        isPageMode:function(){
          return this.isPageInitialized;
        },
        //initAuthUser:function(){
        //  var token = localStorage.getItem("id_token");
        //  if(token != null && token != ""){
        //    self.authUser = jwtHelper.decodeToken(token);
        //  }
        //},
        urls:function(options){
          if(this.D) $log.info("servicebase.urls");
          this.dataUrl = options.dataUrl;
          this.batchUrl = options.batchUrl;
          this.dataIdUrl = options.dataIdUrl;
        },

        ///////////////////////////////////////////////////////////////////
        // LIST
        ///////////////////////////////////////////////////////////////////
        /**
        listParams.page  --> page
        listParams.count --> pageSize
        listParams.sorting --> association array of sorting / order by clause
        listParams.filter --> association array of filter / where clause
        */
        listData:function(isForceFetch,listParams){
          var self = this;
          if(self.isPageMode()){
            if(listParams == null){
              listParams = $rootScope.listParams;
            }
            return self.listDataByPage(listParams);
          }else{
            return self.listDataByAll(isForceFetch);
          }
        },
        listDataByAll:function(isForceFetch){
          if(this.D) $log.info("servicebase.listDataByAll");
          if(isForceFetch == null){
            isForceFetch = false
          }

          blockUI.start("Loading...");
          var self = this;
          if(self.isInitialized && !isForceFetch){
            var deferred = $q.defer();
            $timeout(function(){
              deferred.resolve(self.getAllDatas());
              blockUI.stop();
            });
            return deferred.promise;
          }else{
            var deferred = $q.defer();
            self._http_get(self.dataUrl).then(function(data){
              if(self.D) $log.info(data);
              self.setAllDatas(data);
              //console.log("listDataByAll"+data);
              self.isInitialized = true;
              deferred.resolve(data);
              blockUI.stop();
            },function(error){
              deferred.reject(error);
              blockUI.stop();
            });
            return deferred.promise;
          }
        },

        listDataByPage:function(listParams){
          if(this.D) $log.info("servicebase.listDataByPage");
          var self = this;
          var deferred = $q.defer();

          blockUI.start("Loading...");
          $http.get(self.dataUrl,{params:{pageMode:self.isPageMode(),pageParams:listParams}}).success(function (data) {
            try{
              if(self.D) $log.info(data);
              self.setAllDatasByPage(data);
              deferred.resolve(data);
              blockUI.stop();
            }catch($e){
              blockUI.stop();
            }
          }).error(function(msg, code) {
            deferred.reject(msg);
            blockUI.stop();
          });
          return deferred.promise;
        },

        listDataByParams:function(listParams,url){
          if(this.D) $log.info("servicebase.listDataByParams");

          var self = this;
          var deferred = $q.defer();

          if(url == null) url = self.dataUrl;

          blockUI.start("Loading...");
          $http.get(url,{params:{pageParams:listParams}}).success(function (data) {
            try{
              if(self.D) $log.info(data);

              deferred.resolve(data);
              blockUI.stop();
            }catch($e){
              blockUI.stop();
            }
          }).error(function(msg, code) {
            deferred.reject(msg);
            blockUI.stop();
          });
          return deferred.promise;
        },

        fetchDataFromUrl:function(url){
          if(this.D) $log.info("servicebase.fetchDataFromUrl");
          var self = this;

          blockUI.start("Loading...");

          var deferred = $q.defer();
          self._http_get(url).then(function(data){
            if(self.D) $log.info(data);
            deferred.resolve(data);
            blockUI.stop();
          },function(error){
            deferred.reject(error);
            blockUI.stop();
          });

          return deferred.promise;
        },

        _http_get:function(url){
          if(this.D) $log.info("servicebase._http_get");
          var self = this;
          var deferred = $q.defer();
          $http.get(url).success(function (data) {
            try{
              if(self.D) $log.info(data);
              if(data instanceof Array){
                for(var i in data){
                  data[i].selected = false;
                }
              }else{
                if(data != null){
                  data.selected = false;
                }
              }
              deferred.resolve(data);
            }catch($e){
              //console.error($e);
              //console.error($e.getStack());
              deferred.reject($e);
            }
          }).error(function(data,status,headers,config) {
            deferred.reject({data:data,status:status});
          });
          return deferred.promise;
        },
        listDataByAid:function(aid){
          if(this.D) $log.info("servicebase.listDataByAid");
          var self = this;
          var deferred = $q.defer();
          var url = self.dataUrl.replace(':aid',aid);
          return self._http_get(url);
        },

        ///////////////////////////////////////////////////////////////////
        // CREATE
        ///////////////////////////////////////////////////////////////////
        createData:function(data){
          if(this.D) $log.info("servicebase.createData");
          blockUI.start("Creating...");

          var self = this;
          var deferred = $q.defer();
          self._http_post(self.dataUrl,data).then(function(data){

            if(self.isInitialized){
              var alldatas = self.getAllDatas();
              alldatas[alldatas.length] = data;
              self.setAllDatas(alldatas);
            }

            deferred.resolve(data);
            blockUI.stop();
          },function(error){
            deferred.reject(error);
            blockUI.stop();
          });
          return deferred.promise;
        },
        _http_post:function(url,data){
          if(this.D) $log.info("servicebase._http_post");
          var self = this;
          var deferred = $q.defer();
          data['csrf_test_name'] = csrf_value;
          $http.post(url,data).success(function(data,status,headers,config){
            deferred.resolve(data);
          }).error(function(data,status,headers,config) {
            deferred.reject({data:data,status:status});
          });
          return deferred.promise;
        },
        postDataToUrl:function(url,data){
          if(this.D) $log.info("servicebase._http_post");
          var self = this;
          var deferred = $q.defer();
          data['csrf_test_name'] = csrf_value;
          $http.post(url,data).success(function(data,status,headers,config){
            deferred.resolve(data);
          }).error(function(data,status,headers,config) {
            deferred.reject({data:data,status:status});
          });
          return deferred.promise;
        },

        ///////////////////////////////////////////////////////////////////
        // UPDATE
        ///////////////////////////////////////////////////////////////////
        updateData:function(data){
          if(this.D) $log.info("servicebase.updateData");
          blockUI.start("Updating...");

          var self = this;
          var url = self.dataIdUrl.replace(':id',data.id+"/csrf_test_name/"+csrf_value);

          var deferred = $q.defer();
          self._http_put(url,data).then(function(data){

            if(self.isInitialized){
              var alldatas = self.getAllDatas();
              for(var i in alldatas){
                if(alldatas[i].id == data.id){
                  alldatas[i] = data;
                  break;
                }
              }
              self.setAllDatas(alldatas);
            }

            deferred.resolve(data);
            blockUI.stop();
          },function(error){
            deferred.reject(error);
            blockUI.stop();
          });
          return deferred.promise;
        },
        _http_put:function(url,data){
          if(this.D) $log.info("servicebase._http_put");
          var self = this;
          var deferred = $q.defer();
          data['csrf_test_name'] = csrf_value;
          $http.put(url,data).success(function(data){
            deferred.resolve(data);
          }).error(function(data,status,headers,config) {
            deferred.reject({data:data,status:status});
          });
          return deferred.promise;
        },

        ///////////////////////////////////////////////////////////////////
        // DELETE
        ///////////////////////////////////////////////////////////////////
        deleteData:function(data){
          if(this.D) $log.info("servicebase.deleteData");
          blockUI.start("Deleting...");

          var self = this;
          var url = self.dataIdUrl.replace(':id',data.id+"/csrf_test_name/"+csrf_value);

          var deferred = $q.defer();
          self._http_delete(url).then(function(data){

            if(self.isInitialized){
              var alldatas = self.getAllDatas();
              var datas = [];
              for(var i in alldatas){
                if(alldatas[i].id != data.id){
                  datas[datas.length] = alldatas[i];
                }
              }
              self.setAllDatas(datas);
            }

            deferred.resolve(data);
            blockUI.stop();
          },function(error){
            deferred.reject(error);
            blockUI.stop();
          });
          return deferred.promise;
        },
        _http_delete:function(url){
          if(this.D) $log.info("servicebase._http_delete");
          var self = this;
          var deferred = $q.defer();
          $http.delete(url).success(function(data){
            deferred.resolve(data);
          }).error(function(data,status,headers,config) {
            deferred.reject({data:data,status:status});
          });
          return deferred.promise;
        },

        getDataById : function(id){
          if(this.D) $log.info("servicebase.getDataById");
          var self = this;
          var deferred = $q.defer();

          var allDatas = this.getAllDatas();
          if(allDatas != null){
            for(var i in allDatas){
              if(allDatas[i].id == id){
                $timeout(function(){
                  deferred.resolve(allDatas[i]);
                });
                return deferred.promise;
              }
            }
          }

          var url = self.dataIdUrl.replace(':id',id);
          blockUI.start("Loading...");
          self._http_get(url).then(function(data){
            deferred.resolve(data);
            blockUI.stop();
          },function(error){
            deferred.reject(error);
            blockUI.stop();
          });

          return deferred.promise;
        },
        setDataAt : function(index,data){
          var allDatas = this.getAllDatas();
          allDatas[index] = data;
          this.setAllDatas(allDatas);
        },
        getDataLength : function(){
          var allDatas = this.getAllDatas();
          return allDatas.length;
        },
        getDataAt : function(index){
          var allDatas = this.getAllDatas();
          return allDatas[index];
        },

        ////////////////////////////////////////////////////////////////
        // UTILS
        ////////////////////////////////////////////////////////////////
        getTree : function(tdata, primaryIdName, parentIdName) {
            var data = angular.copy(tdata);
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
        },
        reverseTree : function(tree){
          var self = this;
          var list = [];
          for(var i in tree){
            list[list.length] = tree[i];
            if(!tree[i].children || tree[i].children.length == 0){

            }else{
              var list2 = self.reverseTree(tree[i].children);
              for(var j in list2){
                list[list.length] = list2[j];
              }
              tree[i].children = [];
            }
          }
          return list;
        },
        getTree2 : function(tdata, primaryIdName, parentIdName) {
          var data = angular.copy(tdata);
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
              item.nodes = [];
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
        },

        reverseTree2 : function(tree){
          var self = this;
          var list = [];
          for(var i in tree){
            list[list.length] = tree[i];
            if(!tree[i].nodes || tree[i].nodes.length == 0){

            }else{
              var list2 = self.reverseTree(tree[i].nodes);
              for(var j in list2){
                list[list.length] = list2[j];
              }
              tree[i].children = [];
            }
          }
          return list;
        }
      }
      ;

      return BaseService;

  }]);

});
