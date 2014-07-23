'use strict';

/* Services */

var version = {"version": "0.0.26"};

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

services.factory('Project', ['$resource', function ($resource)
{
  return $resource('/api/public/v1/project/:projectId', { projectId: '@id' },
    {
      'update': { method:'PUT', isArray: false }
    });
}]);

services.factory('Organisation', ['$resource', function ($resource)
{
  return $resource('/api/public/v1/organisation/:organisationId', { organisationId: '@id' },
    {
      'update': { method:'PUT', isArray: false }
    });
}]);

services.factory('EiaPermit', ['$resource', function ($resource)
{
  return $resource('/api/public/v1/project/:projectId/eiapermit/:id', { projectId: '@projectId', id: '@id' },
    {
      'update': { method:'PUT', isArray: false }
    });
}]);


services.factory('Valuelist', ['$resource', function ($resource)
{
  return $resource('/api/public/v1/valuelist/:id', { id: '@id' });
}]);

services.factory('Valuelists', ['Valuelist', function (Valuelist)
{
  return Valuelist.get({'id': 'all'});
}]);

services.factory('UserInfo', ['$http', '$location', function ($http, $location)
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

services.factory('ProjectFactory', ['$q', 'Project', 'Organisation', 'EiaPermit', function ($q, Project, Organisation, EiaPermit)
{
  var factory = {};
  factory.project = {};
  factory.organisation = {};
  factory.eiaspermits = [];
  factory.eiapermit = {};
  //factory.getEiapermit = {};
  //factory.currentEpId = 0;

  factory.findEiaPermitById = function(eiapermitId)
  {
    var eiapermit = null;
    angular.forEach(factory.eiaspermits, function(ep)
    {
      if (ep.id == eiapermitId)
      {
        eiapermit = ep;
      }
    });
    return eiapermit;
  }

  factory.blahEiaPermit = function(params)
  {
    if (params.eiapermitId)
    {
      var ep = factory.findEiaPermitById(params.eiapermitId);
      if (ep)
      {
        factory.eiapermit = ep;
      }
    }
    else if (eps.length > 0)
    {
      factory.eiapermit = eps[0];
    }
  };

  factory.retrieveProjectData = function(params)
  {
    var deferredProject = $q.defer();
    var deferredOrganisation = $q.defer();
    var deferredEiasPermits = $q.defer();

    if (factory.project.id != params.projectId)
    {
      factory.project = Project.get(params, function(p)
      {
        deferredProject.resolve(p);
        factory.organisation = Organisation.get({organisationId: p.organisation_id}, function(o)
        {
          deferredOrganisation.resolve(o);
        });
      });

      factory.eiaspermits = EiaPermit.query(params, function(eps)
      {
        factory.blahEiaPermit(params);
        deferredEiasPermits.resolve(eps);
      });
    }
    else
    {
      deferredProject.resolve(factory.project);
      deferredOrganisation.resolve(factory.organisation);
      factory.blahEiaPermit(params);
      deferredEiasPermits.resolve(factory.eiaspermits);
    }
    return [deferredProject.promise, deferredOrganisation.promise, deferredEiasPermits.promise];
  };

  factory.setOrganisation = function(o)
  {
    var deferred = $q.defer();
    factory.organisation = o;
    o.$get({}, function(o)
    {
      deferred.resolve(o);
    });
    return deferred.promise;
  };

  factory.setEiaPermit = function(ep)
  {
    var deferred = $q.defer();
    factory.eiapermit = ep;
//    ep.$get({}, function(ep)
//    {
//      deferred.resolve(ep);
//    });
    deferred.resolve(ep);
    return deferred.promise;
  };

  factory.empty = function()
  {
    factory.project = {};
    factory.organisation = {};
    factory.eiaspermits = [];
    factory.eiapermit = {};
    factory.currentEpId = 0;
  };

  factory.createNewProject = function(o)
  {
    var pData =
    {
      has_industrial_waste_water:41, // 41=No
      organisation_id: o.id,
      is_new:true
    };
    factory.project = new Project(pData);
  };

  factory.createNewOrganisation = function()
  {
    var oData =
    {
      is_new:true
    };
    factory.organisation = new Organisation(oData);
  };

  factory.save = function(form, resource)
  {
    var deferred = $q.defer();
    if (resource.is_new)
    {
      resource.$save({}, function(data)
      {
        deferred.resolve(data);
      }, function()
      {
        deferred.reject("Saving new failed");
      });
    }
    else
    {
      resource.$update({}, function(data)
      {
        deferred.resolve(data);
      }, function()
      {
        deferred.reject("Saving exisiting failed");
      });
    }
    return deferred.promise;
  };

  return factory;
}]);