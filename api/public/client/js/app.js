"use strict";

var debug = true;

angular.module("seroApp.services", []);
angular.module("seroApp.directives", []);
angular.module("seroApp.controllers", []);
angular.module("pax.validations", []);

// Declare app level module which depends on filters, and services
var seroApp = angular
  .module("seroApp", [
    "ngRoute",
    "ngResource",
    "ngAnimate",
    "ngMessages",
    "ngSanitize",
    "ui.bootstrap",
    "ui.select2",
    // 'ui.select',
    "ngFileUpload",
    "ui.grid",
    "ui.grid.edit",
    "ui.grid.rowEdit",
    "ui.grid.cellNav",
    "ui.grid.resizeColumns",
    "ui.grid.moveColumns",
    "ui.grid.selection",
    "seroApp.services",
    "seroApp.directives",
    "seroApp.controllers",
    "pax.validations"
  ])
  .config([
    "$routeProvider",
    "$rootScopeProvider",
    function ($routeProvider, $rootScopeProvider) {
      $rootScopeProvider.digestTtl(500);
      var projectTabsOptions = {
        templateUrl: "partials/projectTabs.html",
        controller: "ProjectTabsController"
      };

      $routeProvider.when("/", {
        templateUrl: "partials/home.html",
        controller: "HomeController"
      });
      $routeProvider.when("/projects", {
        templateUrl: "partials/projects.html",
        controller: "ProjectsController"
      });
      $routeProvider.when("/projects/:projectId", projectTabsOptions);
      $routeProvider.when(
        "/projects/:projectId/eiaspermits",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/eiaspermits/:eiapermitId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/eiaspermits/:eiapermitId/documents",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId/hearings",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId/hearings/:hearingId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/externalaudits",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/externalaudits/:externalauditId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/externalaudits/:externalauditId/documents",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/externalaudits/:externalauditId/documents/:documentId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/auditsinspections",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/auditsinspections/:auditinspectionId",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/permitslicenses",
        projectTabsOptions
      );
      $routeProvider.when(
        "/projects/:projectId/permitslicenses/:permitlicenseId",
        projectTabsOptions
      );

      var searchTabsOptions = {
        templateUrl: "partials/searchTabs.html",
        controller: "SearchTabsController"
      };
      $routeProvider.when("/search", { redirectTo: "/search/projects" });
      $routeProvider.when("/search/projects", searchTabsOptions);
      $routeProvider.when("/search/eiaspermits", searchTabsOptions);
      $routeProvider.when("/search/permitslicenses", searchTabsOptions);
      $routeProvider.when("/search/auditsinspections", searchTabsOptions);
      $routeProvider.when("/search/externalaudits", searchTabsOptions);

      var statisticsTabsOptions = {
        templateUrl: "partials/statisticsTabs.html",
        controller: "StatisticsTabsController"
      };
      $routeProvider.when("/statistics", {
        redirectTo: "/statistics/projects"
      });
      $routeProvider.when("/statistics/projects", statisticsTabsOptions);

      $routeProvider.when("/advanced/codes", {
        templateUrl: "partials/advancedCodes.html",
        controller: "AdvancedCodesController"
      });
      $routeProvider.when("/advanced/users", {
        templateUrl: "partials/advancedUsers.html",
        controller: "AdvancedUsersController"
      });
      $routeProvider.when("/advanced/emailOrders", {
        templateUrl: "partials/advancedEmailOrder.html",
        controller: "AdvancedEmailOrderController"
      });
      $routeProvider.when("/advanced/leadagencies", {
        templateUrl: "partials/advancedLeadAgency.html",
        controller: "AdvancedLeadAgenciesController"
      });
      $routeProvider.when("/advanced/pirking/statusEIA", {
        templateUrl: "partials/eiapermit-pirking.html",
        controller: "EiapermitPirkingController"
      });
      $routeProvider.when("/advanced/pirking/statusEA", {
        templateUrl: "partials/externalAudit-pirking.html",
        controller: "ExternalAudiPirkingController"
      });
      $routeProvider.when("/advanced/pirking/statusAI", {
        templateUrl: "partials/auditInspection-pirking.html",
        controller: "AuditInspecitionPirkingController"
      });
      $routeProvider.when("/advanced/pirking/statusPL", {
        templateUrl: "partials/permitlicense-pirking.html",
        controller: "PermitLicensePirkingController"
      });
      $routeProvider.when("/advanced/anonymize-data", {
        templateUrl: "partials/anonymize-data.html",
        controller: "DataAnonymizerController"
      });

      $routeProvider.when("/about", { templateUrl: "partials/about.html" });
      $routeProvider.when("/login", {
        templateUrl: "partials/login.html",
        controller: "UserController"
      });
      $routeProvider.when("/password/send", {
        templateUrl: "partials/passwordSend.html",
        controller: "LoginController"
      });
      $routeProvider.when("/password/reset/:token", {
        templateUrl: "partials/passwordReset.html",
        controller: "LoginController"
      });
      $routeProvider.when("/user", {
        templateUrl: "partials/user.html",
        controller: "UserController"
      });
      $routeProvider.when("/practitioners", {
        templateUrl: "partials/practitioners.html",
        controller: "PractitionersController"
      });

      $routeProvider.when("/public/practitioners", {
        templateUrl: "partials/publicPractitioners.html",
        controller: "PractitionersController"
      });

      $routeProvider.otherwise({ redirectTo: "/" });
    }
  ])
  .factory("authHttpResponseInterceptor", [
    "$q",
    "$location",
    function ($q, $location) {
      return {
        responseError: function (rejection) {
          if ($location.path().indexOf("/password/reset/") == 0 || $location.path() == "/public/practitioners") {
            // No redirect.
          } else if (rejection.status === 401) {
            $location.path("/login");
          }
          return $q.reject(rejection);
        }
      };
    }
  ])
  .factory("unsavedDataProtection", [
    "$q",
    "$location",
    function ($q, $location) {
      return {
        request: function (config) {
          if (config.method != 'GET') {
            window.globalWordCount = '';
          } else {
            window.interceptPageNavigation();
          }
          return config;
        }
      };
    }
  ])
  .config([
    "$httpProvider",
    function ($httpProvider) {
      $httpProvider.interceptors.push("authHttpResponseInterceptor");
      $httpProvider.interceptors.push("unsavedDataProtection");
    }
  ]);

