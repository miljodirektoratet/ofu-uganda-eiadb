'use strict';

controllers.controller('EiasPermitsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.showUploadingCertificate = false;

    //scope.data.eiapermit = {}; // ???

    scope.shouldShowEiaPermit = function(ep)
    {
        if (scope.parts.eiapermit.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.eiapermitId==ep.id)
        {
            return true;
        }
        return false;
    };

    scope.saveCurrentEiaPermit = function (eiapermit)
    {
        // var eiapermit = scope.data.eiapermit;
        var isNew = eiapermit.is_new;

        if (!isNew)
        {
            scope.updateStatus(eiapermit);
        }

        scope.saveCurrent(scope.parts.eiapermit, eiapermit, isNew).then(function (ep)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/eiaspermits/" + ep.id);
            }
        });
    };

    scope.newEiaPermit = function ()
    {
        scope.parts.eiapermit.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewEiaPermit(scope.data.project);
        //scope.saveCurrentEiaPermit(scope.data.eiapermit);
    };

    scope.deleteEiaPermit = function ()
    {
        ProjectFactory.deleteEiaPermit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/eiaspermits");
    };

    scope.uploadCertificate = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingCertificate = true;
        scope.certificateFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.eiapermit.form.certificate, scope.certificateFile);

        promise.then(function (file)
        {
            scope.data.eiapermit.file_metadata_id = file.result.id;
            scope.parts.eiapermit.form.certificate.$setDirty();
            scope.saveCurrentEiaPermit(scope.data.eiapermit);
        }, function (reason)
        {
        });
    };

    scope.deleteCertificate = function ()
    {
        scope.showUploadingCertificate = false;
        scope.data.eiapermit.file_metadata_id = null;
        scope.parts.eiapermit.form.certificate.$setDirty();
        scope.saveCurrentEiaPermit(scope.data.eiapermit);
    };

    scope.criteriaMatchOfficer1 = function (currentId)
    {
        return function (item)
        {
            return true;
        };
    };

    scope.criteriaMatchOfficer = function (currentIds)
    {
        return function (item)
        {
            return true;
        };
    };

    scope.modifyInputDecimals = function () {
        var originalFee = parseFloat(scope.data.eiapermit.fee);
        var originalExpectedJobCreated = parseFloat(scope.data.eiapermit.expected_jobs_created);
        if(originalFee && originalFee.countDecimals() > 2) {
            scope.data.eiapermit.fee = originalFee.truncateDecimal(2);
        }
        if(originalExpectedJobCreated && originalExpectedJobCreated.countDecimals() > 1) {
            scope.data.eiapermit.expected_jobs_created = originalExpectedJobCreated.truncateDecimal(1);
        }
    }
    scope.auth.canSave = function (field)
    {
        if (scope.data.eiapermit.is_new && scope.parts.eiapermit.state == SavingStateEnum.SavingStarted)
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