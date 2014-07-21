'use strict';

/* Controllers */


var SavingStateEnum =
{
  Loading : 'Loading',
  Loaded : 'Loaded',
  SavingStarted : 'Saving started',
  SavingFinished : 'Saving finished',
  SavingFailed : 'Saving failed',
  Invalid : 'Form not valid'
};




var controllers = angular.module('seroApp.controllers', []);

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

controllers.controller('UserController', ['$scope', 'UserInfo', function(scope, UserInfo)
{
  scope.userinfo = UserInfo;
  scope.userid_to_impersonate = null;
  scope.impersonate = function()
  {
    scope.userinfo.impersonate(scope.userid_to_impersonate);
  };
}]);

controllers.controller('ProjectsController', ['$scope', '$location', '$filter', 'Project', 'UserInfo', function (scope, location, filter, Project, UserInfo)
{
  scope.projects = Project.query();
  scope.userinfo = UserInfo;
  scope.goto = function(path)
  {
    location.path(path);
  };

  scope.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };

}]);

controllers.controller('ProjectController', ['$scope', '$routeParams', '$filter', '$q', '$animate', 'UserInfo', 'Project', 'Organisation', 'Valuelist', function (scope, routeParams, filter, $q, animate, UserInfo, Project, Organisation, Valuelist)
{
  scope.SavingStateEnum = SavingStateEnum;
  scope.userinfo = UserInfo;
  scope.params = routeParams;
  scope.projectTemplate = 'partials/projectProject.html';
  scope.eiasAndPermitsTemplate = 'partials/projectEiasAndPermits.html';
  scope.valuelists = Valuelist.get({'id':'all'}); // TODO: Singelton?

  scope.parts =
  {
    project:
    {
      form:null,
      state:SavingStateEnum.Loading,
      resource:null
    },
    organisation:
    {
      form:null,
      state:SavingStateEnum.Loading,
      resource:null
    }
  };

  scope.selectOrganisation = function(o)
  {
    scope.parts.organisation.resource = o;
    scope.createNewProject(o);
    o.$get({}, function(o)
    {
      scope.parts.organisation.state = SavingStateEnum.Loaded;
    });
  };

  scope.hasSelectedOrganisation = function()
  {
    return scope.parts.organisation.resource!=null;
  };

  scope.createNewOrganisation = function()
  {
    var oData =
    {
      is_new:true
    };
    scope.parts.organisation.resource = new Organisation(oData);
    scope.parts.organisation.state = SavingStateEnum.Loaded;
    scope.createNewProject(scope.parts.organisation.resource);
  };

  scope.createNewProject = function(o)
  {
    var pData =
    {
      has_industrial_waste_water:41, // 41=No
      organisation_id: o.id,
      is_new:true
    };
    scope.parts.project.resource = new Project(pData);
    scope.parts.project.state = SavingStateEnum.Loaded;
  };

  scope.saveCurrentProject = function()
  {
    if (!scope.parts.project.resource.organisation_id)
    {
      return;
    }
    scope.saveCurrent(scope.parts.project);
  };

  scope.saveCurrentOrganisation = function()
  {
    scope.saveCurrent(scope.parts.organisation).then(function(o)
    {
      if (!scope.parts.project.resource.organisation_id)
      {
        scope.parts.project.resource.organisation_id = o.id;
        scope.saveCurrentProject();
      }
    });
  };

  scope.saveCurrent = function(part)
  {
    var deferred = $q.defer();
    var form = part.form;
    if (!scope.canSave() && !scope.canSaveGrade() )
    {
      deferred.reject("Not authorized to save");
    }
    else if (form.$invalid)
    {
      part.state = SavingStateEnum.Invalid;
      deferred.reject("Form is invalid");
    }
    else if (form.$pristine)
    {
      deferred.reject("Form is pristine");
    }
    else
    {
      part.state = SavingStateEnum.SavingStarted;
      scope.saveResource(part.resource).then(function (data)
      {
        part.state = SavingStateEnum.SavingFinished;
        part.form.$setPristine();
        deferred.resolve(data);
      }, function (reason)
      {
        part.state = SavingStateEnum.SavingFailed;
        deferred.reject(reason);
      });
    }
    return deferred.promise;
  };

  scope.saveResource = function(r)
  {
    var deferred = $q.defer();
    if (r.is_new)
    {
      r.$save({}, function(data)
      {
        deferred.resolve(data);
      }, function()
      {
        deferred.reject("Could not save new.");
      });
    }
    else
    {
      r.$update({}, function(data)
      {
        deferred.resolve(data);
      }, function()
      {
        deferred.reject("Could not save existing.");
      });
    }
    return deferred.promise;
  };

  scope.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };
  scope.canSaveGrade = function()
  {
    return scope.userinfo.info.role_7;
  };

  if (routeParams.id == "new")
  {
    scope.organisations = Organisation.query();
  }
  else
  {
    scope.parts.organisation.resource = {};
    scope.parts.project.resource = Project.get({id:routeParams.id}, function(p)
    {
      scope.parts.project.state = SavingStateEnum.Loaded;
      scope.parts.organisation.resource = Organisation.get({id:p.organisation_id}, function(o)
      {
        scope.parts.organisation.state = SavingStateEnum.Loaded;
      });
    });
  }

}]);