var SavingStateEnum = {
  None: "None",
  LoadingNew: "Loading new",
  Loading: "Loading",
  Loaded: "Loaded",
  SavingStarted: "Saving started",
  SavingFinished: "Saving finished",
  SavingFailed: "Saving failed",
  Invalid: "Form not valid",
  MissingDependency: "Missing dependency in other form"
};

var DisplayStateEnum = {
  Show: true,
  Hide: false
}

var ProjectTabEnum = {
  Project: "Project",
  EiasPermits: "EIAS",
  PermitsLicenses: "Permits and Licenses",
  AuditsInspections: "Audits and Inspections",
  ExternalAudits: "External audits"
};

var EiasPermitsTabEnum = {
  EiaPermit: "EIA",
  Documents: "Documents",
  Hearings: "Hearings"
};

var ExternalAuditsTabEnum = {
  ExternalAudit: "External audit",
  Documents: "Documents",
  Hearings: "Hearings"
};

var SearchTabEnum = {
  Projects: "Projects",
  EiasPermits: "EIAS",
  PermitsLicenses: "Permits and Licenses",
  AuditsInspections: "Audits and Inspections",
  ExternalAudits: "External audits"
};

var StatisticsTabEnum = {
  Projects: "Projects",
  EiasPermits: "EIAS",
  AuditsInspections: "Audits and Inspections"
};

var DocumentTagEnum = {
  PermitLicenseApplicationForm: "Application form",
  PermitLicensePermitLicense: "Permit or license",
  PermitLicenseAttachments: "Attachment to the application"
};

