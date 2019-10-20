'use strict';

/* Controllers */

var controllers = angular.module('seroApp.controllers');

controllers.controller('DatePickerController', ['$scope', function (scope)
{
    scope.open = function ($event)
    {
        $event.preventDefault();
        $event.stopPropagation();
        scope.opened = true;
    };
    scope.datepickerOptions =
    {
        startingDay: 1
        //,showButtonBar: false // Not working
    };
}]);

controllers.controller('DatePickerSearchController', ['$scope', function (scope)
{
    scope.open = function ($event)
    {
        $event.preventDefault();
        $event.stopPropagation();
        scope.opened = true;
    };
    scope.datepickerOptions =
        {
            startingDay: 1
            //,showButtonBar: false // Not working
        };
}]);



controllers.controller('NavBarController', ['$scope', '$location', 'UserInfo','EnvInfo', function (scope, location, UserInfo, EnvInfo)
{
    scope.userinfo = UserInfo;
    EnvInfo(function(env){scope.envinfo = env.env})
    scope.isActive = function (viewLocation)
    {
        return viewLocation === location.path();
    };
    scope.isAdvancedActive = function (viewLocation)
    {
        return location.path().indexOf(viewLocation) == 0;
    };
}]);

controllers.controller('HomeController', ['$scope', 'GeneralStatistics', function (scope, GeneralStatistics)
{
    scope.counts = {};

    GeneralStatistics.get({}, function (data)
    {
        scope.counts = data.counts;
    });
}]);

controllers.controller('UserController', ['$scope', 'UserInfo', function (scope, UserInfo)
{
    scope.userinfo = UserInfo;
    scope.userid_to_impersonate = null;
    scope.impersonate = function ()
    {
        scope.userinfo.impersonate(scope.userid_to_impersonate);
    };
}]);

controllers.controller('PirkingController', ['$scope', '$http', 'EiaPermit', 'Document', 'Valuelists', '$q', function (scope, $http, EiaPermit, Document, Valuelists, $q)
{
    scope.lastId = "..";
    scope.criteria = {};
    scope.dryrun = true;
    scope.eiaspermits = [];
    scope.working = false;
    scope.info = {
        error: 0,
        nochange: 0,
        changed: 0,
        finished: function ()
        {
            return this.error + this.nochange + this.changed;
        },
        progress: function ()
        {
            if (scope.eiaspermits.length == 0)
            {
                return 0;
            }
            return Math.round(100.0*this.finished()/scope.eiaspermits.length);
        }
    };

    scope.beginPirking = function ()
    {
        scope.info.error = 0;
        scope.info.nochange = 0;
        scope.info.changed = 0;

        console.log("beginPirking");
        console.log("dryrun:", scope.dryrun);
        scope.working = true;
        $http({
            method: 'GET',
            url: '/pirking/v1/eiaspermits',
            params: scope.criteria
        }).then(function successCallback(response)
        {
            scope.eiaspermits = response.data;
            console.log("beginPirking finished");
            scope.beginUpdate();

        }, function errorCallback(response)
        {
            console.log("oh noes");
        });
    };

    var getStatusCodeFromValuelist = function (id)
    {
        var code = _.find(Valuelists["eiastatus"], {'id': id});
        if (code)
        {
            return code.description1;
        }
        return "";
    };

    scope.beginUpdate = function ()
    {
        console.log("beginUpdate");
        function handleEiaPermitAsync(epMini)
        {
            epMini.updating = true;
            var params = {
                projectId: epMini.project_id,
                eiapermitId: epMini.eiapermit_id
            };

            var epPromise = EiaPermit.get(params).$promise;
            var dsPromise = Document.query(params).$promise;

            var deferred = $q.defer();
            $q.all([epPromise, dsPromise]).then(function (results)
            {
                var ep = results[0];
                var ds = results[1];
                var change = updateEiaPermitStatus(ep, ds);
                epMini.status_id_new = ep.status;
                epMini.status_description_new = getStatusCodeFromValuelist(ep.status);
                if (change)
                {
                    if (scope.dryrun)
                    {
                        epMini.changed = true;
                        epMini.result = "CHANGED";
                        scope.info.changed += 1;
                        epMini.updating = false;
                        deferred.resolve();
                    }
                    else
                    {
                        ep.pirking = true;
                        ep.$update(params, function (savedEp)
                        {
                            epMini.changed = true;
                            epMini.result = "CHANGED";
                            scope.info.changed += 1;
                            epMini.updating = false;
                            epMini.eiapermit_updated_at = savedEp.updated_at;
                            deferred.resolve();
                        });
                    }
                }
                else
                {
                    epMini.nochange = true;
                    epMini.result = "NO CHANGE";
                    scope.info.nochange += 1;
                    epMini.updating = false;
                    deferred.resolve();
                }
            }, function (error)
            {
                epMini.updating = false;
                epMini.error = true;
                epMini.result = "ERROR";
                scope.info.error += 1;
                deferred.reject("Server Error");
            });

            return deferred.promise;
        }

        function doAsyncSeriesParallel(arr)
        {
            return $q.all(arr.map(handleEiaPermitAsync));
        }

        function doAsyncSeries(arr)
        {
            return arr.reduce(function (promise, epMini)
            {
                return promise.then(function ()
                {
                    return handleEiaPermitAsync(epMini);
                }).catch(function (error)
                {
                    console.log("ERROR:", error)
                });
            }, $q.when());
        }

        doAsyncSeries(scope.eiaspermits).then(function ()
            {
                console.log("beginUpdate finished");
                scope.working = false;
            }
        );
    }
}]);