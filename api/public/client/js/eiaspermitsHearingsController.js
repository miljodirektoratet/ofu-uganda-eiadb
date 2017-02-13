'use strict';

controllers.controller('EiasPermitsHearingsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.shouldShowHearing = function(h)
    {
        if (scope.parts.hearing.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.hearingId==h.id)
        {
            return true;
        }
        return false;
    };

    scope.saveCurrentHearing = function (hearing)
    {
        var isNew = hearing.is_new;

        scope.saveCurrent(scope.parts.hearing, hearing).then(function (h)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" + scope.data.document.id + "/hearings/" + h.id);
            }
        });
    };

    scope.newHearing = function ()
    {
        scope.parts.hearing.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewHearing(scope.data.document);
    };

    scope.deleteHearing = function ()
    {
        ProjectFactory.deleteHearing(scope.routeParams).then(function()
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" +  scope.data.document.id);
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
        var promise = uploadFile($q, $timeout, Upload, scope.parts.hearing.form.attachment, scope.attachmentFile);

        promise.then(function (file)
        {
            scope.data.hearing.file_metadata_id = file.result.id;
            scope.parts.hearing.form.attachment.$setDirty();
            scope.saveCurrentHearing();
        }, function (reason)
        {
        });
    };

    scope.deleteAttachment = function ()
    {
        scope.showUploadingAttachment = false;
        scope.data.hearing.file_metadata_id = null;
        scope.parts.hearing.form.attachment.$setDirty();
        scope.saveCurrentHearing();
    };

    scope.auth.canSave = function (field)
    {
        if (scope.data.hearing.is_new && scope.parts.hearing.state == SavingStateEnum.SavingStarted)
        {
            return false;
        }

        switch (field)
        {
            case "new":
            case "delete":
                return scope.userinfo.info.role_1;
            case "hearing.date_dispatched":
                return scope.userinfo.info.role_1;
            case "document.remarks":
                return scope.userinfo.info.role_3;
            default:
                return false;
        }
    };

    // NEXT

    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[2].then(function (eps)
    {
        // Finished retrieving eiapermits.

        var promises2 = ProjectFactory.retrieveEiaPermit(scope.routeParams);
        promises2[1].then(function (ds)
        {
            // Finished retrieving documents.

            // Get document if we got an documentId.
            if (!_.isUndefined(scope.routeParams.documentId))
            {
                scope.loadDocumentWithHearings();
            }
        });
    });

}]);