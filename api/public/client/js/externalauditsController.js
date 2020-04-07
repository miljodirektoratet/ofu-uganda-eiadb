'use strict';

controllers.controller('ExternalAuditsController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.showUploadingResponseDocument = false;

    scope.shouldShowExternalAudit = function(ea)
    {
        if (scope.parts.externalaudit.state == SavingStateEnum.Loading)
        {
            return false;
        }
        if (scope.routeParams.externalauditId==ea.id)
        {
            return true;
        }
        return false;
    };

    scope.saveCurrentExternalAudit = function (externalaudit)
    {
        var isNew = externalaudit.is_new;

        if (!isNew)
        {
            scope.updateStatus(externalaudit);
        }

        scope.saveCurrent(scope.parts.externalaudit, externalaudit, isNew).then(function (ea)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/externalaudits/" + ea.id);
            }
        });
    };

    scope.newExternalAudit = function ()
    {
        scope.parts.externalaudit.state = SavingStateEnum.LoadingNew;
        ProjectFactory.createNewExternalAudit(scope.data.project);
    };

    scope.deleteExternalAudit = function ()
    {
        ProjectFactory.deleteExternalAudit(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/externalaudits");
    };

    scope.uploadResponseDocument = function (files)
    {
        if (!files)
        {
            return;
        }
        scope.showUploadingResponseDocument = true;
        scope.responseDocumentFile = files[0];
        var promise = uploadFile($q, $timeout, Upload, scope.parts.externalaudit.form.response_document, scope.responseDocumentFile);

        promise.then(function (file)
        {
            scope.data.externalaudit.file_metadata_response_id = file.result.id;
            scope.parts.externalaudit.form.response_document.$setDirty();
            scope.saveCurrentExternalAudit(scope.data.externalaudit);
        }, function (reason)
        {
        });
    };

    scope.deleteResponseDocument = function ()
    {
        scope.showUploadingResponseDocument = false;
        scope.data.externalaudit.file_metadata_response_id = null;
        scope.parts.externalaudit.form.response_document.$setDirty();
        scope.saveCurrentExternalAudit(scope.data.externalaudit);
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

    scope.auth.canSave = function (field)
    {
        if (scope.data.externalaudit.is_new && scope.parts.externalaudit.state == SavingStateEnum.SavingStarted)
        {
            return false;
        }

        switch (field)
        {
            case "new":
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
            case "review_findings":
            case "response":
            case "date_deadline_compliance":
            case "delete":
            case "upload_documentation_response_letter":
            case "delete_documentation_response_letter":
                return scope.userinfo.info.role_3;
            case "user_id":
                return scope.userinfo.info.role_5;
            case "status":
                return false;
            default:
                return false;
        }
    };

    scope.filterByDateSubmission = function(data) {
        if(!data.length && !data[0].documents){return;}
        data.sort(function(a,b){
            console.log()
            var date1 =  (a.documents && a.documents[0])?a.documents[0].date_submitted:"";

            var date2 = (b.documents && b.documents[0])?b.documents[0].date_submitted:"";

            return date1 < date2 ? -1 : 1;
          })
        return data.reverse();
    };
}]);