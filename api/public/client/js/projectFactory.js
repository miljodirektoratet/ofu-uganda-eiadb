'use strict';

services.factory('ProjectFactory', ['$q', '$filter', 'Project', 'Organisation', 'EiaPermit', 'Document', 'AuditInspection', 'Valuelists', function ($q, $filter, Project, Organisation, EiaPermit, Document, AuditInspection, Valuelists)
{
    var factory = {};
    factory.project = {};
    factory.organisation = {};
    factory.eiaspermits = [];
    factory.eiapermit = {};
    factory.documents = [];
    factory.document = {};
    factory.auditsinspections = [];
    factory.auditinspection = {};
    factory.valuelists = Valuelists;
    factory.retrieveProjectData = function (params)
    {
        var deferredProject = $q.defer();
        var deferredOrganisation = $q.defer();
        var deferredEiasPermits = $q.defer();
        var deferredEiaPermit = $q.defer();
        var deferredAuditsInspections = $q.defer();
        var deferredAuditInspection = $q.defer();


        if (factory.project.id != params.projectId)
        {
            factory.empty();
            factory.project = Project.get(params, function (p)
            {
                deferredProject.resolve(p);
                factory.organisation = Organisation.get({organisationId: p.organisation_id}, function (o)
                {
                    deferredOrganisation.resolve(o);
                });
            });

            // params contains eiapermitId, so we can't user params directly.
            factory.eiaspermits = EiaPermit.query(_.omit(params, 'eiapermitId'), function (eps)
            {
                factory.retrieveEiaPermit(params).then(function (ep)
                {
                    deferredEiaPermit.resolve(ep);
                });
                deferredEiasPermits.resolve(eps);
            });

            // params contains auditinspection, so we can't user params directly.
            factory.auditsinspections = AuditInspection.query(_.omit(params, 'auditinspectionId'), function (ais)
            {
                factory.retrieveAuditInspection(params).then(function (ai)
                {
                    deferredAuditInspection.resolve(ai);
                });
                deferredAuditsInspections.resolve(ais);
            });
        }
        else
        {
            deferredProject.resolve(factory.project);
            deferredOrganisation.resolve(factory.organisation);

            factory.retrieveEiaPermit(params).then(function (ep)
            {
                deferredEiaPermit.resolve(ep);
            });
            deferredEiasPermits.resolve(factory.eiaspermits);

            factory.retrieveAuditInspection(params).then(function (ai)
            {
                deferredAuditInspection.resolve(ai);
            });
            deferredAuditsInspections.resolve(factory.auditsinspections);
        }
        return [deferredProject.promise, deferredOrganisation.promise,
            deferredEiasPermits.promise, deferredEiaPermit.promise,
            deferredAuditsInspections.promise, deferredAuditInspection.promise];
    };

    factory.retrieveEiaPermit = function (params)
    {
        var deferred = $q.defer();
        if (params.eiapermitId)
        {
            var hits = $filter('filter')(factory.eiaspermits, {'id': params.eiapermitId});
            if (hits.length == 1)
            {
                factory.eiapermit = hits[0];
                factory.eiapermit.$get(params, function (ep)
                {
                    factory.documents = Document.query(params, function (ds)
                    {

                    });
                    deferred.resolve(ep);
                });
            }
        }
        /*        else if (factory.eiaspermits.length > 0)
         {
         if (_.isEmpty(factory.eiapermit))
         {
         factory.eiapermit = factory.eiaspermits[0];
         }
         }*/
        return deferred.promise;
    };

    factory.retrieveAuditInspection = function (params)
    {
        var deferred = $q.defer();
        if (params.auditinspectionId)
        {
            var hits = $filter('filter')(factory.auditsinspections, {'id': params.auditinspectionId});
            if (hits.length == 1)
            {
                factory.auditinspection = hits[0];
                factory.auditinspection.$get(params, function (ai)
                {
                    deferred.resolve(ai);
                });
            }
        }
        /*else if (factory.auditsinspections.length > 0)
         {
         if (_.isEmpty(factory.auditinspection))
         {
         factory.auditinspection = factory.auditsinspections[0];
         }
         }*/
        return deferred.promise;
    };

    factory.getProjectSummary = function (currentTab)
    {
        var p = factory.project;
        if (!p.title)
        {
            return "";
        }
        if (currentTab == ProjectTabEnum.AuditsInspections)
        {
            return p.title + " (Performance: " + factory.getCodeFromValuelist("grade", p.grade) + ")";
        }
        return p.title;
    };

    factory.getEiaPermitSummary = function (ep)
    {
        var ep = ep || factory.eiapermit;
        if (_.isEmpty(ep))
        {
            return "";
        }
        return "Status for id " + ep.id + ": " + factory.getCodeFromValuelist("eiastatus", ep.status);
    };

    factory.getAuditInspectionSummary = function (ai)
    {
        var ai = ai || factory.auditinspection;
        if (_.isEmpty(ai))
        {
            return "";
        }
        return "Number " + ai.code + ": " + factory.getCodeFromValuelist("auditinspectionstatus", ai.status);
    };

    factory.getCodeFromValuelist = function (valuelistName, id)
    {
        var code = _.find(factory.valuelists[valuelistName], {'id': id});
        if (code)
        {
            return code.description1;
        }
        return "";
    };

    factory.setOrganisation = function (o)
    {
        var deferred = $q.defer();
        factory.organisation = o;
        o.$get({}, function (o)
        {
            deferred.resolve(o);
        });
        return deferred.promise;
    };

    factory.setEiaPermit = function (ep)
    {
        var deferred = $q.defer();
        factory.eiapermit = ep;
//    ep.$get({}, function(ep)
//    {
//      deferred.resolve(ep);
//    });
        deferred.resolve(ep);
        return deferred.promise;
    };

    factory.setAuditInspection = function (ai)
    {
        var deferred = $q.defer();
        factory.auditinspection = ai;
        deferred.resolve(ai);
        return deferred.promise;
    };

    factory.empty = function ()
    {
        factory.project = {};
        factory.organisation = {};
        factory.eiaspermits = [];
        factory.eiapermit = {};
        factory.documents = [];
        factory.document = {};
        factory.auditsinspections = [];
        factory.auditinspection = {};
    };

    factory.createNewProject = function (o)
    {
        var pData =
        {
            has_industrial_waste_water: 42, // 42=Unknown
            grade: 47, // 47=Unknown
            organisation_id: o.id,
            is_new: true
        };
        factory.project = new Project(pData);
    };

    factory.createNewOrganisation = function ()
    {
        var oData =
        {
            is_new: true
        };
        factory.organisation = new Organisation(oData);
    };

    factory.createNewEiaPermit = function (p)
    {
        var epData =
        {
            project_id: p.id,
            is_new: true
        };
        factory.eiapermit = new EiaPermit(epData);
        factory.eiaspermits.push(factory.eiapermit);
    };

    factory.createNewDocument = function (ep)
    {
        var dData =
        {
            eia_permit_id: ep.id,
            sub_final: 42,
            director_copy_no: 1,
            is_new: true
        };
        factory.document = new Document(dData);
        factory.documents.unshift(factory.document);
    };

    factory.deleteEiaPermit = function (params)
    {
        var index = _.findIndex(factory.eiaspermits, {'id': factory.eiapermit.id});
        var onDelete = function (index)
        {
            factory.eiaspermits.splice(index, 1);
            if (factory.eiaspermits.length > 0)
            {
                factory.eiapermit = factory.eiaspermits[0];
            }
            else
            {
                factory.eiapermit = {};
            }
        }
        if (factory.eiapermit.is_new)
        {
            onDelete(index);
        }
        else
        {
            factory.eiapermit.$delete(params, function ()
            {
                onDelete(index);
            });
        }
    };

    factory.deleteDocument = function (params)
    {
        var index = _.findIndex(factory.documents, {'id': factory.document.id});
        var onDelete = function (index)
        {
            factory.documents.splice(index, 1);
            factory.document = {};
        };
        if (factory.document.is_new)
        {
            onDelete(index);
        }
        else
        {
            factory.document.$delete(params, function ()
            {
                onDelete(index);
            });
        }
    };

    factory.createNewAuditInspection = function (p, year, type, reason)
    {
        var aiData =
        {
            project_id: p.id,
            year: year,
            type: type,
            reason: reason,
            days: 1,
            status: 70,
            is_new: true
        };
        factory.auditinspection = new AuditInspection(aiData);
        factory.auditsinspections.push(factory.auditinspection);
    };

    factory.deleteAuditInspection = function (params)
    {
        var index = _.findIndex(factory.auditsinspections, {'id': factory.auditinspection.id});
        var onDelete = function (index)
        {
            factory.auditsinspections.splice(index, 1);
            if (factory.auditsinspections.length > 0)
            {
                factory.auditinspection = factory.auditinspection[0];
            }
            else
            {
                factory.auditinspection = {};
            }
        }
        if (factory.auditinspection.is_new)
        {
            onDelete(index);
        }
        else
        {
            factory.auditinspection.$delete(params, function ()
            {
                onDelete(index);
            });
        }
    };

    factory.save = function (params, form, resource)
    {
        var deferred = $q.defer();
        if (resource.is_new)
        {
            //console.log(params);
            var saveParams = _.omit(params, function (value)
            {
                return value == "new";
            });
            resource.$save(saveParams, function (data)
            {
                deferred.resolve(data);
            }, function ()
            {
                deferred.reject("Saving new failed");
            });
        }
        else
        {
            resource.$update(params, function (data)
            {
                deferred.resolve(data);
            }, function ()
            {
                deferred.reject("Saving exisiting failed");
            });
        }
        return deferred.promise;
    };

    return factory;
}]);