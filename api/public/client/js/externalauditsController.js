'use strict';

controllers.controller('ExternalAuditsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.showUploadingCertificate = false;

    //scope.data.project2.externalaudit = {}; // ???

    scope.shouldShowExternalAudit = function(ea)
    {
        if (scope.parts.externalaudit.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.externalauditId==ep.id)
        {
            return true;
        }
        return false;
    };

    scope.saveCurrentExternalAudit = function (externalaudit)
    {
        // var externalaudit = scope.data.project2.externalaudit;
        var isNew = externalaudit.is_new;

        if (!isNew)
        {
            scope.updateStatus(externalaudit);
        }

        scope.saveCurrent(scope.parts.externalaudit, externalaudit, isNew).then(function (ea)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + ep.id);
            }
        });
    };

    scope.newExternalAudit = function ()
    {
        scope.parts.externalaudit.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewExternalAudit(scope.data.project);
        //scope.saveCurrentExternalAudit(scope.data.project2.externalaudit);
    };

    scope.deleteExternalAudit = function ()
    {
        ProjectFactory.deleteExternalAudit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/externalaudits");
    };

    scope.uploadCertificate = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingCertificate = true;
        scope.certificateFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.externalaudit.form.certificate, scope.certificateFile);

        promise.then(function (file)
        {
            scope.data.project2.externalaudit.file_metadata_id = file.result.id;
            scope.parts.externalaudit.form.certificate.$setDirty();
            scope.saveCurrentExternalAudit(scope.data.project2.externalaudit);
        }, function (reason)
        {
        });
    };

    scope.deleteCertificate = function ()
    {
        scope.showUploadingCertificate = false;
        scope.data.project2.externalaudit.file_metadata_id = null;
        scope.parts.externalaudit.form.certificate.$setDirty();
        scope.saveCurrentExternalAudit(scope.data.project2.externalaudit);
    };

    scope.criteriaMatchOfficer1 = function (currentId)
    {
        return function (item)
        {
            if (item.passive && currentId)
            {
                return item.id === currentId;
            }

            return item.passive === false;
        };
    };

    scope.criteriaMatchOfficer = function (currentIds)
    {
        return function (item)
        {
            if (item.passive && currentIds)
            {
                for (var i = 0; i < currentIds.length; i++)
                {
                    var currentId = currentIds[i];
                    return item.id === currentId;
                }
            }

            return item.passive === false;
        };
    };

    scope.auth.canSave = function (field)
    {
        if (scope.data.project2.externalaudit.is_new && scope.parts.externalaudit.state == SavingStateEnum.SavingStarted)
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
            case "cost":
            case "cost_currency":
            case "expected_jobs_created":
                return scope.userinfo.info.role_1;
            case "personnel":
                return scope.userinfo.info.role_2;
            case "inspection_recommended":
            case "date_inspection":
            case "officer_recommend":
            case "fee":
            case "fee_currency":
            case "remarks":
                return scope.userinfo.info.role_3;
            case "date_fee_notification":
            case "date_fee_payed":
            case "fee_receipt_no":
                return scope.userinfo.info.role_4;
            case "decision":
            case "date_decision":
            case "designation":
            case "date_certificate":
            case "certificate_no":
            case "date_cancelled":
            case "user_id":
            case "date_sent_ded_approval":
                return scope.userinfo.info.role_5;
            case "status":
                return false;
            default:
                return false;
        }
    };
}]);