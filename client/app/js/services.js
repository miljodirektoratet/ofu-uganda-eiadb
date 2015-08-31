'use strict';

/* Services */

var version = {"version": "0.1.17"};

var services = angular.module('seroApp.services', []);

services.value("version", version.version);


services.factory('Practitioner', ['$resource', function ($resource)
{
    // TODO: Use anything to auth? (for example auth-token).
    // {headers: { 'auth-token': 'C3PO R2D2' }}
    return $resource('/api/v1/practitioner/:id', {id: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('Project', ['$resource', function ($resource)
{
    return $resource('/api/v1/project/:projectId', {projectId: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('Organisation', ['$resource', function ($resource)
{
    return $resource('/api/v1/organisation/:organisationId', {organisationId: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('EiaPermit', ['$resource', function ($resource)
{
    return $resource('/api/v1/project/:projectId/eiapermit/:eiapermitId', {eiapermitId: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('Document', ['$resource', function ($resource)
{
    return $resource('/api/v1/project/:projectId/eiapermit/:eiapermitId/document/:documentId', {documentId: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('AuditInspection', ['$resource', function ($resource)
{
    return $resource('/api/v1/project/:projectId/auditinspection/:auditinspectionId', {auditinspectionId: '@id'},
        {
            'update': {method: 'PUT', isArray: false}
        });
}]);

services.factory('Valuelist', ['$resource', function ($resource)
{
    return $resource('/api/v1/valuelist/:id', {id: '@id'});
}]);

services.factory('Valuelists', ['Valuelist', function (Valuelist)
{
    return Valuelist.get({'id': 'all'});
}]);

services.factory('UserInfo', ['$http', '$location', function ($http, $location)
{
    var userinfo = {info: {}};
    var emptyInfo =
    {
        "name": "Not signed in",
        "role_1": false,
        "role_2": false,
        "role_3": false,
        "role_4": false,
        "role_5": false,
        "role_6": false,
        "role_7": false,
        "role_8": false,
        "roles": []
    };

    var setUserInfo = function (data)
    {
        if (data)
        {
            _.merge(userinfo.info, data);
            if ($location.path() == '/login')
            {
                $location.path("/");
            }
        }
        else
        {
            userinfo.info = _.cloneDeep(emptyInfo);
        }
    };
    var getUserInfo = function ()
    {
        $http.get('/user/info').success(setUserInfo);
    };

    userinfo.impersonate = function (id)
    {
        setUserInfo(null);
        $http.get('/user/impersonate/' + id).success(setUserInfo);
    };

    userinfo.signout = function ()
    {
        $http.get('/auth/logout')
            .success(function ()
            {
                setUserInfo(null);
                $location.path("/login");
            });
    };

    userinfo.getAllUsers = function ()
    {
        $http.get('/user/all').success(function (data)
        {
            userinfo.allusers = data;
        });
    };

    userinfo.reTry = function ()
    {
        getUserInfo();
    };


    setUserInfo(null);
    getUserInfo();
    return userinfo;
}]);