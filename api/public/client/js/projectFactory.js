'use strict';
var data1 = {};
services.factory('ProjectFactory', ['$q', '$filter', 'Project', 'Organisation', 'EiaPermit', 'Document', 'Hearing', 'ExternalAudit', 'DocumentEA', 'AuditInspection', 'Valuelists', 'UserInfo', 'PermitLicense',
    function ($q, $filter, Project, Organisation, EiaPermit, Document, Hearing, ExternalAudit, DocumentEA, AuditInspection, Valuelists, UserInfo, PermitLicense)
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

        factory.permitslicenses = [];
        factory.permitlicense = {};

        factory.externalaudits = [];
        factory.externalaudit = {};
        factory.documents_ea = [];
        factory.document_ea = {};

        factory.auditsinspections = [];
        factory.auditinspection = {};

        factory.valuelists = Valuelists;
        factory.userinfo = UserInfo;

        factory.hasData =
            {
                eiapermits: false,
                eiapermit: false,
                documents: false,
                document: false,
                hearings: false,
                hearing: false,
                permitslicenses: false,
                permitlicense: false,
                externalaudits: false,
                externalaudit: false,
                documents_ea: false,
                document_ea: false
            };


        factory.retrieveProjectData = function (params)
        {
            var deferredProject = $q.defer();
            var deferredOrganisation = $q.defer();
            var deferredEiasPermits = $q.defer();
            var deferredExternalAudits = $q.defer();
            var deferredAuditsInspections = $q.defer();
            var deferredPermitsLicenses = $q.defer();

            if (factory.project.id != params.projectId)
            {
                var simpleParams = _.omit(params,  ['eiapermitId', 'externalauditId',  'documentId', 'hearingId', 'permitlicenseId', 'auditinspectionId']);
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

                factory.permitslicenses = PermitLicense.query(simpleParams, function (pls)
                {
                    deferredPermitsLicenses.resolve(pls);
                });

                factory.externalaudits = ExternalAudit.query(simpleParams, function (eas)
                {
                    deferredExternalAudits.resolve(eas);
                });

                factory.auditsinspections = AuditInspection.query(simpleParams, function (ais)
                {
                    deferredAuditsInspections.resolve(ais);
                });
            }
            else
            {
                // Clean up possible unsaved children.
                _.remove(factory.permitslicenses, function(item) {return item.is_new;});

                deferredProject.resolve(factory.project);
                deferredOrganisation.resolve(factory.organisation);
                deferredEiasPermits.resolve(factory.eiaspermits);
                deferredPermitsLicenses.resolve(factory.permitslicenses);
                deferredExternalAudits.resolve(factory.externalaudits);
                deferredAuditsInspections.resolve(factory.auditsinspections);
            }
            return [deferredProject.promise, deferredOrganisation.promise,
                deferredEiasPermits.promise,
                deferredAuditsInspections.promise, deferredPermitsLicenses.promise, deferredExternalAudits.promise];
        };

        factory.retrieveEiaPermit = function (params)
        {
            var deferredEiaPermit = $q.defer();
            var deferredDocuments = $q.defer();

            if (factory.eiapermit.id != params.eiapermitId)
            {
                factory.emptyEiaPermit();
                var hits = _.where(factory.eiaspermits, {'id': parseInt(params.eiapermitId)});
                if (hits.length == 1)
                {
                    factory.eiapermit = hits[0];
                    factory.eiapermit.$get(_.omit(params, ['documentId', 'hearingId']), function (ep)
                    {
                        deferredEiaPermit.resolve(ep);
                        // params contains documentId, so we can't user params directly.
                        factory.documents = Document.query(_.omit(params, ['documentId', 'hearingId']), function (ds)
                        {
                            deferredDocuments.resolve(ds);
                        });

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

        factory.retrieveDocument = function (params)
        {
            var deferredDocument = $q.defer();
            var deferredHearings = $q.defer();

            if (factory.document.id != params.documentId)
            {
                factory.emptyDocument();
                var hits = _.where(factory.documents, {'id': parseInt(params.documentId)});
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
                var hits = _.where(factory.hearings, {'id': parseInt(params.hearingId)});
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

        factory.retrieveExternalAudit = function (params)
        {
            var deferredExternalAudit = $q.defer();
            var deferredDocuments = $q.defer();

            if (factory.externalaudit.id != params.externalauditId)
            {
                factory.emptyExternalAudit();
                var hits = _.where(factory.externalaudits, {'id': parseInt(params.externalauditId)});
                if (hits.length == 1)
                {
                    factory.externalaudit = hits[0];
                    factory.externalaudit.$get(_.omit(params, ['documentId']), function (ea)
                    {
                        // params contains documentId, so we can't user params directly.
                        factory.documents_ea = DocumentEA.query(_.omit(params, ['documentId']), function (ds)
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

        factory.retrieveDocumentEA = function (params)
        {
            var deferredDocument = $q.defer();

            if (factory.document.id != params.documentId)
            {
                factory.emptyDocumentEA();
                var hits = _.where(factory.documents_ea, {'id': parseInt(params.documentId)});
                if (hits.length == 1)
                {
                    factory.document_ea = hits[0];

                    factory.document_ea.$get(_.omit(params, ['hearingId']), function (d)
                    {
                        deferredDocument.resolve(d);
                    });
                }
            }
            else
            {
                deferredDocument.resolve(factory.document_ea);
            }
            return [deferredDocument.promise];
        };

        factory.retrieveAuditInspection = function (params)
        {
            var deferred = $q.defer();
            if (params.auditinspectionId)
            {
                var hits = _.where(factory.auditsinspections, {'id': parseInt(params.auditinspectionId)});
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
            return [deferred.promise];
        };

        factory.retrievePermitLicense = function (params)
        {
            data1 = factory.permitslicenses;
            var deferred = $q.defer();
            if (params.permitlicenseId)
            {
                var hits = _.where(factory.permitslicenses, {'id': parseInt(params.permitlicenseId)});
                if (hits.length == 1)
                {
                    factory.permitlicense = hits[0];
                    factory.permitlicense.$get(params, function (pl)
                    {
                        deferred.resolve(pl);
                    });
                }
            }
            return [deferred.promise];
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
            factory.emptyExternalAudit();
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

        factory.emptyExternalAudit = function ()
        {
            factory.externalaudit = {};
            factory.documents_ea = [];
            factory.emptyDocumentEA();
        };

        factory.emptyDocumentEA = function ()
        {
            factory.document_ea = {};
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

        factory.moveDocument = function (params, newEiaId)
        {
            var deferred = $q.defer();

            var onMove = function (index)
            {
                factory.documents.splice(index, 1);
                factory.document = {};
            };

            var index = _.findIndex(factory.documents, {'id': factory.document.id});
            factory.document.eia_permit_id = newEiaId;
            factory.document.$update(params, function (data)
            {
                onMove(index);
                deferred.resolve(data);
            }, function ()
            {
                deferred.reject("Moving failed");
            });

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

        factory.createNewExternalAudit = function (p)
        {
            var eaData =
                {
                    project_id: p.id,
                    //inspection_recommended: 42, // Unknown
                    is_new: true
                };
            factory.externalaudit = new ExternalAudit(eaData);
            factory.externalaudits.push(factory.externalaudit);
            factory.documents_ea = [];
        };

        factory.createNewDocumentEA = function (ea)
        {
            var dData =
                {
                    external_audit_id: ea.id,
                    director_copy_no: 1,
                    is_new: true
                };
            // console.log(dData);
            factory.document_ea = new DocumentEA(dData);
            factory.documents_ea.unshift(factory.document_ea);
        };

        factory.deleteExternalAudit = function (params)
        {
            var index = _.findIndex(factory.externalaudits, {'id': factory.externalaudit.id});
            var onDelete = function (index)
            {
                factory.externalaudits.splice(index, 1);
                factory.externalaudit = {};
            };
            if (factory.externalaudit.is_new)
            {
                onDelete(index);
            }
            else
            {
                factory.externalaudit.$delete(params, function ()
                {
                    onDelete(index);
                });
            }
        };

        factory.deleteDocumentEA = function (params)
        {
            var deferred = $q.defer();

            var onDelete = function (index)
            {
                factory.documents_ea.splice(index, 1);
                factory.document_ea = {};
            };
            if (factory.document_ea.is_new)
            {
                onDelete(0);
            }
            else
            {
                var index = _.findIndex(factory.documents_ea, {'id': factory.document_ea.id});
                factory.document_ea.$delete(params, function ()
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
            };
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

        factory.createNewPermitLicense = function (p, regulation, ecosystem, regulation_activity, area, unit, approved_by_the_lc1, approved_by_the_dec, waste_license_type)
        {
            var plData =
                {
                    project_id: p.id,
                    regulation: regulation,
                    ecosystem: ecosystem,
                    regulation_activity: regulation_activity,
                    area: area,
                    unit: unit,
                    approved_by_the_lc1: approved_by_the_lc1,
                    approved_by_the_dec: approved_by_the_dec,
                    waste_license_type: waste_license_type,
                    is_new: true
                };
            factory.permitlicense = new PermitLicense(plData);
            factory.permitslicenses.push(factory.permitlicense);
        };

        factory.deletePermitLicense = function (params)
        {
            var index = _.findIndex(factory.permitslicenses, {'id': factory.permitlicense.id});
            var onDelete = function (index)
            {
                factory.permitslicenses.splice(index, 1);
                factory.permitlicense = {};
            };
            if (factory.permitlicense.is_new)
            {
                onDelete(index);
            }
            else
            {
                factory.permitlicense.$delete(params, function ()
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