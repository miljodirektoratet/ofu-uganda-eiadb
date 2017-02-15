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
            case "hearing.remarks":
                return scope.userinfo.info.role_3;
            default:
                return false;
        }
    };

    scope.loadHearing = function()
    {
        scope.parts.hearing.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveHearing(scope.routeParams);
        promises[0].then(function (h)
        {
            scope.parts.hearing.state = SavingStateEnum.Loaded;
        });
    };

    // Feels strange to have to load this, but we need to if one goes directly to hearing url.
    scope.loadDocumentWithHearings = function()
    {
        scope.parts.document.state = SavingStateEnum.Loading;
        scope.parts.hearings.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveDocument(scope.routeParams);
        promises[0].then(function (d)
        {
            scope.parts.document.state = SavingStateEnum.Loaded;
        });
        promises[1].then(function (hs)
        {
            scope.parts.hearings.state = SavingStateEnum.Loaded;

            // Get hearing if we got an hearingId.
            if (!_.isUndefined(scope.routeParams.hearingId))
            {
                scope.loadHearing();
            }
        });
    };

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