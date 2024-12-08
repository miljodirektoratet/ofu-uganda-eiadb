'use strict';

controllers.controller('EiasPermitsTabsController', ['$scope', '$location', 'ProjectFactory', function (scope, location, ProjectFactory)
{
    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.EiasPermitsTabEnum = EiasPermitsTabEnum;

    scope.parts =
        {
            eiapermits: {
                state: SavingStateEnum.None
            },
            eiapermit: {
                form: null,
                state: SavingStateEnum.None
            },
            documents: {
                state: SavingStateEnum.None
            },
            document: {
                form: null,
                state: SavingStateEnum.None
            },
            hearings: {
                state: SavingStateEnum.None
            },
            hearing: {
                form: null,
                state: SavingStateEnum.None
            }
        };

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "hearings"))
        {
            return EiasPermitsTabEnum.Hearings;
        }
        if (_.contains(path, "documents"))
        {
            return EiasPermitsTabEnum.Documents;
        }
        return EiasPermitsTabEnum.EiaPermit;
    };
    scope.eptab = getCurrentTab(location.path());

    scope.preventClickIfDisabled = function(isDisabled, $event)
    {
        if (isDisabled)
        {
            $event.preventDefault();
        }
    };

    scope.stopPropagation = function($event)
    {
        $event.stopPropagation();
    };

    scope.openEiapermit = function(id, $event)
    {
        if (scope.routeParams.eiapermitId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits");
        }
        else if (!scope.routeParams.eiapermitId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + id);
        }
    };

    scope.openEiapermitDocument = function(id, $event)
    {
        if (scope.routeParams.documentId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents");

        }
        else if (!scope.routeParams.documentId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" + id);
        }
    };

    scope.openEiapermitDocumentHearing = function(id, $event)
    {
        if (scope.routeParams.hearingId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" + scope.data.document.id + "/hearings");

        }
        else if (!scope.routeParams.hearingId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + scope.data.eiapermit.id + "/documents/" + scope.data.document.id + "/hearings/" + id);
        }
    };



    scope.isDocumentsDisabled = function(number)
    {
        if (scope.isDisabled(number))
        {
            // console.log("isdisabled", number);
            return true;
        }
        if (scope.parts.documents.state == SavingStateEnum.Loading)
        {
            // console.log("is loading", number);
            return true;
        }
        // console.log("not disabled", number);
        return false;
    };

    scope.isHearingsDisabled = function(number)
    {
        if (scope.isDisabled(number))
        {
            return true;
        }
        if (scope.parts.hearings.state == SavingStateEnum.Loading)
        {
            return true;
        }
        return false;
    };

    scope.isDisabled = function(number)
    {
        return _.isUndefined(number);
    };

    scope.downloadFileUrl = function (id)
    {
        return "/file/v1/download/" + id;
    };

    scope.updateStatus = function (ep)
    {
        var updated = updateEiaPermitStatus(ep, scope.data.documents);
        // console.log(updated, scope.data.documents);
        if (updated)
        {
            if (scope.parts.eiapermit.form)
            {
                scope.parts.eiapermit.form.$setDirty();
            }
        }
        return updated;
    };

    scope.loadEiaPermitWithDocuments = function()
    {
        scope.parts.eiapermit.state = SavingStateEnum.Loading;
        scope.parts.documents.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveEiaPermit(scope.routeParams);
        promises[0].then(function (ep)
        {
            scope.parts.eiapermit.state = SavingStateEnum.Loaded;
        });
        promises[1].then(function (ds)
        {
            scope.parts.documents.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.eiapermits.state = SavingStateEnum.Loading;
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[2].then(function (eps)
    {
        scope.parts.eiapermits.state = SavingStateEnum.Loaded;

        // Get eiapermit if we got an eiapermitId.
        if (!_.isUndefined(scope.routeParams.eiapermitId))
        {
            scope.loadEiaPermitWithDocuments();
        }
    });
}]);