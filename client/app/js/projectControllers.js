'use strict';


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


controllers.controller('ProjectTabsController', ['$scope', '$routeParams', '$location', '$q', 'ProjectFactory', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, ProjectFactory, UserInfo, Valuelists)
{
  scope.SavingStateEnum = SavingStateEnum;
  scope.ProjectTabEnum = ProjectTabEnum;
  scope.routeParams = routeParams;
  scope.userinfo = UserInfo;
  scope.valuelists = Valuelists;
  scope.data = ProjectFactory;

  var getCurrentTab = function(path)
  {
    if (path.contains("eiaspermits"))
    {
      return ProjectTabEnum.EiasPermits;
    }
    if (path.contains("auditsinspections"))
    {
      return ProjectTabEnum.AuditsInspections;
    }
    if (path.contains("reports"))
    {
      return ProjectTabEnum.Reports;
    }
    return ProjectTabEnum.Project;
  };
  scope.tab = getCurrentTab(location.path());

  scope.goto = function(path)
  {
    location.path(path);
  };

  scope.auth = {};
  scope.auth.canSave = function()
  {
    return false;
  }

  scope.saveCurrent = function(part, resource)
  {
    var deferred = $q.defer();
    if (part.form.$pristine)
    {
      deferred.reject();
    }
    else if (part.form.$invalid)
    {
      part.state = SavingStateEnum.Invalid;
      deferred.reject();
    }
    else if (!scope.auth.canSave() && !scope.auth.canSaveGrade())
    {
      deferred.reject();
    }
    else
    {
      part.state = SavingStateEnum.SavingStarted;
      ProjectFactory.save(scope.routeParams, part.form, resource).then
      (
        function (data)
        {
          part.state = SavingStateEnum.SavingFinished;
          part.form.$setPristine();

          deferred.resolve(data);
        },
        function (reason)
        {
          part.state = SavingStateEnum.SavingFailed;
        }
      );
    }
    return deferred.promise;
  };
}]);


controllers.controller('ProjectController', ['$scope', '$q', 'ProjectFactory', 'Organisation', function (scope, $q, ProjectFactory, Organisation)
{
  scope.selectOrganisationMode = false;
  scope.isNewProject = false;

  scope.parts =
  {
    project:
    {
      form:null,
      state:SavingStateEnum.Loading
    },
    organisation:
    {
      form:null,
      state:SavingStateEnum.Loading
    }
  };

  scope.newProjectExisitingOrganisation = function(o)
  {
    scope.selectOrganisationMode = false;
    ProjectFactory.setOrganisation(o).then(function(o)
    {
      scope.parts.organisation.state = SavingStateEnum.Loaded;
    });
    ProjectFactory.createNewProject(o);
    scope.parts.project.state = SavingStateEnum.Loaded;
  };

  scope.newProjectNewOganisation = function()
  {
    scope.selectOrganisationMode = false;
    ProjectFactory.createNewOrganisation();
    ProjectFactory.createNewProject(scope.data.organisation);
    scope.parts.project.state = SavingStateEnum.Loaded;
    scope.parts.organisation.state = SavingStateEnum.Loaded;
  };

  scope.saveCurrentProject = function()
  {
    var project = scope.data.project;
    if (!project.organisation_id)
    {
      return;
    }
    scope.saveCurrent(scope.parts.project, project).then(function(data)
    {
      if (scope.isNewProject)
      {
        scope.goto("/projects/"+project.id);
      }
    });
  };

  scope.saveCurrentOrganisation = function()
  {
    var project = scope.data.project;
    var organisation = scope.data.organisation;
    scope.saveCurrent(scope.parts.organisation, organisation).then(function(o)
    {
      if (!project.organisation_id)
      {
        project.organisation_id = o.id;
        scope.saveCurrentProject();
      }
    });
  };

  scope.auth.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };

  scope.auth.canSaveGrade = function()
  {
    return scope.userinfo.info.role_7;
  }

  if (scope.routeParams.projectId == "new")
  {
    scope.selectOrganisationMode = true;
    scope.isNewProject = true;
    ProjectFactory.empty();
    scope.organisations = Organisation.query();
  }
  else
  {
    var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
    promises[0].then(function()
    {
      scope.parts.project.state = SavingStateEnum.Loaded;
    });
    promises[1].then(function()
    {
      scope.parts.organisation.state = SavingStateEnum.Loaded;
    });
  }
}]);


controllers.controller('EiasPermitsController', ['$scope', 'ProjectFactory', function (scope, ProjectFactory)
{
  scope.isNewEiaPermit = false;
  scope.parts =
  {
    eiapermit:
    {
      form:null,
      state:SavingStateEnum.Loading
    }
  };

  scope.hasEiaPermit = function()
  {
    return !_.isEmpty(scope.data.eiapermit);
  };

  scope.saveCurrentEiaPermit = function()
  {
    var eiapermit = scope.data.eiapermit;
    scope.saveCurrent(scope.parts.eiapermit, eiapermit).then(function(ep)
    {
      if (scope.isNewEiaPermit)
      {
        scope.goto("/projects/"+scope.data.project.id+"/eiaspermits/"+ep.id);
      }
    });
  };

  scope.auth.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };

  var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
  promises[3].then(function(ep)
  {
    scope.parts.eiapermit.state = SavingStateEnum.Loaded;
  });

  if (scope.routeParams.eiapermitId == "new")
  {
    ProjectFactory.createNewEiaPermit(scope.data.project);
    scope.isNewEiaPermit = true;
  }
}]);