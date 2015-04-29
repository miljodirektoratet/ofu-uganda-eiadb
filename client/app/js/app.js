'use strict';

var debug = true;

// Declare app level module which depends on filters, and services
var seroApp = angular.module('seroApp', [
  'ngRoute',
  'ngResource',
  'ngAnimate',
  'ui.bootstrap',
  'ui.select2',
  'seroApp.services',
  'seroApp.directives',
  'seroApp.controllers',
  'pax.validations'
]).
config(['$routeProvider', function($routeProvider)
{
  var projectTabsOptions = {templateUrl: 'partials/projectTabs.html', controller: 'ProjectTabsController'};

  $routeProvider.when('/', {templateUrl: 'partials/home.html'});
  $routeProvider.when('/projects', {templateUrl: 'partials/projects.html', controller: 'ProjectsController'});
  $routeProvider.when('/projects/:projectId', projectTabsOptions);
  $routeProvider.when('/projects/:projectId/eiaspermits', projectTabsOptions);
  $routeProvider.when('/projects/:projectId/eiaspermits/:eiapermitId', projectTabsOptions);
  $routeProvider.when('/projects/:projectId/auditsinspections', projectTabsOptions);
  $routeProvider.when('/projects/:projectId/reports', projectTabsOptions);
  //$routeProvider.when('/projects/:id', {templateUrl: 'partials/project.html', controller: 'ProjectTabController'});
  //$routeProvider.when('/projects/:projectId/eiaspermits', {templateUrl: 'partials/project.html', controller: 'EiaPermitTabController'});



  //$routeProvider.when('/projects/:projectId/eiaspermits/:id', {templateUrl: 'partials/project.html'});

  $routeProvider.when('/about', {templateUrl: 'partials/about.html'});
  $routeProvider.when('/login', {templateUrl: 'partials/login.html', controller: 'UserController'});
  $routeProvider.when('/password/send', {templateUrl: 'partials/passwordSend.html', controller: 'LoginController'});
  $routeProvider.when('/password/reset/:token', {templateUrl: 'partials/passwordReset.html', controller: 'LoginController'});
  $routeProvider.when('/user', {templateUrl: 'partials/user.html', controller: 'UserController'});
  $routeProvider.when('/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
  $routeProvider.otherwise({redirectTo: '/'});
}])
.factory('authHttpResponseInterceptor',['$q','$location',function($q,$location){
  return {

    'responseError': function(rejection)
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
  .config(['$httpProvider',function($httpProvider)
  {
    $httpProvider.interceptors.push('authHttpResponseInterceptor');
  }]);


var SavingStateEnum =
{
  None : 'None',
  Loading : 'Loading',
  Loaded : 'Loaded',
  SavingStarted : 'Saving started',
  SavingFinished : 'Saving finished',
  SavingFailed : 'Saving failed',
  Invalid : 'Form not valid',
  MissingDependency : 'Missing dependency in other form'
};

var ProjectTabEnum =
{
  Project : 'Project',
  EiasPermits : 'Eias and Permits',
  AuditsInspections : 'Audits and Inspections',
  Reports : 'Reports'
};

//var regexIso8601 = /^(\d{4}|\+\d{6})(?:-(\d{2})(?:-(\d{2})(?:T(\d{2}):(\d{2}):(\d{2})\.(\d{1,})(Z|([\-+])(\d{2}):(\d{2}))?)?)?)?$/;
var regexIso8601 = /^(\d{4}-\d{2}-\d{2} \d{2}\:\d{2}\:\d{2})$/;
function convertDateStringsToDates(input) {
  // Ignore things that aren't objects.
  if (typeof input !== "object") return input;

  for (var key in input) {
    if (!input.hasOwnProperty(key)) continue;

    var value = input[key];
    var match;
    // Check for string properties which look like dates.
    if (typeof value === "string" && (match = value.match(regexIso8601)))
    {
      var dateParts = match[0].split(" ");
      input[key] = dateParts[0];
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

seroApp.config(["$httpProvider", function ($httpProvider) {
  $httpProvider.defaults.transformResponse.push(function(responseData){
    convertDateStringsToDates(responseData);
    return responseData;
  });
}]);