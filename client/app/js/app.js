'use strict';

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
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: 'partials/home.html'});
  $routeProvider.when('/projects', {templateUrl: 'partials/projects.html', controller: 'ProjectsController'});
  $routeProvider.when('/projects/:id', {templateUrl: 'partials/project.html', controller: 'ProjectController'});
  $routeProvider.when('/about', {templateUrl: 'partials/about.html'});
  $routeProvider.when('/notsignedin', {templateUrl: 'partials/notsignedin.html', controller: 'UserController'});
  $routeProvider.when('/user', {templateUrl: 'partials/user.html', controller: 'UserController'});
  $routeProvider.when('/advanced/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);