var fileUploadPattern =
  "image/*,application/pdf,application/vnd.openxmlformats*,application/msword,text/plain,text/csv,application/octet-stream,binary/octet-stream,.xls,.xlsx,.docx";
var fileUploadNgfPattern =
  "'image/*,application/pdf,application/vnd.openxmlformats*,application/msword,text/plain,text/csv,application/octet-stream,binary/octet-stream,.xls,.xlsx,.docx'";
var fileUploadMaxSize = "50MB";

//start of export script
var exportObj = {};
exportObj.exportMetaData = {};
exportObj.exportData = function (data, tabName) {
  var dataMeta = this.exportMetaData[tabName];
  //excelExport.js
  excelExport(data, dataMeta, tabName);
};
exportObj.exportMetaData['emailOrders'] = {
  fieldmap: {
    id: "ID",
    foreign_id: "Document ID",
    foreign_type: "Document Type",
    order_status: "Order Status",
    subject: "Subject",
    unformatted_body: "Body",
    recipient: "Recipient",
    cc: "CC",
    bcc: "BCC",
    remarks_from_service: "Remarks from Service",
    remarks: "Remarks",
    number_of_attempts: "Number of Attempts",
    created_by: "Created By",
    formatted_created_at: "Created On",
    updated_by: "Updated By",
    formatted_updated_at: "Updated On",
    formatted_deleted_at: "Deleted On",
  },
  dateFields: [
    "formatted_created_at",
    "formatted_updated_at",
    "formatted_deleted_at",
  ]
}
exportObj.exportMetaData["auditAndInspection"] = {
  fieldmap: {
    auditinspection_code: "Control number",
    auditinspection_status: "Audit and inspection status",
    auditinspection_year: "Year",
    auditinspection_type: "Activity",
    auditinspection_reason: "Type",
    lead_officer_name: "Lead officer",
    other_officer_name: "Other officers",
    auditinspection_date_carried_out: "Date carried out",
    auditinspection_days: "Number of days",
    auditinspection_external_participants:
      "Participants from lead agencies, facilities etc.",
    auditinspection_coordinated: "Multisectoral",
    lead_agency_name: "Lead agencies",
    auditinspection_date_action_taken: "Date of response",
    auditinspection_action_taken: "Response",
    auditinspection_advance_notice: "Advanced notice",
    auditinspection_findings: "Description of findings",
    auditinspection_performance_level: "Performance level",
    auditinspection_recommendations: "Recommendations",
    auditinspection_date_deadline: "Follow-up date",
    auditinspection_date_closing: "Activity ended",
    auditinspection_remarks: "Remarks",
    project_id: "Project ID",
    project_title: "Project name",
    category_description: "Category",
    district_district: "District",
    organisation_id: "Developer ID",
    developer_name: "Developer name"
  },
  dateFields: [
    "auditinspection_date_carried_out",
    "auditinspection_date_deadline",
    "auditinspection_date_closing",
    "auditinspection_date_action_taken"
  ]
};

exportObj.exportMetaData["project"] = {
  fieldmap: {
    project_id: "Project ID",
    project_title: "Project name",
    category_description: "Category",
    district_district: "District",
    project_location: "Location",
    project_longitude: "Longitude",
    project_latitude: "Latitude",
    project_has_industrial_waste_water: "Industrial waste water?",
    project_risk_level: "Risk level",
    project_contact_person: "Contact person",
    project_remarks: "Project remarks",
    organization_id: "Developer ID",
    developer_name: "Developer name",
    developer_tin: "TIN",
    organization_visiting_address: "Visiting address",
    organization_physical_address: "Physical address",
    organization_box_no: "PO box",
    organization_city: "City",
    organization_phone: "Phone",
    organization_fax: "Fax",
    organization_email: "Email",
    organization_remarks: "Developer remarks"
  },
  dateFields: []
};

