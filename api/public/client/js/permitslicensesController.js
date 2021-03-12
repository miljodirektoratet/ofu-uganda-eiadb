'use strict';

controllers.controller('PermitsLicensesController', ['$scope', 'ProjectFactory', '$timeout', 'Upload', '$q', '$location', function (scope, ProjectFactory, $timeout, Upload, $q, location)
{
    scope.invalidRecipients = false;
    scope.parts =
    {
        permitslicenses: {
            state: SavingStateEnum.None
        },
        permitlicense: {
            form: null,
            state: SavingStateEnum.None
        }
    };

    scope.newButton = {};
    scope.newButton.approved_by_the_lc1 = false;
    scope.newButton.approved_by_the_dec = false;

    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.DocumentTagEnum = DocumentTagEnum;
    scope.documentationData = {
        ApplicationForm: {formField: 'documentation_applicationform', tag: DocumentTagEnum.PermitLicenseApplicationForm},
        PermitLicense: {formField: 'documentation_permitlicense', tag: DocumentTagEnum.PermitLicensePermitLicense},
        Attachments: {formField: 'documentation_attachments', tag: DocumentTagEnum.PermitLicenseAttachments}
    };

    scope.idPermit = 118;
    scope.idLicense = 119;
    scope.idWetland = 123;

    scope.isEcosystemWetland = function (pl)
    {
        return pl.ecosystem == scope.idWetland;
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

    scope.notOkToEditOrCreateNew = function()
    {
        if (scope.routeParams.permitlicenseId)
        {
            return true;
        }
        if (scope.data.permitlicense.is_new)
        {
            return true;
        }
        return false;
    };

    scope.preventClickIfDisabled = function(isDisabled, $event)
    {
        if (isDisabled)
        {
            $event.preventDefault();
        }
    };

    scope.openPermitLicense = function(id, $event)
    {
        console.log(scope.routeParams.permitlicenseId, id);
        if (scope.data.permitlicense.is_new)
        {
            // Do nothing.
        }
        else if (scope.routeParams.permitlicenseId == id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/permitslicenses");

        }
        else if (scope.routeParams.permitlicenseId && scope.routeParamspermitlicenseId != id)
        {
            scope.goto("/projects/" + scope.data.project.id + "/permitslicenses/" + id);
       

        }
        else if (!scope.routeParams.permitlicenseId)
        {
            console.log("it says its not set")
            scope.goto("/projects/" + scope.data.project.id + "/permitslicenses/" + id);
        }
    };

    scope.customValidation = function(pl) {
        if(pl.email_contact && !window.verifyEmailList(pl.email_contact)) {
          scope.invalidRecipients = true;
          return false;
        }
        scope.invalidRecipients = false;
        return true;
    }

    scope.saveCurrentPermitLicense = function (permitlicense)
    {
        var isNew = permitlicense.is_new;
        if(!scope.customValidation(permitlicense)) {
            return false;
        }
        if (!scope.isEcosystemWetland(permitlicense))
        {
            permitlicense.regulation_activity = null;
        }

        scope.updateStatus(permitlicense);

        scope.saveCurrent(scope.parts.permitlicense, permitlicense, isNew).then(function (pl)
        {
            if (isNew)
            {
                scope.goto("/projects/" + scope.data.project.id + "/permitslicenses/" + pl.id);
            }
        });
    };

    scope.updateStatus = function (pl)
    {
        updatePermitLicenseStatus(pl);
    };

    scope.newPermitLicense = function ()
    {
        scope.parts.permitlicense.state = SavingStateEnum.LoadingNew;

        scope.newButton.isopen = false;
        var  regulationActivity = null;
        if (scope.isEcosystemWetland(scope.newButton))
        {
            regulationActivity = scope.newButton.regulation_activity;
        }
        ProjectFactory.createNewPermitLicense(scope.data.project, scope.newButton.regulation, scope.newButton.ecosystem, regulationActivity, scope.newButton.area, scope.newButton.unit, scope.newButton.approved_by_the_lc1, scope.newButton.approved_by_the_dec, scope.newButton.waste_license_type);
        //scope.saveCurrentPermitLicense(scope.data.permitlicense);
    };

    scope.deletePermitLicense = function ()
    {
        ProjectFactory.deletePermitLicense(scope.routeParams);
        scope.goto("/projects/" + scope.data.project.id + "/permitslicenses");
    };

    scope.calculateDateFeedbackToApplicants = function()
    {
        scope.data.permitlicense.date_feedback_to_applicants =  addDays(scope.data.permitlicense.date_submitted, 21);
    };

    scope.uploadDocumentation = function (pl, documentationData, files)
    {
        if (!files)
        {
            return;
        }

        documentationData.showUploading = true;
        documentationData.file = files[0];

        var promise = uploadFile($q, $timeout, Upload, scope.parts.permitlicense.form[documentationData.formField], documentationData.file, documentationData.tag);
        promise.then(function (file)
        {
            pl.documentation_ids.push(file.result.id);
            scope.parts.permitlicense.form[documentationData.formField].$setDirty();
            scope.saveCurrentPermitLicense(pl);

            $timeout(function ()
            {
                documentationData.showUploading = false;
            }, 3000);

        }, function (reason)
        {
        });
    };

    scope.deleteDocumentation = function (pl, id, documentationData)
    {
        _.remove(pl.documentation_ids, function (n)
        {
            return n === id
        });
        scope.parts.permitlicense.form[documentationData.formField].$setDirty();
        scope.saveCurrentPermitLicense(pl);
    };

    scope.hasDocumentationTag = function(documentation, tag)
    {
        var result = false;
        _.forEach(documentation, function (d)
        {
            // console.log(d.tag, tag);
          if (d.tag == tag)
          {
              result = true;
          }
        });
      return result;
    };

    scope.downloadFileUrl = function (id)
    {
        return "/file/v1/download/" + id;
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
            case "regulation":
            case "date_submitted":
            case "waste_license_type":
            case "ecosystem":
            case "regulation_activity":
            case "area":
            case "unit":
            case "approved_by_the_lc1":
            case "approved_by_the_dec":
            case "application_number":
            case "application_fee_receipt_number":
            case "date_feedback_to_applicants":
            case "date_sent_to_director":
            case "date_sent_from_dep":
            case "date_sent_officer":
            case "folio_no":
                return scope.userinfo.info.role_1;
            case "personnel":
                return scope.userinfo.info.role_2;
            case "application_evaluation_by_officer":
            case "date_of_evaluation":
            case "inspection_recommended":
            case "date_inspection":
            case "officer_recommend":
            case "date_sent_for_decision":
                return scope.userinfo.info.role_3;
            case "fee_receipt_no":
            case "date_fee_payed":
                return scope.userinfo.info.role_4;
            case "user_id":
            case "decision":
            case "date_decision":
            case "signature_on_permit_license":
            case "date_permit_license":
            case "permit_license_no":
            case "date_permit_license_expired":
            case "upload_documentation_permit_license":
            case "delete_documentation_permit_license":
                return scope.userinfo.info.role_5;
            case "recipient_email":
            case "can_email":
                return scope.userinfo.info.role_7;
            case "status":
                return false;
            default:
                return false;
        }
    };

    scope.getEmailerObj = function (pl) {
        var index = (pl.email_order && pl.email_order.order_status) ? pl.email_order.order_status : 0; 
        return window.emailerStatusObj[index];
    }

    scope.failedToSendMail = false;
    scope.pl = scope.data.permitlicense;
    scope.createEmailOrder = function(orderType, entityId, documentId, pl) {
        pl.email_order = {};
        pl.email_order.order_status = 1;
        window.createEmailOrder(orderType, entityId, documentId, function(response) {
            scope.$apply(function(){
                if(response.order_status == 0) {
                    pl.email_order = null;
                    scope.failedToSendMail = true;
                } else {
                    pl.email_order = response;
                }

        })});
    }

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