'use strict';

controllers.controller('ExternalAuditsDocumentsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', 'ExternalAuditSearch', function (scope, ProjectFactory, $timeout, Upload, $q, location, ExternalAuditSearch)
{
    scope.shouldShowDocument = function(d)
    {
        if (scope.parts.document.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.documentId==d.id)
        {
            return true;
        }
        return false;
    };

    scope.moveButton = {};

    scope.moveDocument = function()
    {
        scope.moveButton.error = "";

        // Check if id is ok to move to
        ExternalAuditSearch.query({externalaudit_id: scope.moveButton.id}, function (rows)
        {
            // Ok.
            if (rows.length >= 1)
            {
                var projectId = rows[0].project_id;
                var eaId = rows[0].externalaudit_id;
                var documentId = scope.data.document_ea.id;
                console.log(projectId, eaId, documentId);
                ProjectFactory.moveDocumentEA(scope.routeParams, scope.moveButton.id).then(function()
                {
                    scope.updateStatusBasedOnDocument();
                    scope.goto("/projects/" + projectId + "/externalaudits/" + eaId + "/documents/" + documentId );
                });
            }
            // Not ok.
            else
            {
                scope.moveButton.error = "Not a valid EA ID.";
            }
        });
    };

    scope.updateStatusBasedOnDocument = function()
    {
        // Status has changed, make sure to update ep as well.
        if (scope.updateStatus(scope.data.externalaudit))
        {
            scope.data.externalaudit.$update(scope.routeParams, function (ep)
            {
                // console.log("alt vel externalaudit");
            }, function ()
            {
                // console.log("feilet externalaudit");
            });


            // scope.saveCurrent(scope.parts.externalaudit, scope.data.externalaudit, false).then(function (ep)
            // {
            //     console.log("Finished saving externalaudit");
            // });
        }
    };

    scope.saveCurrentDocument = function (document)
    {
        var isNew = document.is_new;

        scope.saveCurrent(scope.parts.document, document).then(function (d)
        {
            scope.updateStatusBasedOnDocument();

            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + scope.data.externalaudit.id + "/documents/" + d.id);
            }
        });
    };

    scope.newDocument = function ()
    {
        scope.parts.document.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewDocumentEA(scope.data.externalaudit);
    };

    scope.deleteDocument = function ()
    {
        ProjectFactory.deleteDocumentEA(scope.routeParams).then(function()
        {
            scope.updateStatusBasedOnDocument();
            scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + scope.data.externalaudit.id + "/documents");
        });
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
            scope.data.document_ea.file_metadata_id = file.result.id;
            scope.parts.document.form.attachment.$setDirty();
            scope.saveCurrentDocument(scope.data.document_ea);
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
            scope.data.document_ea.file_metadata_response_id = file.result.id;
            scope.parts.document.form.response_document.$setDirty();
            scope.saveCurrentDocument(scope.data.document_ea);
        }, function (reason)
        {
        });
    };

    scope.deleteAttachment = function ()
    {
        scope.showUploadingAttachment = false;
        scope.data.document_ea.file_metadata_id = null;
        scope.parts.document.form.attachment.$setDirty();
        scope.saveCurrentDocument(scope.data.document_ea);
    };

    scope.deleteResponseDocument = function ()
    {
        scope.showUploadingResponseDocument = false;
        scope.data.document_ea.file_metadata_response_id = null;
        scope.parts.document.form.response_document.$setDirty();
        scope.saveCurrentDocument(scope.data.document_ea);
    };

    scope.calculateNumberOfCopiesOfDocument = function ()
    {
        scope.data.document_ea.director_copy_no = 1;
        scope.data.document_ea.coordinator_copy_no = scope.data.document_ea.sub_copy_no - 1;
    };

    scope.calculateDocumentCode = function ()
    {
        var typeObject = _.find(scope.valuelists["documenttypeexternalaudits"], {'id': parseInt(scope.data.document_ea.type)});
        var typeCode = typeObject ? typeObject.description1 : "";
        var number = scope.data.document_ea.number ? scope.data.document_ea.number : "";
        scope.data.document_ea.code = typeCode + number;
    };

    scope.setDefaultDocumentConclusion = function ()
    {
        // 11 = TORs for EA
        // 80 = Pending conclusion
        // 81 = Not relevant
        if (_.indexOf(['11'], scope.data.document_ea.type) >= 0)
        {
            scope.data.document_ea.conclusion = 80;
        }
        else
        {
            scope.data.document_ea.conclusion = 81;
        }
    };

    scope.isDisabledBasedOnRule = function (field)
    {
        // 81 = Not relevant
        switch (field)
        {
            case "document.conclusion":
                return scope.data.document_ea.conclusion == 81;
            case "document.type":
                return scope.data.document_ea.type == 12;
            default:
                return false;
        }
    };

    scope.auth.canSave = function (field)
    {
        if (scope.data.document_ea.is_new && scope.parts.document.state == SavingStateEnum.SavingStarted)
        {
            return false;
        }

        switch (field)
        {
            case "new":
            case "delete":
                return scope.userinfo.info.role_1;
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
            case "document.folio_no":
            case "document.remarks":
                return scope.userinfo.info.role_1;
            case "document.date_sent_officer":
                return scope.userinfo.info.role_2;
            case "document.file_metadata_response_id":
            case "document.conclusion":
            case "document.date_conclusion":
                return scope.userinfo.info.role_3;
            case "document.date_sent_from_dep":
                return scope.userinfo.info.role_5;
            case "move":
                return scope.userinfo.info.role_8;
            default:
                return false;
        }
    };

    scope.loadDocument = function()
    {
        scope.parts.document.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveDocumentEA(scope.routeParams);
        promises[0].then(function (d)
        {
            scope.parts.document.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.document == SavingStateEnum.Loading;// WHAT IS THIS???
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[5].then(function (eas)
    {
        // Finished retrieving externalaudits.

        var promises2 = ProjectFactory.retrieveExternalAudit(scope.routeParams);
        promises2[1].then(function (ds)
        {
            // Finished retrieving documents.

            scope.parts.documents.state = SavingStateEnum.Loaded;

            // Get document if we got an documentId.
            if (!_.isUndefined(scope.routeParams.documentId))
            {
                scope.loadDocument();
            }
        });
    });

}]);