'use strict';

/* Services */

var version = {"version": "0.0.17"};

// Demonstrate how to register services
// In this case it is a simple value service.
var services = angular.module('seroApp.services', []).
  value("version", version.version);

services.factory('Practitioner', ['$resource', function ($resource)
{
  // TODO: Use anything to auth? (for example auth-token).
  // {headers: { 'auth-token': 'C3PO R2D2' }}
  return $resource('/api/public/v1/practitioner/:id', { id: '@id' },
    {
      'update': { method:'PUT', isArray: false }
    });
}]);

services.factory('Valuelist', ['$resource', function ($resource)
{
  // {headers: { 'auth-token': 'C3PO R2D2' }}
  return $resource('/api/public/v1/valuelist/:id', { id: '@id' });
}]);

services.service('UserInfo', ['$http', '$location', function ($http, $location)
{
  var userinfo = {info:{}};
  var emptyInfo =
  {
    "full_name": "Not signed in",
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

  var gotoRootIfSignedInAndOnNotSignedInPath = function()
  {
    if ($location.path() == '/notsignedin')
    {
      $location.path("/");
    }
  }

  var gotoNotSignedIn = function()
  {
    $location.path("/notsignedin");
  }

  var setUserInfo = function(data)
  {
    if (data)
    {
      _.merge(userinfo.info, data);
      gotoRootIfSignedInAndOnNotSignedInPath();
    }
    else
    {
      userinfo.info = _.cloneDeep(emptyInfo);
    }
  };
  var getUserInfo = function()
  {
    $http.get('/api/public/user/info')
      .success(setUserInfo)
      .error(gotoNotSignedIn);
  };

  userinfo.impersonate = function(id)
  {
    setUserInfo(null);
    $http.get('/api/public/user/impersonate/'+id)
      .success(setUserInfo);
  };

  userinfo.signout = function()
  {
    $http.get('/api/public/signout')
      .success(function()
      {
        setUserInfo(null);
        $location.path("/notsignedin");
      });
  };

  userinfo.getAllUsers = function()
  {
    $http.get('/api/public/user/all')
      .success(function(data)
      {
        userinfo.allusers = data;
      });
  };

  setUserInfo(null);
  getUserInfo();
  return userinfo;
}]);