exportObj.exportMetaData["exportPermitsLicenses"] = {
  fieldmap: {
    permitlicense_id: "Permit and license ID",
    permitlicense_regulation: "Regulation",
    permitlicense_date_submitted: "Date of submission",
    permitlicense_waste_license_type: "Waste license type",
    permitlicense_ecosystem: "Ecosystem",
    permitlicense_regulation_activity: "Regulation activity",
    permitlicense_area: "Area",
    permitlicense_unit: "Unit",
    permitlicense_approved_by_the_lc1: "LC1 approved",
    permitlicense_approved_by_the_dec: "DEC approved",
    permitlicense_application_number: "Application number",
    permitlicense_application_fee_receipt_number:
      "Application fee receipt number",
    permitlicense_date_feedback_to_applicants: "Date feedback to applicants",

    permitlicense_date_sent_officer: "Date feedback to applicants",
    permitlicense_date_sent_to_director: "Date sent to Director",
    permitlicense_date_sent_from_dep: "Date sent to team leader from dep",
    permitlicense_date_sent_officer: "Date sent to the officer",
    permitlicense_officer_assigned: "Team leader",
    permitlicense_handling_officer: "Officers to handle",
    permitlicense_officer_evaluation: "Application evaluation by officer",
    permitlicense_date_of_evaluation: "Date of evaluation",
    permitlicense_folio_no: "File and foliono.",
    permitlicense_inspection_recommended: "Inspection before decision ?",
    permitlicense_date_inspection: "Date of inspection",
    permitlicense_officer_recommend: "Recommendations by reviewer",
    permitlicense_fee_receipt_no: "Permit/license fee receipt number",
    permitlicense_date_fee_payed: "Date permit / license fee paid",
    permitlicense_date_sent_for_decision: "Date sent for decision",
    permitlicense_decision: "Decision taken",
    permitlicense_signature_on_permit_license: "Signature on permit / license",
    permitlicense_date_permit_license: "Date on the permit / licence",
    permitlicense_permit_license_no: "Permit / license number",
    permitlicense_date_permit_license_expired: "Date permit / license expired",
    permitlicense_documentation_files: "Soft copy",
    project_id: "Project ID",
    project_title: "Project name",
    category_name: "Category",
    district_district: "District",
    organisation_id: "Developer ID",
    organisation_name: "Developer name"
  },
  dateFields: [
    "permitlicense_date_submitted",
    "permitlicense_date_sent_to_director",
    "permitlicense_date_sent_from_dep",
    "permitlicense_date_sent_officer",
    "permitlicense_date_of_evaluation",
    "permitlicense_date_inspection",
    "permitlicense_date_fee_payed",
    "permitlicense_date_sent_for_decision",
    "permitlicense_date_permit_license",
    "permitlicense_date_permit_license_expired",
    "permitlicense_date_feedback_to_applicants"
  ]
};
exportObj.exportMetaData["eiaspermits"] = {
  fieldmap: {
    eiapermit_id: "EIA and permit ID",
    eiapermit_status: "EIA status",
    practitioner_teamleader: "Practitioner team leader",
    cost: "Cost of the proposed development",
    eiapermit_cost_currency: "Cost currency",
    eiapermit_expected_jobs_created: "Expected jobs created",
    team_leader_name: "Team leader",
    personnel_officers_name: "Officers to handle",
    eias_permits_inspection_recommendation: "Inspection before decision?",
    eiapermit_date_inspection: "Date of inspection",
    eiapermit_officer_recommend: "Recommendations by reviewer",
    eiapermit_fee: "Expected fees",
    eiapermit_fee_currency: "Fee currency",
    eiapermit_date_sent_ded_approval: "Date sent for approval",
    eiapermit_decision: "Decision taken",
    eiapermit_date_decision: "Date for decision",
    eiapermit_date_fee_notification: "Date of invoicing",
    eiapermit_date_fee_payed: "Date invoice is payed",
    eiapermit_fee_receipt_no: "Fee receipt number",
    eiapermit_designation: "Signature on certificate",
    eiapermit_date_certificate: "Date on the certificate",
    eiapermit_certificate_no: "Certificate number",
    eiapermit_date_cancelled: "Certificate canceled date",
    eiapermit_remarks: "Remarks",
    file_metadata: "Soft copy of certificate",
    document_codes: "Documents",
    project_id: "Project ID",
    project_title: "Project name",
    category_description: "Category",
    district_district: "District",
    developer_id: "Developer ID",
    developer_name: "Developer name"
  },
  dateFields: [
    "eiapermit_date_inspection",
    "eiapermit_date_sent_ded_approval",
    "eiapermit_date_decision",
    "eiapermit_date_fee_notification",
    "eiapermit_date_fee_payed",
    "eiapermit_date_certificate",
    "eiapermit_date_cancelled"
  ]
};

