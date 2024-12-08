'use strict';

/* Controllers */

var controllers = angular.module('seroApp.controllers');

controllers.controller('EiapermitPirkingController', ['$scope', '$http', 'EiaPermit', 'Document', 'Valuelists', '$q', function (scope, $http, EiaPermit, Document, Valuelists, $q)
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

    $http({
        method: 'GET',
        url: '/pirking/v1/eiaspermits/stats',
    }).then(function successCallback(response)
    {
        scope.lastId = response.data;

    }, function errorCallback(response)
    {
        console.log("couldn't fetch stats");
    });

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

controllers.controller('ExternalAudiPirkingController', ['$scope', '$http', 'ProjectFactory', 'Document', 'Valuelists', '$q', function (scope, $http, ProjectFactory, Document, Valuelists, $q)
{
    scope.lastId = "sdjshdfj..";
    scope.criteria = {};
    scope.dryrun = true;
    scope.EaData = [];
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
            if (scope.EaData.length == 0)
            {
                return 0;
            }
            return Math.round(100.0*this.finished()/scope.EaData.length);
        }
    };

    $http({
        method: 'GET',
        url: '/pirking/v1/externalAuditList/stats',
    }).then(function successCallback(response)
    {
        scope.lastId = response.data;

    }, function errorCallback(response)
    {
        console.log("couldn't fetch stats");
    });

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
            url: '/pirking/v1/externalAuditList',
            params: scope.criteria
        }).then(function successCallback(response)
        {
            scope.EaData = response.data;
            console.log("beginPirking finished");
            scope.beginUpdate();

        }, function errorCallback(response)
        {
            console.log("oh noes");
        });
    };

    var getStatusCodeFromValuelist = function (id)
    {
        var code = _.find(Valuelists["eastatus"], {'id': id});
        if (code)
        {
            return code.description1;
        }
        return "";
    };

    scope.beginUpdate = function ()
    {
        console.log("beginUpdate");
        function handleExternalAuditAsync(eaMini)
        {
            eaMini.updating = true;
            var params = {
                projectId: eaMini.project_id,
                externalauditId: eaMini.externalaudit_id
            };
            var eaPromises = ProjectFactory.retrieveProjectData(params);
            // var dsPromise = Document.query(params).$promise;

            var deferred = $q.defer();
            $q.all([eaPromises[5]]).then(function (results)
            {
                var ea = _.find(results[0], {"id": eaMini.externalaudit_id});
                // var ds = results[1];
                console.log(ea, "data")
                var change = updateExternalAuditStatus(ea, ea.documents);
                eaMini.status_id_new = ea.status;
                eaMini.status_description_new = getStatusCodeFromValuelist(ea.status);
                if (change && (parseInt(eaMini.status_id_new)  != parseInt(eaMini.status_id)))
                {
                    if (scope.dryrun)
                    {
                        eaMini.changed = true;
                        eaMini.result = "CHANGED";
                        scope.info.changed += 1;
                        eaMini.updating = false;
                        deferred.resolve();
                    }
                    else
                    {
                        ea.pirking = true;
                        ea.$update(params, function (savedEa)
                        {
                            eaMini.changed = true;
                            eaMini.result = "CHANGED";
                            scope.info.changed += 1;
                            eaMini.updating = false;
                            eaMini.externalaudit_updated_at = savedEa.updated_at;
                            deferred.resolve();
                        });
                    }
                }
                else
                {
                    eaMini.nochange = true;
                    eaMini.result = "NO CHANGE";
                    scope.info.nochange += 1;
                    eaMini.updating = false;
                    deferred.resolve();
                }
            }, function (error)
            {
                eaMini.updating = false;
                eaMini.error = true;
                eaMini.result = "ERROR";
                scope.info.error += 1;
                deferred.reject("Server Error");
            });
            return deferred.promise;
        }

        function doAsyncSeriesParallel(arr)
        {
            return $q.all(arr.map(handleExternalAuditAsync));
        }

        function doAsyncSeries(arr)
        {
            return arr.reduce(function (promise, eaMini)
            {
                return promise.then(function ()
                {
                    var output = handleExternalAuditAsync(eaMini);
                    console.log(output, "ray");
                    return output; 
                }).catch(function (error)
                {
                    console.log("ERROR:", error)
                });
            }, $q.when());
        }

        doAsyncSeries(scope.EaData).then(function ()
            {
                console.log("beginUpdate finished");
                scope.working = false;
            }
        );
    }
}]);

