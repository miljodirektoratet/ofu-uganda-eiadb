'use strict';

controllers.controller('LoginController', ['$scope', '$http', '$routeParams', '$location', 'UserInfo', '$timeout', function (scope, http, routeParams, $location, UserInfo, $timeout)
{
    scope.loginData = {};
    scope.sendData = {};
    scope.resetData = {};
    scope.loginMessages = [];
    scope.sendMessages = [];
    scope.resetMessages = [];
    scope.loginFormDisabled = false;
    scope.sendFormDisabled = false;
    scope.resetFormDisabled = false;

    scope.forgot = function ()
    {
        console.debug('/password/email');
    };

    var flattenMessages = function (data)
    {
        return _.flatten(_.values(data));
    };

    scope.login = function ()
    {
        if (scope.loginForm.$invalid)
        {
            return;
        }
        scope.loginFormDisabled = true;
        http.post('/auth/login', scope.loginData).
            success(function (data, status, headers, config)
            {
                scope.loginMessages = flattenMessages(data);
                UserInfo.reTry();
                $location.path("/");
            }).
            error(function (data, status, headers, config)
            {
                scope.loginMessages = flattenMessages(data);
                scope.loginFormDisabled = false;
            });
    };

    scope.send = function ()
    {
        if (scope.sendForm.$invalid)
        {
            return;
        }
        scope.sendFormDisabled = true;
        http.post('/password/email', scope.sendData).
            success(function (data, status, headers, config)
            {
                scope.sendMessages = flattenMessages(data);
            }).
            error(function (data, status, headers, config)
            {
                scope.sendMessages = flattenMessages(data);
                scope.sendFormDisabled = false;
            });
    };

    scope.reset = function ()
    {
        if (scope.resetForm.$invalid)
        {
            return;
        }
        scope.resetFormDisabled = true;
        scope.resetData.token = routeParams.token;
        http.post('/password/reset', scope.resetData).
            success(function (data, status, headers, config)
            {
                scope.resetMessages = flattenMessages(data);
                UserInfo.reTry();
                $location.path("/user");
            }).
            error(function (data, status, headers, config)
            {
                scope.resetMessages = flattenMessages(data);
                scope.resetFormDisabled = false;
            });
    };

    $timeout(function()
    {
        //scope.isFocused = true;
    });


}]);