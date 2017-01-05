'use strict';

var controllers = angular.module('seroApp.controllers');

controllers.controller('AuditsInspectionsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', function (scope, ProjectFactory, $timeout, Upload, $q)
{
    scope.parts =
    {
        auditinspection: {
            form: null,
            state: SavingStateEnum.Loading
        }
    };
    scope.newButton = {};
    scope.newButton.year = new Date().getFullYear();

    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.criteriaMatchOfficer1 = function(currentId)
    {
        return function( item )
        {
            if (item.passive && currentId)
            {
                return item.id === currentId;
            }

            return item.passive === false;
        };
    };
    scope.criteriaMatchOfficer = function(currentIds)
    {
        return function( item )
        {
            if (item.passive && currentIds)
            {
                for(var i=0; i<currentIds.length;i++)
                {
                    var currentId = currentIds[i];
                    return item.id === currentId;
                }
            }

            return item.passive === false;
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
        // 70 = Created
        // 71 = Carried out
        // 72 = Action taken
        // 73 = Deadline passed
        // 74 = Corrections received
        // 75 = Closed
        if (ai.date_closing)
        {
            ai.status = 75;
        }
        else if (ai.date_received)
        {
            ai.status = 74;
        }
        else if (ai.date_deadline && ai.date_deadline < new Date())
        {
            ai.status = 73;
        }
        else if (ai.action_taken)
        {
            ai.status = 72;
        }
        else if (ai.date_carried_out)
        {
            ai.status = 71;
        }
    };

    scope.saveCurrentAuditInspection = function ()
    {
        var auditinspection = scope.data.auditinspection;
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
        ProjectFactory.createNewAuditInspection(scope.data.project, scope.newButton.year, scope.newButton.type, scope.newButton.reason);
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

    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[3].then(function (ais)
    {
        if (ais.length > 0 && !scope.routeParams.auditinspectionId)
        {
            var ai = ais[0];
            scope.goto("/projects/" + scope.data.project.id + "/auditsinspections/" + ai.id);
        }
    });
    promises[4].then(function (ai)
    {
        scope.parts.auditinspection.state = SavingStateEnum.Loaded;
    });

}]);