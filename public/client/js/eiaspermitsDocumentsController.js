'use strict';

controllers.controller('EiasPermitsDocumentsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', 'EiaPermitSearch', function (scope, ProjectFactory, $timeout, Upload, $q, location, EiaPermitSearch) {
    scope.failedToSendMail = false;
    scope.listNumberAlreadyExists = false;
    scope.ep = scope.data.eiapermit;
    scope.documentCode = '';

    scope.shouldShowDocument = function (d) {
        if (scope.parts.document.state == SavingStateEnum.Loading) {
            return false;
        }
        if (scope.routeParams.documentId == d.id) {
            return true;
        }
        return false;
    };

    scope.moveButton = {};

    scope.moveDocument = function () {
        scope.moveButton.error = "";

        // Check if id is ok to move to
        EiaPermitSearch.query({ eiapermit_id: scope.moveButton.id }, function (rows) {
            // Ok.
            if (rows.length >= 1) {
                var projectId = rows[0].project_id;
                var eiaId = rows[0].eiapermit_id;
                var documentId = scope.data.document.id;
                ProjectFactory.moveDocument(scope.routeParams, scope.moveButton.id).then(function () {
                    scope.updateStatusBasedOnDocument();
                    scope.goto("/projects/" + projectId + "/eiaspermits/" + eiaId + "/documents/" + documentId);
                });
            }
            // Not ok.
            else {
                scope.moveButton.error = "Not a valid EIA ID.";
            }
        });
    };

    scope.updateStatusBasedOnDocument = function () {
        // Status has changed, make sure to update ep as well.
        if (scope.updateStatus(scope.data.eiapermit)) {
            scope.data.eiapermit.$update(scope.routeParams, function (ep) {
                // console.log("alt vel eiapermit");
            }, function () {
                // console.log("feilet eiapermit");
            });


            // scope.saveCurrent(scope.parts.eiapermit, scope.data.eiapermit, false).then(function (ep)
            // {
            //     console.log("Finished saving eiapermit");
            // });
        }
    };

    scope.saveCurrentDocument = function (document) {
        if (scope.listNumberAlreadyExists) {
            return false;
        }
        var isNew = document.is_new;

        scope.saveCurrent(scope.parts.document, document).then(function (d) {
            scope.updateStatusBasedOnDocument();

            if (isNew) {
                scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" + d.id);
            }
        });
    };

    scope.newDocument = function () {
        scope.parts.document.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewDocument(scope.data.eiapermit);
    };

    scope.deleteDocument = function () {
        ProjectFactory.deleteDocument(scope.routeParams).then(function () {
            scope.updateStatusBasedOnDocument();
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents");
        });
    };

    scope.uploadAttachment = function (files) {
        if (!files) {
            return;
        }
        scope.showUploadingAttachment = true;
        scope.attachmentFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.document.form.attachment, scope.attachmentFile);

        promise.then(function (file) {
            scope.data.document.file_metadata_id = file.result.id;
            scope.parts.document.form.attachment.$setDirty();
            scope.saveCurrentDocument(scope.data.document);
        }, function (reason) {
        });
    };

    scope.uploadResponseDocument = function (files) {
        if (!files) {
            return;
        }
        scope.showUploadingResponseDocument = true;
        scope.responseDocumentFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.document.form.response_document, scope.responseDocumentFile);

        promise.then(function (file) {
            scope.data.document.file_metadata_response_id = file.result.id;
            scope.parts.document.form.response_document.$setDirty();
            scope.saveCurrentDocument(scope.data.document);
        }, function (reason) {
        });
    };

    scope.deleteAttachment = function () {
        scope.showUploadingAttachment = false;
        scope.data.document.file_metadata_id = null;
        scope.parts.document.form.attachment.$setDirty();
        scope.saveCurrentDocument(scope.data.document);
    };

    scope.deleteResponseDocument = function () {
        scope.showUploadingResponseDocument = false;
        scope.data.document.file_metadata_response_id = null;
        scope.parts.document.form.response_document.$setDirty();
        scope.saveCurrentDocument(scope.data.document);
    };

    scope.calculateNumberOfCopiesOfDocument = function () {
        scope.data.document.director_copy_no = 1;
        scope.data.document.coordinator_copy_no = scope.data.document.sub_copy_no - 1;
    };

    scope.calculateDocumentCode = function () {
        var typeObject = _.find(scope.valuelists["documenttype"], { 'id': parseInt(scope.data.document.type) });
        var documentId = scope.data.document.id;
        var typeCode = typeObject ? typeObject.description1 : "";
        var number = scope.data.document.number ? scope.data.document.number : "";
        var documentCode = typeCode + number;
        fetch('/api/v1/document/code-check/' + documentCode)
            .then(function (response) {
                return response.json();
            })
            .then(function (response) {
                scope.$apply(function () {
                    if (!response.code_exists || (response.code_exists && documentId == response.document_id)) {
                        scope.listNumberAlreadyExists = false;
                        scope.data.document.code = documentCode;
                        scope.setDefaultDocumentConclusion();
                    } else {
                        scope.documentCode = documentCode;
                        scope.listNumberAlreadyExists = true;
                    }
                })
            });
    };

    scope.setDefaultDocumentConclusion = function () {
        // 8 = Project Briefs
        // 9 = TORs for EIA
        // 80 = Pending conclusion
        // 81 = Not relevant
        if (_.indexOf(['8', '9'], scope.data.document.type) >= 0) {
            scope.data.document.conclusion = 80;
        }
        else {
            scope.data.document.conclusion = 81;
        }
    };

    scope.getEmailerObj = function (doc) {
        var index = (doc.email_order && doc.email_order.order_status) ? doc.email_order.order_status : 0;
        return window.emailerStatusObj[index];
    }

    scope.createEmailOrder = function (orderType, entityId, documentId, ep) {
        scope.data.document.email_order = {};
        scope.data.document.email_order.order_status = 1;
        window.createEmailOrder(orderType, entityId, documentId, function (response) {
            scope.$apply(function () {
                if (response.order_status == 0) {
                    scope.data.document.email_order = null;
                    scope.failedToSendMail = true;
                } else {
                    scope.data.document.email_order = response;
                } x

            })
        });
    }

    scope.isDisabledBasedOnRule = function (field) {
        // 81 = Not relevant
        switch (field) {
            case "document.conclusion":
                return scope.data.document.conclusion == 81 && scope.data.document.type != 9 && scope.data.document.type != 8;

            case "document.type":
                return scope.data.document.type == 10;
            default:
                return false;
        }
    };

    scope.auth.canSave = function (field) {
        if (scope.data.document.is_new && scope.parts.document.state == SavingStateEnum.SavingStarted) {
            return false;
        }

        switch (field) {
            case "new":
            case "delete":
                return scope.userinfo.info.role_1;
            case "can_email":
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
                return scope.userinfo.info.role_1;
            case "document.date_sent_officer":
            case "document.remarks_team_leader":
                return scope.userinfo.info.role_2;
            case "document.file_metadata_response_id":
            case "document.conclusion":
            case "document.date_conclusion":
            case "document.remarks":
                return scope.userinfo.info.role_3;
            case "document.remarks_director":
            case "document.date_sent_from_dep":
                return scope.userinfo.info.role_5;
            case "move":
                return scope.userinfo.info.role_8;
            default:
                return false;
        }
    };

    scope.loadDocumentWithHearings = function () {
        scope.parts.document.state = SavingStateEnum.Loading;
        scope.parts.hearings.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveDocument(scope.routeParams);
        promises[0].then(function (d) {
            scope.parts.document.state = SavingStateEnum.Loaded;
        });
        promises[1].then(function (hs) {
            scope.parts.hearings.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.document == SavingStateEnum.Loading;// WHAT IS THIS???
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[2].then(function (eps) {
        // Finished retrieving eiapermits.
        var promises2 = ProjectFactory.retrieveEiaPermit(scope.routeParams);
        promises2[1].then(function (ds) {
            // Finished retrieving documents.
            scope.parts.documents.state = SavingStateEnum.Loaded;

            // Get document if we got an documentId.
            if (!_.isUndefined(scope.routeParams.documentId)) {
                scope.loadDocumentWithHearings();
            }
        });
    });

}]);