exportObj.exportMetaData["externalAudit"] = {
  fieldmap: {
    externalaudit_id: "External audit ID",
    externalaudit_status: "Status",
    ea_type: "Type of external audit",
    team_leader: "Team leader",
    handling_officers: "Officers to handle",
    verification_inspection: "Verification inspection?",
    date_inspection: "Date of inspection",
    date_response: "Date of response",
    file_metadata_response_id: "Response letter",
    review_findings: "Review findings",
    response: "Response",
    date_deadline_compliance: "Date for complete compliance",
    doc_code: "Documents",
    // project_project_id: "Project ID",
    project_id: "Project ID",
    project_project_name: "Project name",
    category_name: "Category",
    district_district: "District",
    organisation_id: "Developer ID",
    organisation_name: "Developer name",
    invoice_fees: "Fees Invoiced",
    date_create_invoice: "Date of invoice creation",
    date_invoice_receipt_issued: "Date invoice was issued",
    date_invoice_payment: "Date invoice was paid"
  },
  dateFields: ["date_inspection", "date_response", "date_create_invoice", "date_invoice_receipt_issued", "date_invoice_payment"]
};

exportObj.exportMetaData["practitioners"] = {
  fieldmap: {
    practitioner: "Practitioner",
    tin: "TIN",
    organisation_name: "Organisation Name",
    visiting_address: "Address",
    box_no: "P.O. Box",
    phone: "Phone",
    fax: "Fax",
    email: "Email",
    qualifications: "Qualifications",
    expertise: "Expertise",
    remarks: "Remarks",
    year: "Year",
    date_of_entry: "Date of entry",
    cert_type: "Type of certificate",
    cert_no: "Certificate number",
    conditions: "Conditions",
    is_cancelled: "Cancelled?"
  },
  dateFields: []
};

//End of export script
function so() {
  console.log("ca")
}
//coordinate check 
function isCoordinateWithinUganda(lat, long, callback) {
  if (!lat || !long) {
    return callback(false, { error: "undefined coordinates" });
  }
  fetch("https://nominatim.openstreetmap.org/reverse?format=json&lat=" + lat + "&lon=" + long, { "headers": { "content-type": "application/json" }, "method": "GET", "mode": "cors" }).then(function (resp) {
    return resp.json();
  }).then(function (resp) {
    if (!resp.address || resp.address.country_code != 'ug') {
      return callback(false, resp);
    }
    return callback(true, resp);
  }).catch(function () {
    return callback(false, { error: "network" })
  });
}
//var regexIso8601 = /^(\d{4}|\+\d{6})(?:-(\d{2})(?:-(\d{2})(?:T(\d{2}):(\d{2}):(\d{2})\.(\d{1,})(Z|([\-+])(\d{2}):(\d{2}))?)?)?)?$/;
var regexIso8601 = /^(\d{4}-\d{2}-\d{2} \d{2}\:\d{2}\:\d{2})$/;
function convertDateStringsToDates(input) {
  // Ignore things that aren't objects.
  if (typeof input !== "object") {
    return input;
  }

  for (var key in input) {
    if (!input.hasOwnProperty(key)) {
      continue;
    }

    var value = input[key];
    var match;
    // Check for string properties which look like dates.
    if (typeof value === "string" && (match = value.match(regexIso8601))) {
      // Old way (before 22 Sep 2015):
      //var dateParts = match[0].split(" ");
      //input[key] = new Date(dateParts[0]);

      // New way, with time part as well:
      var dateWithTime = match[0].replace(" ", "T");
      dateWithTime = dateWithTime + "Z";
      input[key] = new Date(dateWithTime);

      /*
             var dateParts = match[0].replace("00:00:00", "12:00:00").split(" "); // HACK to make sure we are on the correct day.
             var dateWithT = dateParts[0]+"T"+dateParts[1];
             var milliseconds = Date.parse(dateWithT);
             if (!isNaN(milliseconds))
             {
             input[key] = new Date(milliseconds);
             //input[key] = filter('date')(new Date(milliseconds), 'd. MMM yyyy');
             }
             */
    } else if (typeof value === "object") {
      // Recurse into object
      convertDateStringsToDates(value);
    }
  }
}

