'use strict';

var controllers = angular.module('seroApp.controllers');

controllers.controller('AuditsInspectionsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', function (scope, ProjectFactory, $timeout, Upload, $q)
{
    scope.parts =
    {
        auditsinspections: {
            state: SavingStateEnum.None
        },
        auditinspection: {
            form: null,
            state: SavingStateEnum.None
        },
    };
    scope.newButton = {};
    scope.newButton.year = new Date().getFullYear();

    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.shouldShowAuditInspection = function(ai)
    {
        if (scope.parts.auditinspection.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.auditinspectionId==ai.id)
        {
            return true;
        }
        return false;
    };

    scope.criteriaMatchOfficer1 = function(currentId)
    {
        return function( item )
        {
            return true;
        };
    };
    scope.criteriaMatchOfficer = function(currentIds)
    {
        return function( item )
        {
            return true;
        };
    };

    scope.isLoading = function ()
    {
        if (scope.parts.auditinspection.state == SavingStateEnum.Loading)
        {
            if (scope.hasAuditInspection())
            {
                return true;
            }
            return false;
        }
        return scope.parts.auditinspection.state == SavingStateEnum.LoadingNew;
    };

    scope.hasAuditInspection = function ()
    {
        return !_.isEmpty(scope.data.auditinspection);
    };

    scope.updateStatus = function (ai)
    {
      updateAuditInspectionStatus(ai);
    };

    scope.openAuditInspection = function(id, $event)
    {
        if (scope.routeParams.auditinspectionId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/auditsinspections");

        }
        else if (!scope.routeParams.auditinspectionId)
        {
            scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/" + id);
        }
    };

    scope.stopPropagation = function($event)
    {
        $event.stopPropagation();
    };

    scope.saveCurrentAuditInspection = function ()
    {
        scope.data.auditinspection.year = new Date(scope.data.auditinspection.date_carried_out).getFullYear();
        var auditinspection = scope.data.auditinspection;
        console.log(auditinspection, "about to save");
        var isNew = auditinspection.is_new;
        if (!isNew)
        {
            scope.updateStatus(auditinspection);
        }
        scope.saveCurrent(scope.parts.auditinspection, auditinspection, isNew).then(function (ai)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/" + ai.id);
            }
        });
    };

    scope.newAuditInspection = function ()
    {
        scope.parts.auditinspection.state = SavingStateEnum.LoadingNew;
        scope.newButton.isopen = false;
        scope.newButton.year = new Date(scope.newButton.date_carried_out).getFullYear();
        ProjectFactory.createNewAuditInspection(scope.data.project, scope.newButton.year, scope.newButton.type, scope.newButton.reason, scope.newButton.date_carried_out);
        scope.parts.auditinspection.isNew = true;
        scope.saveCurrentAuditInspection();
    };

    scope.deleteAuditInspection = function ()
    {
        ProjectFactory.deleteAuditInspection(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/");
    };

    scope.auth.canSave = function (field)
    {
        if (field == "new")
        {
            return scope.userinfo.info.role_7;
        }
        if (scope.userinfo.info.role_8)
        {
            return true;
        }
        if (field == "lead_officer")
        {
            return false;
        }
        return scope.userinfo.info.id === scope.data.auditinspection.lead_officer;
    };

    scope.uploadActionTakenLetter = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingFileActionTakenLetter = true;
        scope.actionTakenLetterFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.auditinspection.form.action_taken_letter, scope.actionTakenLetterFile);

        promise.then(function (file)
        {
            scope.data.auditinspection.file_metadata_id = file.result.id;
            scope.parts.auditinspection.form.action_taken_letter.$setDirty();
            scope.saveCurrentAuditInspection();

            $timeout(function ()
            {
                scope.showUploadingFileActionTakenLetter = false;
            }, 3000);

        }, function (reason)
        {
        });
    };

    scope.uploadReport = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingFileReport = true;
        scope.reportFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.auditinspection.form.report, scope.reportFile);

        promise.then(function (file)
        {
            scope.data.auditinspection.file_metadata_report_id = file.result.id;
            scope.parts.auditinspection.form.report.$setDirty();
            scope.saveCurrentAuditInspection();

            $timeout(function ()
            {
                scope.showUploadingFileReport = false;
            }, 3000);

        }, function (reason)
        {
        });
    };

    scope.uploadDocumentation = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingFileDocumentation = true;
        scope.documentationFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.auditinspection.form.documentation, scope.documentationFile);
        promise.then(function (file)
        {
            scope.data.auditinspection.documentation_ids.push(file.result.id);
            scope.parts.auditinspection.form.documentation.$setDirty();
            scope.saveCurrentAuditInspection();

            $timeout(function ()
            {
                scope.showUploadingFileDocumentation = false;
            }, 3000);

        }, function (reason)
        {
        });
    };

    scope.downloadFileUrl = function (id)
    {
        return "/file/v1/download/" + id;
    };

    scope.deleteActionTakenLetter = function ()
    {
        scope.data.auditinspection.file_metadata_id = null;
        scope.parts.auditinspection.form.action_taken_letter.$setDirty();
        scope.saveCurrentAuditInspection();
    };

    scope.deleteReport = function ()
    {
        scope.data.auditinspection.file_metadata_report_id = null;
        scope.parts.auditinspection.form.report.$setDirty();
        scope.saveCurrentAuditInspection();
    };

    scope.deleteDocumentation = function (id)
    {
        _.remove(scope.data.auditinspection.documentation_ids, function (n)
        {
            return n === id
        });
        scope.parts.auditinspection.form.documentation.$setDirty();
        scope.saveCurrentAuditInspection();
    };

    scope.loadAuditInspection = function()
    {
        scope.parts.auditinspection.state = SavingStateEnum.Loading;

        var promises = ProjectFactory.retrieveAuditInspection(scope.routeParams);
        promises[0].then(function (ai)
        {
            scope.parts.auditinspection.state = SavingStateEnum.Loaded;
        });
    };

    scope.parts.auditinspection.state = SavingStateEnum.Loading;
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[3].then(function (ais)
    {
        scope.parts.auditsinspections.state = SavingStateEnum.Loaded;

        // Get auditinspection if we got an auditinspectionId.
        if (!_.isUndefined(scope.routeParams.auditinspectionId))
        {
            scope.loadAuditInspection();
        }
    });

}]);