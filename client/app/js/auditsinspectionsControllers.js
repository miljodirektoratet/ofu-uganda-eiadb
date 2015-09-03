'use strict';

controllers.controller('AuditsInspectionsController', ['$scope', 'ProjectFactory', function (scope, ProjectFactory)
{
    scope.isNewAuditInspection = false;
    scope.parts =
    {
        auditinspection: {
            form: null,
            state: SavingStateEnum.Loading
        }
    };

    scope.hasAuditInspection = function ()
    {
        return !_.isEmpty(scope.data.auditinspection);
    };

    scope.saveCurrentAuditInspection = function ()
    {
        var auditinspection = scope.data.auditinspection;
        scope.saveCurrent(scope.parts.auditinspection, auditinspection).then(function (ai)
        {
            if (scope.isNewAuditInspection)
            {
                scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/" + ai.id);
            }
        });
    };

    scope.deleteAuditInspection = function ()
    {
        ProjectFactory.deleteAuditInspection(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id);
    };

    scope.auth.canSave = function (field)
    {
        return scope.userinfo.info.role_7;
    };

    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[5].then(function (ai)
    {
        scope.parts.auditinspection.state = SavingStateEnum.Loaded;
    });

    if (scope.routeParams.auditinspectionId == "new")
    {
        ProjectFactory.createNewAuditInspection(scope.data.project);
        scope.isNewAuditInspection = true;
        scope.parts.auditinspection.state = SavingStateEnum.Loaded;
        scope.parts.auditinspection.isNew = true;
    }
}]);