seroApp.config([
  "$httpProvider",
  function ($httpProvider) {
    $httpProvider.defaults.transformResponse.push(function (responseData) {
      convertDateStringsToDates(responseData);
      return responseData;
    });
  }
]);

var uploadFile = function ($q, $timeout, Upload, partInForm, file, tag) {
  partInForm.$setValidity("serverError", true);

  var deferred = $q.defer();

  if (file && !file.$error) {
    file.upload = Upload.upload({
      url: "/file/v1/upload",
      file: file,
      fields: { tag: tag }
    });

    file.upload.then(
      function (response) {
        $timeout(function () {
          file.result = response.data;
          deferred.resolve(file);
        });
      },
      function (response) {
        if (response.status > 0) {
          partInForm.$setValidity("serverError", false);
          file.progress = 0;
          file.error = response.status + ": " + response.data.message;
          deferred.reject(file.error);
        }
      }
    );

    file.upload.progress(function (evt) {
      file.progress = Math.min(100, parseInt((100.0 * evt.loaded) / evt.total));
    });
  } else {
    deferred.reject("Validation error.");
  }

  return deferred.promise;
};

function addDays(date, days) {
  // http://stackoverflow.com/a/19691491/172696
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

function updateExternalAuditStatus(ea, documents) {
  var newStatus = null;

  var documentsByType = _.groupBy(documents, function (document) {
    return document.type;
  });

  var setStatusByDocument = function (document, docMap) {
    var keys = Object.keys(docMap);
    for (var i = 0; i < keys.length; i++) {
      console.log(document[keys[i]], keys[i], "find set keys")
      if (document[keys[i]]) {
        newStatus = docMap[keys[i]];
      }
    }
  }

  if (ea.date_deadline_compliance) {
    console.log(ea);
    ea.status = 147;
    return true;
  } else if (ea.date_response) {
    ea.status = 146;
    return true;
  } else if (documents.length) {
    console.log(ea);
    if (documentsByType[12]) {
      var document = documentsByType[12][0];
      var docMap = {
        date_submitted: 142,
        date_sent_director: 143,
        date_sent_from_dep: 144,
        date_sent_officer: 145,
      }
    } else if (documentsByType[11]) {
      var document = documentsByType[11][0];
      var docMap = {
        date_submitted: 137,
        date_sent_director: 138,
        date_sent_from_dep: 139,
        date_sent_officer: 140,
        date_conclusion: 141
      }
    }
    setStatusByDocument(document, docMap);
    ea.status = newStatus;
    return true;
  }
  return false;
}

function updateAuditInspectionStatus(ai) {
  // 70 = Created
  // 71 = Carried out
  // 72 = Action taken
  // 73 = Deadline passed
  // 74 = Corrections received
  // 75 = Closed
  if (ai.date_closing) {
    ai.status = 75;
  }
  else if (ai.date_received) {
    ai.status = 74;
  }
  else if (ai.date_deadline && ai.date_deadline < new Date()) {
    ai.status = 73;
  }
  else if (ai.action_taken) {
    ai.status = 72;
  }
  else if (ai.date_carried_out) {
    ai.status = 71;
  }
  // console.log(ai.id, ai.project_id, ai.status, "75 =>", ai.date_closing, "74 =>",ai.date_received, "73 =>",ai.date_deadline, "72 =>",ai.action_taken,"71 =>", ai.date_carried_out, ai.status, "finishing status");

  return ([71, 72, 73, 74, 75].includes(ai.status)) ? true : false;
}
function updateEiaPermitStatus(ep, documents) {
  //if (!scope.userinfo.info.features.notproduction)
  //{
  //    return false;
  //}

  //var values = scope.data.valuelists['eiastatus'];
  //var sorted = _.sortBy(values, function (value)
  //{
  //    return value.value1;
  //});
  //sorted.reverse();

  var oldStatus = ep.status;
  var newStatus = null;

  // EP is only criteria.
  if (ep.date_cancelled) {
    newStatus = 37;
  } else if (ep.certificate_no) {
    newStatus = 36;
  } else if (ep.fee_receipt_no) {
    newStatus = 35;
  } else if (ep.date_fee_notification) {
    newStatus = 34;
  } else if (ep.date_decision) {
    newStatus = 33;
  } else if (ep.date_sent_ded_approval) {
    newStatus = 32;
  }
  // Document is criteria 2.
  else {
    var documentsByType = _.groupBy(documents, function (document) {
      return document.type;
    });
    var newStatusFromDocuments = 0;
    var typePriority = [13, 10, 9, 8];
    var idFromPriority = {
      13: {
        conclusion: 59,
        date_dispatched: 58,
        date_sent_officer: 57,
        date_sent_from_dep: 56,
        date_sent_director: 55,
        date_submitted: 54
      },
      10: {
        date_dispatched: 31,
        date_sent_officer: 30,
        date_sent_from_dep: 29,
        date_sent_director: 28,
        date_submitted: 27
      },
      9: {
        conclusion: 26,
        date_dispatched: 25,
        date_sent_officer: 24,
        date_sent_from_dep: 23,
        date_sent_director: 22,
        date_submitted: 21
      },
      8: {
        conclusion: 20,
        date_dispatched: 19,
        date_sent_officer: 18,
        date_sent_from_dep: 17,
        date_sent_director: 16,
        date_submitted: 15
      }
    };
    _.forEach(typePriority, function (type) {
      var documents = documentsByType[type];
      if (documents) {
        var tempStatus = 0;
        _.forEach(documents, function (d) {
          // Only conclusion if Accepted (78) or Not accepted (79)
          if (
            d.conclusion &&
            _.includes([78, 79], d.conclusion) &&
            idFromPriority[type]["conclusion"]
          ) {
            tempStatus = idFromPriority[type]["conclusion"];
          }
          //else if(d.dispatched)
          //{
          //    newStatus = idFromPriority[type]['dispatched'];
          //}
          else if (d.date_sent_officer) {
            tempStatus = idFromPriority[type]["date_sent_officer"];
          } else if (d.date_sent_from_dep) {
            tempStatus = idFromPriority[type]["date_sent_from_dep"];
          } else if (d.date_sent_director) {
            tempStatus = idFromPriority[type]["date_sent_director"];
          } else if (d.date_submitted) {
            tempStatus = idFromPriority[type]["date_submitted"];
          }

          if (tempStatus > newStatusFromDocuments) {
            newStatusFromDocuments = tempStatus;
          }
        });

        return false;
      }
    });
    //console.log("newStatusFromDocuments", newStatusFromDocuments);
    if (newStatusFromDocuments > 0) {
      newStatus = newStatusFromDocuments;
    }
  }

  if (oldStatus != newStatus) {
    // console.log("Status changed from", oldStatus, "to", newStatus);
    ep.status = newStatus;
    return true;
  }

  // console.log("Status not changed", oldStatus, newStatus);
  return false;
}

function updatePermitLicenseStatus(pl) {
  if (pl.date_permit_license_expired && pl.date_permit_license_expired < new Date()) {
    pl.status = 157;
  } else if (pl.permit_license_no) {
    pl.status = 156;
  } else if (pl.fee_receipt_no) {
    pl.status = 154;
  } else if (pl.date_sent_for_decision) {
    pl.status = 155;
  } else if (pl.date_of_evaluation) {
    pl.status = 153;
  } else if (pl.date_sent_officer) {
    pl.status = 152;
  } else if (pl.date_sent_from_dep) {
    pl.status = 151;
  } else if (pl.date_sent_to_director) {
    pl.status = 150;
  } else if (pl.date_submitted) {
    pl.status = 149;
  }
  return true;
}

function showNavBarItems(show) {
  var el = document.querySelectorAll(".navbar-nav, .navbar-right");
  el[0].style.display = el[1].style.display = show ? "block" : "none";
}

function toggleNavBarItems(userInfo, location) {
  location = location ? location : false;
  var publicPath = '/public/';
  if (location == false) {
    location = {
      path: function () {
        return publicPath;
      }
    }
  }
  if (location.path().startsWith("/public/") == false || (location.path().startsWith("/public/") == true && userInfo.info.name != "Not signed in")) {
    return showNavBarItems(true);
  }
  showNavBarItems(false);
}
window.unsavedDataProtectionIgnoredSubPaths = [
  '#/practitioners',
  '/#/search',
  '#/statistics',
  '#/about',
  '#/advanced',
  '/#/user'
]

window.unsavedDataProtectionIgnoredExactPaths = [
  '#/projects',
]

window.verifyEmailList = function (emailList) {
  var emails = emailList;
  emails = emails.split(";");
  var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var invalidEmails = [];

  for (var i = 0; i < emails.length; i++) {
    emails[i] = emails[i].trim();
    if (emails[i] == "" || !regex.test(emails[i])) {
      invalidEmails.push(emails[i]);
    }
  }

  if (invalidEmails.length != 0) {
    return false;
  }

  return true;
}

window.createEmailOrder = function (orderType, entityId, documentId, callback) {
  fetch('/api/v1/create-email-order/' + (orderType.toLowerCase()) + '/' + entityId + '/' + documentId)
    .then(function (response) {
      return response.json();
    }).then(function (data) {
      fetch("/cron-route").then(function (response) {
        return response.json();
      }).then(function (cronOutput) {
        data.order_status = cronOutput.order_status;
        callback(data);
      });
    });
}

//status is marked by id of of the array
window.emailerStatusObj = [
  {
    index: 0,
    type: "non_existent",
    btnMsg: "Send email",
  },
  {
    index: 1,
    type: "processing",
    btnMsg: "Sending email...",
  }, {
    index: 2,
    type: "processing",
    btnMsg: "Sending email...",
  }, {
    index: 3,
    type: "processed",
    btnMsg: "Email sent",
  }, {
    index: 4,
    type: "failed",
    btnMsg: "Email failed",
  }
]

Number.prototype.countDecimals = function () {
  if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
  return this.toString().split(".")[1].length || 0;
}

Number.prototype.truncateDecimal = function (digits) {
  var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
    m = this.toString().match(re);
  return m ? parseFloat(m[1]) : this.valueOf();
};

Number.prototype.isOneOf = function (compareList) {
  var listLength = compareList.length;
  for (var i = 0; i < listLength; i++) {
    var hasIt = this == compareList[i];
    if (hasIt) {
      break;
    }
  }
  return hasIt;
}


Date.prototype.humanDate = function () {
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  return this.getDate() + ' ' + months[this.getMonth()] + ' ' + this.getFullYear();
}

Array.prototype.searchObj = function (ObjKey, findKey) {
  return this.find(function (item) {
    return item[ObjKey] == findKey
  });
}


window.getAppointmentDate = function () {
  var date = new Date();
  date.setDate(date.getDate() + 7);
  var splitDate = date.humanDate().split(' ');
  //shorten month to conform with date picker.
  splitDate[1] = splitDate[1].substring(0,3);
  var newDate = splitDate.join(' ');
  return newDate;
}