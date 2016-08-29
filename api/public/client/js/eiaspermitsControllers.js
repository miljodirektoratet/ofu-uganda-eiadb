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
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

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
        var updated = updateEiaPermitStatus(ep, scope.data.documents);
        if (updated)
        {
            // console.log(scope.parts.eiapermit);
            scope.parts.eiapermit.form.$setDirty();
        }
        return updated;
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
        // Make sure to close any opened documents.
        // scope.data.document = {};

        if (scope.data.document)
        {
            scope.toggleDocument(scope.data.document);
        }

        $timeout(function ()
        {
            ProjectFactory.createNewDocument(scope.data.eiapermit);
        });
    };

    scope.deleteEiaPermit = function ()
    {
        ProjectFactory.deleteEiaPermit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id);
    };

    scope.deleteDocument = function ()
    {
        ProjectFactory.deleteDocument(scope.routeParams);
    };

    scope.toggleDocument = function (d)
    {
        scope.showUploadingAttachment = false;
        scope.showUploadingResponseDocument = false;
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
            case "expected_jobs_created":
                return scope.userinfo.info.role_1;
            case "user_id":
            case "personnel":
            case "document.date_sent_officer":
                return scope.userinfo.info.role_2;
            case "inspection_recommended":
            case "date_inspection":
            case "officer_recommend":
            case "fee":
            case "fee_currency":
            case "remarks":
            case "date_sent_ded_approval":
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
            case "document.date_conclusion":
                return scope.userinfo.info.role_5;
            case "status":
                return false;
//                return !scope.userinfo.info.features.notproduction;
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

    scope.uploadResponseDocument = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingResponseDocument = true;
        scope.responseDocumentFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.document.form.response_document, scope.responseDocumentFile);

        promise.then(function (file)
        {
            scope.data.document.file_metadata_response_id = file.result.id;
            scope.parts.document.form.response_document.$setDirty();
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

    scope.deleteResponseDocument = function ()
    {
        scope.showUploadingResponseDocument = false;
        scope.data.document.file_metadata_response_id = null;
        scope.parts.document.form.response_document.$setDirty();
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