controllers.controller('AuditInspecitionPirkingController', ['$scope', '$http', 'ProjectFactory', 'Valuelists', '$q', function (scope, $http, ProjectFactory, Valuelists, $q)
{
    scope.lastId = "..";
    scope.criteria = {};
    scope.dryrun = true;
    scope.aiData = [];
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
            if (scope.aiData.length == 0)
            {
                return 0;
            }
            return Math.round(100.0*this.finished()/scope.aiData.length);
        }
    };

    $http({
        method: 'GET',
        url: '/pirking/v1/auditInspection/stats',
    }).then(function successCallback(response)
    {
        scope.lastId = response.data;

    }, function errorCallback(response)
    {
        console.log("couldn't fetch stats");
    });

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
            url: '/pirking/v1/auditInspection',
            params: scope.criteria
        }).then(function successCallback(response)
        {
            scope.aiData = response.data;
            console.log("beginPirking finished");
            scope.beginUpdate();

        }, function errorCallback(response)
        {
            console.log("oh noes");
        });
    };

    var getStatusCodeFromValuelist = function (id)
    {
        var code = _.find(Valuelists["auditinspectionstatus"], {'id': id});
        if (code)
        {
            return code.description1;
        }
        return "";
    };

    scope.beginUpdate = function ()
    {
        console.log("beginUpdate");
        function handleAuditInspectionAsync(aiMini)
        {
            aiMini.updating = true;
            var params = {
                projectId: aiMini.project_id,
                auditinspectionId: aiMini.auditsInspections_id
            };
            var aiPromises = ProjectFactory.retrieveProjectData(params);
            var deferred = $q.defer();
            $q.all([aiPromises[3]]).then(function (results)
            {
                var ai = _.find(results[0], {"id":aiMini.auditsInspections_id});
                var change = updateAuditInspectionStatus(ai);
                aiMini.status_id_new = ai.status;
                aiMini.status_description_new = getStatusCodeFromValuelist(ai.status);
                if (change && (parseInt(aiMini.status_id_new)  != parseInt(aiMini.status_id)))
                {
                    if (scope.dryrun)
                    {
                        aiMini.changed = true;
                        aiMini.result = "CHANGED";
                        scope.info.changed += 1;
                        aiMini.updating = false;
                        deferred.resolve();
                    }
                    else
                    {
                        ai.pirking = true;
                        ai.$update(params, function (savedAi)
                        {
                            aiMini.changed = true;
                            aiMini.result = "CHANGED";
                            scope.info.changed += 1;
                            aiMini.updating = false;
                            aiMini.externalaudit_updated_at = savedAi.updated_at;
                            deferred.resolve();
                        });
                    }
                }
                else
                {
                    aiMini.nochange = true;
                    aiMini.result = "NO CHANGE";
                    scope.info.nochange += 1;
                    aiMini.updating = false;
                    deferred.resolve();
                }
            }, function (error)
            {
                aiMini.updating = false;
                aiMini.error = true;
                aiMini.result = "ERROR";
                scope.info.error += 1;
                deferred.reject("Server Error");
            });
            return deferred.promise;
        }

        function doAsyncSeriesParallel(arr)
        {
            return $q.all(arr.map(handleAuditInspectionAsync));
        }

        function doAsyncSeries(arr)
        {
            return arr.reduce(function (promise, aiMini)
            {
                return promise.then(function ()
                {
                    var output = handleAuditInspectionAsync(aiMini);
                    return output; 
                }).catch(function (error)
                {
                    console.log("ERROR:", error)
                });
            }, $q.when());
        }

        doAsyncSeries(scope.aiData).then(function ()
            {
                console.log("beginUpdate finished");
                scope.working = false;
            }
        );
    }
}]);

