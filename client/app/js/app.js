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
  $routeProvider.when('/notsignedin', {templateUrl: 'partials/notsignedin.html', controller: 'UserController'});
  $routeProvider.when('/user', {templateUrl: 'partials/user.html', controller: 'UserController'});
  $routeProvider.when('/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);

var SavingStateEnum =
{
  None : 'None',
  Loading : 'Loading',
  Loaded : 'Loaded',
  SavingStarted : 'Saving started',
  SavingFinished : 'Saving finished',
  SavingFailed : 'Saving failed',
  Invalid : 'Form not valid'
};

var ProjectTabEnum =
{
  Project : 'Project',
  EiasPermits : 'Eias and Permits',
  AuditsInspections : 'Audits and Inspections',
  Reports : 'Reports'
};
