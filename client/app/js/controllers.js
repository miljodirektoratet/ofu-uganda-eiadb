'use strict';

/* Controllers */

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

controllers.controller('ProjectController', ['$scope', '$routeParams', '$filter', '$animate', 'UserInfo', 'Project', 'Organisation', 'Valuelist', function (scope, routeParams, filter, animate, UserInfo, Project, Organisation, Valuelist)
{
  scope.userinfo = UserInfo;
  scope.params = routeParams;
  scope.projectTemplate = 'partials/projectProject.html';
  scope.eiasAndPermitsTemplate = 'partials/projectEiasAndPermits.html';
  scope.valuelists = Valuelist.get({'id':'all'}); // TODO: Singelton?
  scope.forms = {};
  scope.isProjectLoading = true;
  scope.isProjectSaving = false;
  scope.isProjectSavingFinished = false;
  scope.isOrganisationLoading = true;
  scope.isOrganisationSaving = false;
  scope.isOrganisationSavingFinished = false;

  if (routeParams.id == "new")
  {
    var pData =
    {
      //'title': 'Project Title',
      'has_industrial_waste_water':41,
      'is_new':true
    };
    scope.project = new Project(pData);
    scope.isProjectLoading = false;
    scope.isOrganisationLoading = false;
  }
  else
  {
    scope.organisation = {};
    scope.project = Project.get({id:routeParams.id}, function(p)
    {
      //p.temp_districts = p.districts.map(function(d){return d.id});
      scope.isProjectLoading = false;
      scope.organisation = Organisation.get({id:p.organisation_id}, function(o)
      {
        scope.isOrganisationLoading = false;
      });
    });
  }

  scope.saveProject = function(p)
  {
//    console.log(p.district_ids);
//    if (scope.isProjectSaving)
//    {
//      scope.isProjectSaving = false;
//      scope.isProjectSavingFinished = true;
//    }
//    else
//    {
//      scope.isProjectSavingFinished = false;
//      scope.isProjectSaving = true;
//    }

  };

  scope.saveCurrentProject = function()
  {
    if (!scope.canSave() && !scope.canSaveGrade() )
    {
      return;
    }

    var p = scope.project;
    if (p.is_new)
    {
     // p.$save({}, function(p){createDatesInJsonData(p);showSaveInfo();});
    }
    else
    {
      scope.isProjectSavingFinished = false;
      scope.isProjectSaving = true;
      p.$update({}, function(p)
      {
        scope.isProjectSaving = false;
        scope.isProjectSavingFinished = true;
      });
    }
  };

  scope.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };
  scope.canSaveGrade = function()
  {
    return scope.userinfo.info.role_7;
  };

}]);