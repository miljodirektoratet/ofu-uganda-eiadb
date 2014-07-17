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


  if (routeParams.id == "new")
  {
    var pData =
    {
      //'title': 'Project Title',
      'is_new':true
    };
    scope.project = new Project(pData);
  }
  else
  {
    scope.organisation = {};
    scope.project = Project.get({id:routeParams.id}, function(p)
    {
      scope.organisation = Organisation.get({id:p.organisation_id});
    });

  }

  scope.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };
  scope.canSaveGrade = function()
  {
    return scope.userinfo.info.role_7;
  };

}]);