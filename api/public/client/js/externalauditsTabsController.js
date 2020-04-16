'use strict';

controllers.controller('ExternalAuditsTabsController', ['$scope', '$location', 'ProjectFactory', function (scope, location, ProjectFactory)
{
    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.ExternalAuditsTabEnum = ExternalAuditsTabEnum;

    scope.parts =
        {
            externalaudits: {
                state: SavingStateEnum.None
            },
            externalaudit: {
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
            return ExternalAuditsTabEnum.Documents;
        }
        return ExternalAuditsTabEnum.ExternalAudit;
    };
    scope.eatab = getCurrentTab(location.path());

    scope.openExternalaudit = function(id, $event)
    {
        if (scope.routeParams.externalauditId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/externalaudits");

        }
        else if (!scope.routeParams.externalauditId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + id);
        }
    };

    scope.openExternalauditDocument = function(id, $event)
    {
        if (scope.routeParams.documentId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + scope.data.externalaudit.id + "/documents");

        }
        else if (!scope.routeParams.documentId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + scope.data.externalaudit.id + "/documents/" + id);
        }
    };

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

    scope.updateStatus = function (ea)
    {
        var updated = updateExternalAuditStatus(ea, scope.data.documents_ea);
        if (updated)
        {
            if (scope.parts.externalaudit.form)
            {
                scope.parts.externalaudit.form.$setDirty();
            }
        }
        return updated;
    };

    scope.loadExternalAuditWithDocuments = function()
    {
        scope.parts.externalaudit.state = SavingStateEnum.Loading;
        scope.parts.documents.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveExternalAudit(scope.routeParams);
        promises[0].then(function (ea)
        {
            scope.parts.externalaudit.state = SavingStateEnum.Loaded;
        });
        promises[1].then(function (ds)
        {
            scope.parts.documents.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.externalaudits.state = SavingStateEnum.Loading;
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[5].then(function (eas)
    {
        scope.parts.externalaudits.state = SavingStateEnum.Loaded;

        // Get externalaudit if we got an externalauditId.
        if (!_.isUndefined(scope.routeParams.externalauditId))
        {
            scope.loadExternalAuditWithDocuments();
        }
    });
}]);