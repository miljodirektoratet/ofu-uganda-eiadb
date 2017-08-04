'use strict';

controllers.controller('PermitsLicensesController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.parts =
        {
            permitslicenses: {
                state: SavingStateEnum.None
            },
            permitlicense: {
                form: null,
                state: SavingStateEnum.None
            },
        };

    scope.shouldShowPermitLicense = function(pl)
    {
        if (scope.parts.permitlicense.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.permitlicenseId==pl.id)
        {
            return true;
        }
        return false;
    };

    scope.saveCurrentPermitLicense = function (permitlicense)
    {
        var isNew = permitlicense.is_new;

        if (!isNew)
        {
            scope.updateStatus(permitlicense);
        }

        scope.saveCurrent(scope.parts.permitlicense, permitlicense, isNew).then(function (pl)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/permitslicenses/" + pl.id);
            }
        });
    };

    scope.newPermitLicense = function ()
    {
        scope.parts.permitlicense.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewPermitLicense(scope.data.project);
    };

    scope.deletePermitLicense = function ()
    {
        ProjectFactory.deleteExternalAudit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/externalaudits");
    };

    scope.auth.canSave = function (field)
    {
        if (scope.data.permitlicense.is_new && scope.parts.permitlicense.state == SavingStateEnum.SavingStarted)
        {
            return false;
        }

        switch (field)
        {
            case "new":
            case "delete":
                return scope.userinfo.info.role_1;
            case "teamleader_id":
            case "practitioner_id":
            case "type":
                return scope.userinfo.info.role_1;
            case "personnel":
                return scope.userinfo.info.role_2;
            case "verification_inspection":
            case "date_inspection":
            case "date_response":
            case "fee":
            case "fee_currency":
            case "remarks":
                return scope.userinfo.info.role_3;
            // case "":
            //     return scope.userinfo.info.role_4;
            case "response":
            case "review_findings":
            case "date_deadline_compliance":
            case "user_id":
                return scope.userinfo.info.role_5;
            case "status":
                return false;
            default:
                return false;
        }
    };

    scope.loadPermitLicense = function()
    {
        scope.parts.permitlicense.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrievePermitLicense(scope.routeParams);
        promises[0].then(function (pl)
        {
            scope.parts.permitlicense.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.permitlicense.state = SavingStateEnum.Loading;
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[4].then(function (pls)
    {
        scope.parts.permitslicenses.state = SavingStateEnum.Loaded;

        // Get permitlicense if we got an permitlicenseId.
        if (!_.isUndefined(scope.routeParams.permitlicenseId))
        {
            scope.loadPermitLicense();
        }
    });
}]);