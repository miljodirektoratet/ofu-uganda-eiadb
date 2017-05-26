'use strict';

services.factory('ProjectFactory', ['$q', '$filter', 'Project', 'Organisation', 'EiaPermit', 'Document', 'Hearing', 'AuditInspection', 'Valuelists', 'UserInfo',
    function ($q, $filter, Project, Organisation, EiaPermit, Document, Hearing, AuditInspection, Valuelists, UserInfo)
    {
        var factory = {};
        factory.project = {};
        factory.organisation = {};
        factory.eiaspermits = [];
        factory.eiapermit = {};
        factory.documents = [];
        factory.document = {};
        factory.hearings = [];
        factory.hearing = {};

        factory.externalaudits = [];
        factory.externalaudit = {};
        factory.documents_ea = [];
        factory.document_ea = {};
        factory.hearings_ea = [];
        factory.hearing_ea = {};

        factory.auditsinspections = [];
        factory.auditinspection = {};
        factory.valuelists = Valuelists;
        factory.userinfo = UserInfo;

        factory.project2 =
            {
                externalaudits: [],
                externalaudit:
                    {
                        documents: [],
                        document:
                            {
                                hearings: [],
                                hearing: {}
                            }
                    }
            };


        factory.hasData =
            {
                eiapermits: false,
                eiapermit: false,
                documents: false,
                document: false,
                hearings: false,
                hearing: false
            };


        factory.retrieveProjectData = function (params)
        {
            var deferredProject = $q.defer();
            var deferredOrganisation = $q.defer();
            var deferredEiasPermits = $q.defer();
            var deferredAuditsInspections = $q.defer();
            var deferredAuditInspection = $q.defer();

            if (factory.project.id != params.projectId)
            {
                var simpleParams = _.omit(params,  ['eiapermitId', 'externalauditId',  'documentId', 'hearingId', 'auditinspectionId']);
                factory.empty();
                factory.project = Project.get(simpleParams, function (p)
                {
                    deferredProject.resolve(p);
                    factory.organisation = Organisation.get({organisationId: p.organisation_id}, function (o)
                    {
                        deferredOrganisation.resolve(o);
                    });
                });

                factory.eiaspermits = EiaPermit.query(simpleParams, function (eps)
                {
                    deferredEiasPermits.resolve(eps);
                });

                factory.auditsinspections = AuditInspection.query(simpleParams, function (ais)
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
                deferredEiasPermits.resolve(factory.eiaspermits);

                factory.retrieveAuditInspection(params).then(function (ai)
                {
                    deferredAuditInspection.resolve(ai);
                });
                deferredAuditsInspections.resolve(factory.auditsinspections);
            }
            return [deferredProject.promise, deferredOrganisation.promise,
                deferredEiasPermits.promise,
                deferredAuditsInspections.promise, deferredAuditInspection.promise];
        };

        factory.retrieveEiaPermit = function (params)
        {
            var deferredEiaPermit = $q.defer();
            var deferredDocuments = $q.defer();

            if (factory.eiapermit.id != params.eiapermitId)
            {
                factory.emptyEiaPermit();
                var hits = $filter('filter')(factory.eiaspermits, {'id': params.eiapermitId});
                if (hits.length == 1)
                {
                    factory.eiapermit = hits[0];
                    factory.eiapermit.$get(_.omit(params, ['documentId', 'hearingId']), function (ep)
                    {
                        // params contains documentId, so we can't user params directly.
                        factory.documents = Document.query(_.omit(params, ['documentId', 'hearingId']), function (ds)
                        {
                            deferredDocuments.resolve(ds);
                        });
                        deferredEiaPermit.resolve(ep);
                    });
                }
            }
            else
            {
                deferredEiaPermit.resolve(factory.eiapermit);
                deferredDocuments.resolve(factory.documents);
            }

            return [deferredEiaPermit.promise, deferredDocuments.promise];
        };

        factory.retrieveExternalAudit = function (params)
        {
            var deferredExternalAudit = $q.defer();
            var deferredDocuments = $q.defer();

            if (factory.externalaudit.id != params.externalauditId)
            {
                factory.emptyExternalAudit();
                var hits = $filter('filter')(factory.externalaudits, {'id': params.externalauditId});
                if (hits.length == 1)
                {
                    factory.externalaudit = hits[0];
                    factory.externalaudit.$get(_.omit(params, ['documentId', 'hearingId']), function (ea)
                    {
                        // params contains documentId, so we can't user params directly.
                        factory.documents = Document.query(_.omit(params, ['documentId', 'hearingId']), function (ds)
                        {
                            deferredDocuments.resolve(ds);
                        });
                        deferredExternalAudit.resolve(ea);
                    });
                }
            }
            else
            {
                deferredExternalAudit.resolve(factory.eiapermit);
                deferredDocuments.resolve(factory.documents);
            }

            return [deferredExternalAudit.promise, deferredDocuments.promise];
        };

        factory.retrieveDocument = function (params)
        {
            var deferredDocument = $q.defer();
            var deferredHearings = $q.defer();

            if (factory.document.id != params.documentId)
            {
                factory.emptyDocument();
                var hits = $filter('filter')(factory.documents, {'id': params.documentId});
                if (hits.length == 1)
                {
                    factory.document = hits[0];

                    factory.document.$get(_.omit(params, ['hearingId']), function (d)
                    {
                        factory.hearings = Hearing.query(_.omit(params, ['hearingId']), function (hs)
                        {
                             deferredHearings.resolve(hs);
                        });

                        deferredDocument.resolve(d);
                    });
                }
            }
            else
            {
                deferredDocument.resolve(factory.document);
                deferredHearings.resolve(factory.hearings);
            }
            return [deferredDocument.promise, deferredHearings.promise];
        };

        factory.retrieveHearing = function (params)
        {
            var deferredHearing = $q.defer();

            if (factory.hearing.id != params.hearingId)
            {
                factory.emptyHearing();
                var hits = $filter('filter')(factory.hearings, {'id': params.hearingId});
                if (hits.length == 1)
                {
                    factory.hearing = hits[0];
                    factory.hearing.$get(params, function (h)
                    {
                        deferredHearing.resolve(h);
                    });
                }
            }
            else
            {
                deferredHearing.resolve(factory.hearing);
            }
            return [deferredHearing.promise];
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
            //if (currentTab == ProjectTabEnum.AuditsInspections)
            //{
            //    return p.title + " (Performance: " + factory.getCodeFromValuelist("grade", p.grade) + ")";
            //}
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
            // Example: "Number 2015.033 (Baseline inspection): Created".
            var reason = factory.getCodeFromValuelist("audit_inspection_reason", ai.reason);
            var status = factory.getCodeFromValuelist("auditinspectionstatus", ai.status);
            return "Number " + ai.code + " (" + reason + "): " + status;
        };

        factory.getCodeFromValuelist = function (valuelistName, id)
        {
            if (typeof id === "string")
            {
                id = parseInt(id);
            }
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
            factory.emptyEiaPermit();
            factory.auditsinspections = [];
            factory.auditinspection = {};
        };

        factory.emptyEiaPermit = function ()
        {
            factory.eiapermit = {};
            factory.documents = [];
            factory.emptyDocument();
        };

        factory.emptyDocument = function ()
        {
            factory.document = {};
            factory.hearings = [];
            factory.emptyHearing();
        };

        factory.emptyHearing = function ()
        {
            factory.hearing = {};
        };

        factory.createNewProject = function (o)
        {
            var pData =
            {
                has_industrial_waste_water: 42, // 42=Unknown
                organisation_id: o.id,
                risk_level: 96, // 96=Unknown
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
                inspection_recommended: 42, // Unknown
                is_new: true
            };
            factory.eiapermit = new EiaPermit(epData);
            factory.eiaspermits.push(factory.eiapermit);
            factory.documents = [];
        };

        factory.createNewDocument = function (ep)
        {
            var dData =
            {
                eia_permit_id: ep.id,
                director_copy_no: 1,
                is_new: true
            };
            factory.document = new Document(dData);
            factory.documents.unshift(factory.document);
            factory.hearings = [];
        };

        factory.createNewHearing = function (d)
        {
            var hData =
                {
                    document_id: d.id,
                    is_new: true
                };
            factory.hearing = new Hearing(hData);
            factory.hearings.unshift(factory.hearing);
        };

        factory.deleteEiaPermit = function (params)
        {
            var index = _.findIndex(factory.eiaspermits, {'id': factory.eiapermit.id});
            var onDelete = function (index)
            {
                factory.eiaspermits.splice(index, 1);
                factory.eiapermit = {};
            };
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
            var deferred = $q.defer();

            var onDelete = function (index)
            {
                factory.documents.splice(index, 1);
                factory.document = {};
            };
            if (factory.document.is_new)
            {
                onDelete(0);
            }
            else
            {
                var index = _.findIndex(factory.documents, {'id': factory.document.id});
                factory.document.$delete(params, function ()
                {
                    onDelete(index);
                    deferred.resolve();
                });
            }

            return deferred.promise;
        };

        factory.deleteHearing = function (params)
        {
            var deferred = $q.defer();

            var onDelete = function (index)
            {
                factory.hearings.splice(index, 1);
                factory.hearing = {};
            };
            if (factory.hearing.is_new)
            {
                onDelete(0);
            }
            else
            {
                var index = _.findIndex(factory.hearings, {'id': factory.hearing.id});
                factory.hearing.$delete(params, function ()
                {
                    onDelete(index);
                    deferred.resolve();
                });
            }

            return deferred.promise;
        };

        factory.createNewAuditInspection = function (p, year, type, reason, dateCarriedOut)
        {
            var aiData =
            {
                project_id: p.id,
                year: year,
                type: type,
                reason: reason,
                date_carried_out: dateCarriedOut,
                days: 1,
                status: 70, // 70=Created
                performance_level: 47, // 47=Unknown
                lead_officer: factory.userinfo.info.id,
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

        factory.deleteProject = function (params)
        {
            var deferred = $q.defer();

            var onDelete = function ()
            {
                factory.project = {};
                deferred.resolve();
            };

            if (factory.project.is_new)
            {
                onDelete();
            }
            else
            {
                factory.project.$delete(params, function ()
                {
                    onDelete();
                });
            }

            return deferred.promise;
        };


        factory.save = function (params, resource)
        {
            var deferred = $q.defer();
            if (resource.is_new)
            {
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