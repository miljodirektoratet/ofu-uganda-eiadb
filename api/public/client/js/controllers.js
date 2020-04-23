'use strict';

/* Controllers */

var controllers = angular.module('seroApp.controllers');

controllers.controller('DatePickerController', ['$scope', function (scope)
{
    scope.open = function ($event)
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

controllers.controller('DatePickerSearchController', ['$scope', function (scope)
{
    scope.open = function ($event)
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



controllers.controller('NavBarController', ['$scope', '$location', 'UserInfo','EnvInfo', function (scope, location, UserInfo, EnvInfo)
{
    scope.userinfo = UserInfo;

    scope.$watch('userinfo', function(newUserInfo, oldName) {
        if (location.path() != '/public/practitioners' || (location.path() == '/public/practitioners' && newUserInfo.info.name != "Not signed in") ) {
            var el = document.querySelectorAll(".navbar-nav, .navbar-right");
            el[0].style.display =  el[1].style.display = "block";
        }
    });

    EnvInfo(function(env){scope.envinfo = env.env})
    scope.isActive = function (viewLocation)
    {
        return viewLocation === location.path();
    };
    scope.isAdvancedActive = function (viewLocation)
    {
        return location.path().indexOf(viewLocation) == 0;
    };
}]);

controllers.controller('HomeController', ['$scope', 'GeneralStatistics', function (scope, GeneralStatistics)
{
    scope.counts = {};

    GeneralStatistics.get({}, function (data)
    {
        scope.counts = data.counts;
    });
}]);

controllers.controller('UserController', ['$scope', 'UserInfo', function (scope, UserInfo)
{
    scope.userinfo = UserInfo;
    scope.userid_to_impersonate = null;
    scope.impersonate = function ()
    {
        scope.userinfo.impersonate(scope.userid_to_impersonate);
    };
}]);