controllers.controller('PermitLicensePirkingController', ['$scope', '$http', 'ProjectFactory', 'Valuelists', '$q', function (scope, $http, ProjectFactory, Valuelists, $q)
{
    scope.lastId = "..";
    scope.criteria = {};
    scope.dryrun = true;
    scope.plData = [];
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
            if (scope.plData.length == 0)
            {
                return 0;
            }
            return Math.round(100.0*this.finished()/scope.plData.length);
        }
    };

    $http({
        method: 'GET',
        url: '/pirking/v1/permitLicense/stats',
    }).then(function successCallback(response)
    {
        scope.lastId = response.data;

    }, function errorCallback(response)
    {
        console.log("couldn't fetch stats");
    });

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
            url: '/pirking/v1/permitLicense',
            params: scope.criteria
        }).then(function successCallback(response)
        {
            scope.plData = response.data;
            console.log("beginPirking finished");
            scope.beginUpdate();

        }, function errorCallback(response)
        {
            console.log("oh noes");
        });
    };

    var getStatusCodeFromValuelist = function (id)
    {
        var code = _.find(Valuelists["permitlicencestatus"], {'id': id});
        if (code)
        {
            return code.description1;
        }
        return "";
    };

    scope.beginUpdate = function ()
    {
        console.log("beginUpdate");
        function handlePermitLicenseAsync(plMini)
        {
            var params = {
                projectId: plMini.project_id,
                permitlicenseId: plMini.permitLicense_id
            };
            var plPromises = ProjectFactory.retrieveProjectData(params);
            var deferred = $q.defer();
            $q.all([plPromises[4]]).then(function (results)
            {
                var pl = _.find(results[0], {"id":plMini.permitLicense_id});
                if(!pl) {
                    return;
                }
                console.log("before the change", pl);
                var change = updatePermitLicenseStatus(pl);
                plMini.status_id_new = pl.status;
                plMini.status_description_new = getStatusCodeFromValuelist(pl.status);
                if (change && (parseInt(plMini.status_id_new)  != parseInt(plMini.status_id)))
                {
                    if (scope.dryrun)
                    {
                        plMini.changed = true;
                        plMini.result = "CHANGED";
                        scope.info.changed += 1;
                        plMini.updating = false;
                        deferred.resolve();
                    }
                    else
                    {
                        pl.pirking = true;
                        pl.$update(params, function (savedpl)
                        {
                            plMini.changed = true;
                            plMini.result = "CHANGED";
                            scope.info.changed += 1;
                            plMini.updating = false;
                            plMini.externalaudit_updated_at = savedpl.updated_at;
                            deferred.resolve();
                        });
                    }
                }
                else
                {
                    plMini.nochange = true;
                    plMini.result = "NO CHANGE";
                    scope.info.nochange += 1;
                    plMini.updating = false;
                    deferred.resolve();
                }
            }, function (error)
            {
                plMini.updating = false;
                plMini.error = true;
                plMini.result = "ERROR";
                scope.info.error += 1;
                deferred.reject("Server Error");
            });
            return deferred.promise;
        }

        function doAsyncSeriesParallel(arr)
        {
            return $q.all(arr.map(handlePermitLicenseAsync));
        }

        function doAsyncSeries(arr)
        {
            return arr.reduce(function (promise, plMini)
            {
                return promise.then(function ()
                {
                    var output = handlePermitLicenseAsync(plMini);
                    return output; 
                }).catch(function (error)
                {
                    console.log("ERROR:", error)
                });
            }, $q.when());
        }

        doAsyncSeries(scope.plData).then(function ()
            {
                console.log("beginUpdate finished");
                scope.working = false;
            }
        );
    }
}]);