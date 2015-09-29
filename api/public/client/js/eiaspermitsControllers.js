'use strict';

controllers.controller('EiasPermitsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', function (scope, ProjectFactory, $timeout, Upload, $q)
{
    scope.parts =
    {
        eiapermit: {
            form: null,
            state: SavingStateEnum.Loading
        },
        document: {
            form: null,
            state: SavingStateEnum.None
        }
    };

    scope.fileUploadPattern = fileUploadPattern;

    scope.isLoading = function ()
    {
        if (scope.parts.eiapermit.state == SavingStateEnum.Loading)
        {
            if (scope.hasEiaPermit())
            {
                return true;
            }
            return false;
        }
        return scope.parts.eiapermit.state == SavingStateEnum.LoadingNew;
    };

    scope.hasEiaPermit = function ()
    {
        return !_.isEmpty(scope.data.eiapermit);
    };

    scope.saveCurrentEiaPermit = function ()
    {
        var eiapermit = scope.data.eiapermit;
        var isNew = eiapermit.is_new;
        if (!isNew)
        {
            scope.updateStatus(eiapermit);
        }
        scope.saveCurrent(scope.parts.eiapermit, eiapermit, isNew).then(function (ep)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + ep.id);
            }
        });
    };

    scope.saveCurrentDocument = function ()
    {
        var document = scope.data.document;

        scope.saveCurrent(scope.parts.document, document).then(function (d)
        {
            // Status has changed, make sure to update ep as well.
            if (scope.updateStatus(scope.data.eiapermit))
            {
                scope.saveCurrentEiaPermit();
            }
        });
    };

    scope.updateStatus = function (ep)
    {
        if (!scope.userinfo.info.features.notproduction)
        {
            return false;
        }
        //var values = scope.data.valuelists['eiastatus'];
        //var sorted = _.sortBy(values, function (value)
        //{
        //    return value.value1;
        //});
        //sorted.reverse();

        var oldStatus = ep.status;
        var newStatus = null;

        // EP is only criteria.
        if (ep.date_cancelled)
        {
            newStatus = 37;
        }
        else if (ep.certificate_no)
        {
            newStatus = 36;
        }
        else if (ep.fee_receipt_no)
        {
            newStatus = 35;
        }
        else if (ep.date_fee_notification)
        {
            newStatus = 34;
        }
        else if (ep.date_decision)
        {
            newStatus = 33;
        }
        else if (ep.date_sent_ded_approval)
        {
            newStatus = 32;
        }
        // Document is criteria 2.
        else
        {
            var documentsByType = _.groupBy(scope.data.documents, function (document)
            {
                return document.type;
            });
            var newStatusFromDocuments = 0;
            var typePriority = [13, 10, 9, 8];
            var idFromPriority = {
                13: {'conclusion': 59, 'date_dispatched': 58, 'date_sent_officer': 57, 'date_sent_from_dep': 56, 'date_sent_director': 55, 'date_submitted': 54},
                10: {'date_dispatched': 31, 'date_sent_officer': 30, 'date_sent_from_dep': 29, 'date_sent_director': 28, 'date_submitted': 27},
                9: {'conclusion': 26, 'date_dispatched': 25, 'date_sent_officer': 24, 'date_sent_from_dep': 23, 'date_sent_director': 22, 'date_submitted': 21},
                8: {'conclusion': 20, 'date_dispatched': 19, 'date_sent_officer': 18, 'date_sent_from_dep': 17, 'date_sent_director': 16, 'date_submitted': 15}
            };
            _.forEach(typePriority, function (type)
            {
                var documents = documentsByType[type];
                if (documents)
                {
                    var tempStatus = 0;
                    _.forEach(documents, function (d)
                    {
                        // Only conclusion if Accepted (78) or Not accepted (79)
                        if (d.conclusion && _.includes([78, 79], d.conclusion) && idFromPriority[type]['conclusion'])
                        {
                            tempStatus = idFromPriority[type]['conclusion'];
                        }
                        //else if(d.dispatched)
                        //{
                        //    newStatus = idFromPriority[type]['dispatched'];
                        //}
                        else if (d.date_sent_officer)
                        {
                            tempStatus = idFromPriority[type]['date_sent_officer'];
                        }
                        else if (d.date_sent_from_dep)
                        {
                            tempStatus = idFromPriority[type]['date_sent_from_dep'];
                        }
                        else if (d.date_sent_director)
                        {
                            tempStatus = idFromPriority[type]['date_sent_director'];
                        }
                        else if (d.date_submitted)
                        {
                            tempStatus = idFromPriority[type]['date_submitted'];
                        }

                        if (tempStatus > newStatusFromDocuments)
                        {
                            newStatusFromDocuments = tempStatus;
                        }
                    });

                    return false;
                }
            });
            //console.log("newStatusFromDocuments", newStatusFromDocuments);
            if (newStatusFromDocuments > 0)
            {
                newStatus = newStatusFromDocuments;
            }
        }

        if (oldStatus != newStatus)
        {
            //console.log("Status changed from", oldStatus, "to", newStatus);
            scope.parts.eiapermit.form.status.$setDirty();
            ep.status = newStatus;
            return true;
        }

        //console.log("Status not changed", oldStatus, newStatus);
        return false;
    };

    scope.newEiaPermit = function ()
    {
        scope.parts.eiapermit.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewEiaPermit(scope.data.project);
        scope.parts.eiapermit.isNew = true;
        scope.saveCurrentEiaPermit();
    };

    scope.newDocument = function ()
    {
        ProjectFactory.createNewDocument(scope.data.eiapermit);
        //scope.toggleDocument(scope.data.document);
    }

    scope.deleteEiaPermit = function ()
    {
        ProjectFactory.deleteEiaPermit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id);
    }

    scope.toggleDocument = function (d)
    {
        scope.showUploadingAttachment = false;
//    if (scope.loading)
//    {
//      //console.log("Currently loading. Please wait.");
//      return;
//    }
        if (scope.data.document == d)
        {
            scope.data.document = {};
            scope.parts.document.state = SavingStateEnum.None;
        }
        else
        {
            if (d.is_new)
            {
                scope.data.document = d;
            }
            else
            {
                d.$get(scope.routeParams, function (d)
                {
                    scope.data.document = d;
                });
            }
        }
    };

    scope.calculateNumberOfCopiesOfDocument = function ()
    {
        scope.data.document.director_copy_no = 1;
        scope.data.document.coordinator_copy_no = scope.data.document.sub_copy_no - 1;
    };

    scope.calculateDocumentCode = function ()
    {
        var typeObject = _.find(scope.valuelists["documenttype"], {'id': parseInt(scope.data.document.type)});
        var typeCode = typeObject ? typeObject.description1 : "";
        var number = scope.data.document.number ? scope.data.document.number : "";
        scope.data.document.code = typeCode + number;
    };

    scope.setDefaultDocumentConclusion = function ()
    {
        // 8 = Project Briefs
        // 9 = TORs for EIA
        // 80 = Pending conclusion
        // 81 = Not relevant
        if (_.indexOf(['8', '9'], scope.data.document.type) >= 0)
        {
            scope.data.document.conclusion = 80;
        }
        else
        {
            scope.data.document.conclusion = 81;
        }
    };

    scope.auth.canSave = function (field)
    {
        switch (field)
        {
            case "new":
            case "delete":
                return scope.userinfo.info.role_1;
            case "teamleader_id":
            case "practitioner_id":
            case "cost":
            case "cost_currency":
            case "document.date_submitted":
            case "document.sub_copy_no":
            case "document.title":
            case "document.type":
            case "document.number":
            case "document.code":
            case "document.consultent":
            case "document.director_copy_no":
            case "document.date_sent_director":
            case "document.coordinator_copy_no":
            case "document.date_copies_coordinator":
            case "document.date_next_appointment":
            case "document.date_sent_from_dep":
            case "document.folio_no":
            case "document.remarks":
                return scope.userinfo.info.role_1;
            case "user_id":
                return scope.userinfo.info.role_2;
            case "inspection_recommended":
            case "date_inspection":
            case "officer_recommend":
            case "fee":
            case "fee_currency":
            case "remarks":
            case "date_sent_ded_approval":
            case "document.sub_final":
            case "document.date_sent_officer":
                return scope.userinfo.info.role_3;
            case "date_fee_notification":
            case "date_fee_payed":
            case "fee_receipt_no":
                return scope.userinfo.info.role_4;
            case "decision":
            case "date_decision":
            case "designation":
            case "date_certificate":
            case "certificate_no":
            case "date_cancelled":
            case "document.conclusion":
                return scope.userinfo.info.role_5;
            case "status":
                return !scope.userinfo.info.features.notproduction;
            default:
                return false;
        }
    };

    scope.isDisabledBasedOnRule = function (field)
    {
        // 81 = Not relevant
        switch (field)
        {
            case "document.conclusion":
                return scope.data.document.conclusion == 81;
            default:
                return false;
        }
    };

    scope.uploadAttachment = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingAttachment = true;
        scope.attachmentFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.document.form.attachment, scope.attachmentFile);

        promise.then(function (file)
        {
            scope.data.document.file_metadata_id = file.result.id;
            scope.parts.document.form.attachment.$setDirty();
            scope.saveCurrentDocument();
        }, function (reason)
        {
        });
    };

    scope.uploadCertificate = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingCertificate = true;
        scope.certificateFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.eiapermit.form.certificate, scope.certificateFile);

        promise.then(function (file)
        {
            scope.data.eiapermit.file_metadata_id = file.result.id;
            scope.parts.eiapermit.form.certificate.$setDirty();
            scope.saveCurrentEiaPermit();
        }, function (reason)
        {
        });
    };

    scope.downloadFileUrl = function (id)
    {
        return "/file/v1/download/" + id;
    };

    scope.deleteAttachment = function ()
    {
        scope.showUploadingAttachment = false;
        scope.data.document.file_metadata_id = null;
        scope.parts.document.form.attachment.$setDirty();
        scope.saveCurrentDocument();
    };

    scope.deleteCertificate = function ()
    {
        scope.showUploadingCertificate = false;
        scope.data.eiapermit.file_metadata_id = null;
        scope.parts.eiapermit.form.certificate.$setDirty();
        scope.saveCurrentEiaPermit();
    };

    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[2].then(function (eps)
    {
        if (eps.length > 0 && !scope.routeParams.eiapermitId)
        {
            var ep = eps[0];
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + ep.id);
        }
    });
    promises[3].then(function (ep)
    {
        scope.parts.eiapermit.state = SavingStateEnum.Loaded;
    });
}]);