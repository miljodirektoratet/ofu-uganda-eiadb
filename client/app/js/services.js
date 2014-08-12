'use strict';

/* Services */

var version = {"version": "0.0.37"};

// Demonstrate how to register services
// In this case it is a simple value service.
var services = angular.module('seroApp.services', []);

services.value("version", version.version);


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
  return $resource('/api/public/v1/project/:projectId/eiapermit/:eiapermitId', { eiapermitId: '@id' },
    {
      'update': { method:'PUT', isArray: false }
    });
}]);

services.factory('Document', ['$resource', function ($resource)
{
  return $resource('/api/public/v1/project/:projectId/eiapermit/:eiapermitId/document/:documentId', { documentId: '@id' },
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

services.factory('ProjectFactory', ['$q', '$filter', 'Project', 'Organisation', 'EiaPermit', 'Document', 'Valuelists', function ($q, $filter, Project, Organisation, EiaPermit, Document, Valuelists)
{
  var factory = {};
  factory.project = {};
  factory.organisation = {};
  factory.eiaspermits = [];
  factory.eiapermit = {};
  factory.documents = [];
  factory.document = {};
  factory.valuelists = Valuelists;

  factory.retrieveProjectData = function(params)
  {
    var deferredProject = $q.defer();
    var deferredOrganisation = $q.defer();
    var deferredEiasPermits = $q.defer();
    var deferredEiaPermit =  $q.defer();

    if (factory.project.id != params.projectId)
    {
      factory.empty();
      factory.project = Project.get(params, function(p)
      {
        deferredProject.resolve(p);
        factory.organisation = Organisation.get({organisationId: p.organisation_id}, function(o)
        {
          deferredOrganisation.resolve(o);
        });
      });

      // params contains eiapermitId, so we can't user params directly.
      factory.eiaspermits = EiaPermit.query(_.omit(params, 'eiapermitId'), function(eps)
      {
        factory.retrieveEiaPermit(params).then(function(ep)
        {
          deferredEiaPermit.resolve(ep);
        });
        deferredEiasPermits.resolve(eps);
      });
    }
    else
    {
      deferredProject.resolve(factory.project);
      deferredOrganisation.resolve(factory.organisation);
      factory.retrieveEiaPermit(params).then(function(ep)
      {
        deferredEiaPermit.resolve(ep);
      });
      deferredEiasPermits.resolve(factory.eiaspermits);
    }
    return [deferredProject.promise, deferredOrganisation.promise, deferredEiasPermits.promise, deferredEiaPermit.promise];
  };

  factory.retrieveEiaPermit = function(params)
  {
    var deferred = $q.defer();
    if (params.eiapermitId)
    {
      var hits = $filter('filter')(factory.eiaspermits, {'id':params.eiapermitId});
      if (hits.length==1)
      {
        factory.eiapermit = hits[0];
        factory.eiapermit.$get(params, function(ep)
        {
          factory.documents = Document.query(params, function(ds)
          {

          });
          deferred.resolve(ep);
        });
      }
    }
    else if (factory.eiaspermits.length > 0)
    {
      if (_.isEmpty(factory.eiapermit))
      {
        factory.eiapermit = factory.eiaspermits[0];
      }
    }
    return deferred.promise;
  };

  factory.getEiapermitSummary = function(ep)
  {
    var ep = ep || factory.eiapermit;
    if (_.isEmpty(ep))
    {
      return "";
    }
    var statusPart = "";
    var status = _.find(factory.valuelists["status"], {'id': ep.status});
    if (status)
    {
      statusPart = status.description1;
    }
    return "Status: " + statusPart;
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
    factory.documents = [];
    factory.document = {};
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

  factory.createNewEiaPermit = function(p)
  {
    var epData =
    {
      project_id: p.id,
      is_new:true
    };
    factory.eiapermit = new EiaPermit(epData);
    factory.eiaspermits.push(factory.eiapermit);
  };

  factory.createNewDocument = function(ep)
  {
    var dData =
    {
      eia_permit_id: ep.id,
      is_new:true
    };
    factory.document = new Document(dData);
    factory.documents.unshift(factory.document);
  };

  factory.save = function(params, form, resource)
  {
    var deferred = $q.defer();
    if (resource.is_new)
    {
      var saveParams = _.omit(params, function(value) {
        return value == "new";
      });
      resource.$save(saveParams, function(data)
      {
        deferred.resolve(data);
      }, function()
      {
        deferred.reject("Saving new failed");
      });
    }
    else
    {
      resource.$update(params, function(data)
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