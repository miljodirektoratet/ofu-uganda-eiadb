'use strict';

// Declare app level module which depends on filters, and services
var seroApp = angular.module('seroApp', [
  'ngRoute',
  'ngResource',
  'ngAnimate',
  'ui.bootstrap',
  'seroApp.services',
  'seroApp.directives',
  'seroApp.controllers',
  'pax.validations'
]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/', {templateUrl: 'partials/home.html'});
  $routeProvider.when('/advanced1', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced2', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced3', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/advanced4', {templateUrl: 'partials/advanced.html'});
  $routeProvider.when('/about', {templateUrl: 'partials/about.html'});
  $routeProvider.when('/notsignedin', {templateUrl: 'partials/notsignedin.html', controller: 'UserController'});
  $routeProvider.when('/user', {templateUrl: 'partials/user.html', controller: 'UserController'});
  $routeProvider.when('/advanced/practitioners', {templateUrl: 'partials/practitioners.html', controller: 'PractitionersController'});
  $routeProvider.otherwise({redirectTo: '/'});
}]);

//myApp.config(['$resourceProvider', function ($resourceProvider) {
//  // Don't strip trailing slashes from calculated URLs
//  $resourceProvider.defaults.stripTrailingSlashes = false;
//}]);

seroApp.controller('NavBarController', ['$scope', '$location', 'UserInfo', function(scope, location, UserInfo)
{
  scope.isActive = function (viewLocation)
  {
    return viewLocation === location.path();
  };
  scope.isAdvancedActive = function (viewLocation)
  {
    return location.path().indexOf(viewLocation) == 0;
  };
  scope.userinfo = UserInfo;
}]);

seroApp.controller('UserController', ['$scope', 'UserInfo', function(scope, UserInfo)
{
  scope.userinfo = UserInfo;
  scope.userid_to_impersonate = null;
  scope.impersonate = function()
  {
    scope.userinfo.impersonate(scope.userid_to_impersonate);
  };
}]);

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




