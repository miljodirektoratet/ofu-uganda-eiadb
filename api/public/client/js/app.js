'use strict';

var debug = true;

angular.module('seroApp.services', []);
angular.module('seroApp.directives', []);
angular.module('seroApp.controllers', []);
angular.module('pax.validations', []);

// Declare app level module which depends on filters, and services
var seroApp = angular.module('seroApp', [
    'ngRoute',
    'ngResource',
    'ngAnimate',
    'ngMessages',
    'ngSanitize',
    'ui.bootstrap',
    'ui.select2',
    // 'ui.select',
    'ngFileUpload',
    'ui.grid', 'ui.grid.edit', 'ui.grid.rowEdit', 'ui.grid.cellNav', 'ui.grid.resizeColumns', 'ui.grid.moveColumns', 'ui.grid.selection',
    'seroApp.services',
    'seroApp.directives',
    'seroApp.controllers',
    'pax.validations'
]).
    config(['$routeProvider', function ($routeProvider)
    {
        var projectTabsOptions = {templateUrl: 'partials/projectTabs.html', controller: 'ProjectTabsController'};

        $routeProvider.when('/', {templateUrl: 'partials/home.html', controller: 'HomeController'});
        $routeProvider.when('/projects', {templateUrl: 'partials/projects.html', controller: 'ProjectsController'});
        $routeProvider.when('/projects/:projectId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId/documents', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId/hearings', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId/documents/:documentId/hearings/:hearingId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/externalaudits', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/externalaudits/:externalauditId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/externalaudits/:externalauditId/documents', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/externalaudits/:externalauditId/documents/:documentId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/auditsinspections', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/auditsinspections/:auditinspectionId', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/permitslicenses', projectTabsOptions);
        $routeProvider.when('/projects/:projectId/permitslicenses/:permitlicenseId', projectTabsOptions);


        var searchTabsOptions = {templateUrl: 'partials/searchTabs.html', controller: 'SearchTabsController'};
        $routeProvider.when('/search', {redirectTo: '/search/projects'});
        $routeProvider.when('/search/projects', searchTabsOptions);
        $routeProvider.when('/search/eiaspermits', searchTabsOptions);
        $routeProvider.when('/search/permitslicenses', searchTabsOptions);
        $routeProvider.when('/search/auditsinspections', searchTabsOptions);
        $routeProvider.when('/search/externalaudits', searchTabsOptions);

        var statisticsTabsOptions = {templateUrl: 'partials/statisticsTabs.html', controller: 'StatisticsTabsController'};
        $routeProvider.when('/statistics', {redirectTo: '/statistics/projects'});
        $routeProvider.when('/statistics/projects', statisticsTabsOptions);

        $routeProvider.when('/advanced/codes', {templateUrl: 'partials/advancedCodes.html', controller: 'AdvancedCodesController'});
        $routeProvider.when('/advanced/users', {templateUrl: 'partials/advancedUsers.html', controller: 'AdvancedUsersController'});
        $routeProvider.when('/advanced/leadagencies', {templateUrl: 'partials/advancedLeadAgency.html', controller: 'AdvancedLeadAgenciesController'});

        $routeProvider.when('/pirking', {templateUrl: 'partials/pirking.html', controller: 'PirkingController'});

        $routeProvider.when('/about', {templateUrl: 'partials/about.html'});
        $routeProvider.when('/login', {templateUrl: 'partials/login.html', controller: 'UserController'});
        $routeProvider.when('/password/send', {templateUrl: 'partials/passwordSend.html', controller: 'LoginController'});
        $routeProvider.when('/password/reset/:token', {templateUrl: 'partials/passwordReset.html', controller: 'LoginController'});
        $routeProvider.when('/user', {templateUrl: 'partials/user.html', controller: 'UserController'});
        $routeProvider.when('/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
        $routeProvider.otherwise({redirectTo: '/'});
    }])
    .factory('authHttpResponseInterceptor', ['$q', '$location', function ($q, $location)
    {
        return {

            'responseError': function (rejection)
            {
                if ($location.path().indexOf('/password/reset/') == 0)
                {
                    // No redirect.
                }
                else if (rejection.status === 401)
                {
                    $location.path('/login');
                }
                return $q.reject(rejection);
            }
        }
    }])
    .config(['$httpProvider', function ($httpProvider)
    {
        $httpProvider.interceptors.push('authHttpResponseInterceptor');
    }]);


var SavingStateEnum =
{
    None: 'None',
    LoadingNew: 'Loading new',
    Loading: 'Loading',
    Loaded: 'Loaded',
    SavingStarted: 'Saving started',
    SavingFinished: 'Saving finished',
    SavingFailed: 'Saving failed',
    Invalid: 'Form not valid',
    MissingDependency: 'Missing dependency in other form'
};

var ProjectTabEnum =
{
    Project: 'Project',
    EiasPermits: 'EIAS',
    PermitsLicenses: 'Permits and Licenses',
    AuditsInspections: 'Audits and Inspections',
    ExternalAudits: 'External audits'
};

var EiasPermitsTabEnum =
{
    EiaPermit: 'EIA',
    Documents: 'Documents',
    Hearings: 'Hearings'
};

var ExternalAuditsTabEnum =
    {
        ExternalAudit: 'External audit',
        Documents: 'Documents',
        Hearings: 'Hearings'
    };

var SearchTabEnum =
{
    Projects: 'Projects',
    EiasPermits: 'EIAS',
    PermitsLicenses: 'Permits and Licenses',
    AuditsInspections: 'Audits and Inspections',
    ExternalAudits: 'External audits'
};

var StatisticsTabEnum =
{
    Projects: 'Projects',
    EiasPermits: 'EIAS',
    AuditsInspections: 'Audits and Inspections'
};

var DocumentTagEnum =
{
    PermitLicenseApplicationForm: 'Application form',
    PermitLicensePermitLicense: 'Permit or license',
    PermitLicenseAttachments: 'Attachment to the application'

};

var fileUploadPattern = "image/*,application/pdf,application/vnd.openxmlformats*,application/msword,text/plain,text/csv,application/octet-stream,binary/octet-stream";
var fileUploadNgfPattern = "'image/*,application/pdf,application/vnd.openxmlformats*,application/msword,text/plain,text/csv,application/octet-stream,binary/octet-stream'";
var fileUploadMaxSize = "20MB";


//var regexIso8601 = /^(\d{4}|\+\d{6})(?:-(\d{2})(?:-(\d{2})(?:T(\d{2}):(\d{2}):(\d{2})\.(\d{1,})(Z|([\-+])(\d{2}):(\d{2}))?)?)?)?$/;
var regexIso8601 = /^(\d{4}-\d{2}-\d{2} \d{2}\:\d{2}\:\d{2})$/;
function convertDateStringsToDates(input)
{
    // Ignore things that aren't objects.
    if (typeof input !== "object")
    {
        return input;
    }

    for (var key in input)
    {
        if (!input.hasOwnProperty(key))
        {
            continue;
        }

        var value = input[key];
        var match;
        // Check for string properties which look like dates.
        if (typeof value === "string" && (match = value.match(regexIso8601)))
        {
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
        }
        else if (typeof value === "object")
        {
            // Recurse into object
            convertDateStringsToDates(value);
        }
    }
}

seroApp.config(["$httpProvider", function ($httpProvider)
{
    $httpProvider.defaults.transformResponse.push(function (responseData)
    {
        convertDateStringsToDates(responseData);
        return responseData;
    });
}]);

var uploadFile = function ($q, $timeout, Upload, partInForm, file, tag)
{
    partInForm.$setValidity("serverError", true);

    var deferred = $q.defer();

    if (file && !file.$error)
    {
        file.upload = Upload.upload({
            url: '/file/v1/upload',
            file: file,
            fields: {tag:tag}
        });

        file.upload.then(function (response)
        {
            $timeout(function ()
            {
                file.result = response.data;
                deferred.resolve(file);
            });
        }, function (response)
        {
            if (response.status > 0)
            {
                partInForm.$setValidity("serverError", false);
                file.progress = 0;
                file.error = response.status + ': ' + response.data.message;
                deferred.reject(file.error);
            }
        });

        file.upload.progress(function (evt)
        {
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    }
    else
    {
        deferred.reject("Validation error.");
    }

    return deferred.promise;
};

function addDays(date, days)
{
    // http://stackoverflow.com/a/19691491/172696
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

function updateEiaPermitStatus(ep, documents)
{
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
    if (ep.date_cancelled)
    {
        newStatus = 37;
    }
    else if (ep.certificate_no)
    {
        newStatus = 36;
    }
    else if (ep.fee_receipt_no)
    {
        newStatus = 35;
    }
    else if (ep.date_fee_notification)
    {
        newStatus = 34;
    }
    else if (ep.date_decision)
    {
        newStatus = 33;
    }
    else if (ep.date_sent_ded_approval)
    {
        newStatus = 32;
    }
    // Document is criteria 2.
    else
    {
        var documentsByType = _.groupBy(documents, function (document)
        {
            return document.type;
        });
        var newStatusFromDocuments = 0;
        var typePriority = [13, 10, 9, 8];
        var idFromPriority = {
            13: {'conclusion': 59, 'date_dispatched': 58, 'date_sent_officer': 57, 'date_sent_from_dep': 56, 'date_sent_director': 55, 'date_submitted': 54},
            10: {'date_dispatched': 31, 'date_sent_officer': 30, 'date_sent_from_dep': 29, 'date_sent_director': 28, 'date_submitted': 27},
            9: {'conclusion': 26, 'date_dispatched': 25, 'date_sent_officer': 24, 'date_sent_from_dep': 23, 'date_sent_director': 22, 'date_submitted': 21},
            8: {'conclusion': 20, 'date_dispatched': 19, 'date_sent_officer': 18, 'date_sent_from_dep': 17, 'date_sent_director': 16, 'date_submitted': 15}
        };
        _.forEach(typePriority, function (type)
        {
            var documents = documentsByType[type];
            if (documents)
            {
                var tempStatus = 0;
                _.forEach(documents, function (d)
                {
                    // Only conclusion if Accepted (78) or Not accepted (79)
                    if (d.conclusion && _.includes([78, 79], d.conclusion) && idFromPriority[type]['conclusion'])
                    {
                        tempStatus = idFromPriority[type]['conclusion'];
                    }
                    //else if(d.dispatched)
                    //{
                    //    newStatus = idFromPriority[type]['dispatched'];
                    //}
                    else if (d.date_sent_officer)
                    {
                        tempStatus = idFromPriority[type]['date_sent_officer'];
                    }
                    else if (d.date_sent_from_dep)
                    {
                        tempStatus = idFromPriority[type]['date_sent_from_dep'];
                    }
                    else if (d.date_sent_director)
                    {
                        tempStatus = idFromPriority[type]['date_sent_director'];
                    }
                    else if (d.date_submitted)
                    {
                        tempStatus = idFromPriority[type]['date_submitted'];
                    }

                    if (tempStatus > newStatusFromDocuments)
                    {
                        newStatusFromDocuments = tempStatus;
                    }
                });

                return false;
            }
        });
        //console.log("newStatusFromDocuments", newStatusFromDocuments);
        if (newStatusFromDocuments > 0)
        {
            newStatus = newStatusFromDocuments;
        }
    }

    if (oldStatus != newStatus)
    {
        // console.log("Status changed from", oldStatus, "to", newStatus);
        ep.status = newStatus;
        return true;
    }

    // console.log("Status not changed", oldStatus, newStatus);
    return false;
};