'use strict';

// Declare app level module which depends on filters, and services
var seroApp = angular.module('seroApp', [
  'ngRoute',
  'ngResource',
  'ngAnimate',
  'ui.bootstrap',
  'seroApp.services',
  'seroApp.directives',
  'seroApp.controllers'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: 'partials/home.html'});
  $routeProvider.when('/advanced1', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced2', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced3', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced4', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/about', {templateUrl: 'partials/about.html'});
  $routeProvider.when('/user', {templateUrl: 'partials/user.html'});
  $routeProvider.when('/advanced/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);

//myApp.config(['$resourceProvider', function ($resourceProvider) {
//  // Don't strip trailing slashes from calculated URLs
//  $resourceProvider.defaults.stripTrailingSlashes = false;
//}]);

seroApp.controller('NavBarController', ['$scope', '$location', function(scope, location)
{
  scope.isActive = function (viewLocation)
  {
    return viewLocation === location.path();
  };
  scope.isAdvancedActive = function (viewLocation)
  {
    return location.path().indexOf(viewLocation) == 0;
  };
}
]);

/*
  .controller('PractitionersController', ['$scope', 'PractitionersService', function (scope, PractitionersService)
  {
    scope.practitioners = PractitionersService.query();
  }])*/

/*
function NavBarController($scope, $location)
{
  $scope.isActive = function (viewLocation)
  {
    return viewLocation === $location.path();
  };
  $scope.isAdvancedActive = function (viewLocation)
  {
    return $location.path().indexOf(viewLocation) == 0;
  };
}*/




