'use strict';

var controllers = angular.module('seroApp.controllers');

controllers.controller('AuditsInspectionsController', ['$scope', 'ProjectFactory','$timeout','Upload', function (scope, ProjectFactory, $timeout, Upload)
{
    scope.isNewAuditInspection = false;
    scope.parts =
    {
        auditinspection: {
            form: null,
            state: SavingStateEnum.Loading
        }
    };
    scope.newButton = {};
    scope.newButton.year = new Date().getFullYear();

    scope.hasAuditInspection = function ()
    {
        return !_.isEmpty(scope.data.auditinspection);
    };

    scope.saveCurrentAuditInspection = function ()
    {
        var auditinspection = scope.data.auditinspection;
        scope.saveCurrent(scope.parts.auditinspection, auditinspection, auditinspection.is_new).then(function (ai)
        {
            if (scope.isNewAuditInspection)
            {
                scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/" + ai.id);
            }
        });
    };

    scope.newAuditInspection = function ()
    {
        scope.newButton.isopen = false;

        ProjectFactory.createNewAuditInspection(scope.data.project, scope.newButton.year);
        scope.isNewAuditInspection = true;
        scope.parts.auditinspection.state = SavingStateEnum.Loaded;
        scope.parts.auditinspection.isNew = true;

        scope.saveCurrentAuditInspection();
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

    scope.uploadFiles = function (files)
    {
        scope.files = files;
        angular.forEach(files, function (file)
        {
            if (file && !file.$error)
            {
                file.upload = Upload.upload({
                    url: '/file/v1/upload',
                    file: file
                });

                file.upload.then(function (response)
                {
                    $timeout(function ()
                    {
                        file.result = response.data;
                    });
                }, function (response)
                {
                    if (response.status > 0)
                    {
                        scope.errorMsg = response.status + ': ' + response.data;
                    }
                });

                file.upload.progress(function (evt)
                {
                    file.progress = Math.min(100, parseInt(100.0 *
                        evt.loaded / evt.total));
                });
            }
        });
    }

}]);