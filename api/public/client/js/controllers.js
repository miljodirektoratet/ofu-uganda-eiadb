'use strict';

/* Controllers */

var controllers = angular.module('seroApp.controllers');

controllers.controller('DatePickerController', ['$scope', function (scope)
{
    scope.open = function($event)
    {
        $event.preventDefault();
        $event.stopPropagation();
        scope.opened = true;
    };
    scope.datepickerOptions =
    {
        startingDay: 1
        //,showButtonBar: false // Not working
    };
}]);


controllers.controller('NavBarController', ['$scope', '$location', 'UserInfo', function(scope, location, UserInfo)
{
    scope.userinfo = UserInfo;

    scope.isActive = function (viewLocation)
    {
        return viewLocation === location.path();
    };
    scope.isAdvancedActive = function (viewLocation)
    {
        return location.path().indexOf(viewLocation) == 0;
    };
    scope.hasAccess = function(viewLocation)
    {
        return scope.userinfo.info.role_8;
    };
}]);

controllers.controller('UserController', ['$scope', 'UserInfo', function(scope, UserInfo)
{
    scope.userinfo = UserInfo;
    scope.userid_to_impersonate = null;
    scope.impersonate = function()
    {
        scope.userinfo.impersonate(scope.userid_to_impersonate);
    };
}]);