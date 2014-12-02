'use strict';


controllers.controller('ProjectsController', ['$scope', '$location', '$filter', 'Project', 'UserInfo', function (scope, location, filter, Project, UserInfo)
{
  scope.showFilter = false;
  scope.projects = Project.query({'count':20});
  scope.userinfo = UserInfo;
  scope.goto = function(path)
  {
    location.path(path);
  };

  scope.canSave = function()
  {
    return scope.userinfo.info.role_1;
  };

  scope.getAllProjects = function()
  {
    scope.projects = Project.query();
    scope.showFilter = true;
  }
}]);


controllers.controller('ProjectTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, $timeout, ProjectFactory, UserInfo, Valuelists)
{
  scope.SavingStateEnum = SavingStateEnum;
  scope.ProjectTabEnum = ProjectTabEnum;
  scope.routeParams = routeParams;
  scope.userinfo = UserInfo;
  scope.valuelists = Valuelists;
  scope.data = ProjectFactory;

  var getCurrentTab = function(path)
  {
    if(_.contains(path, "eiaspermits"))
    {
      return ProjectTabEnum.EiasPermits;
    }
    if(_.contains(path, "auditsinspections"))
    {
      return ProjectTabEnum.AuditsInspections;
    }
    if(_.contains(path, "reports"))
    {
      return ProjectTabEnum.Reports;
    }
    return ProjectTabEnum.Project;
  };
  scope.tab = getCurrentTab(location.path());

  scope.goto = function(path)
  {
    $timeout(function()
    {

      location.path(path);
    });
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
    if (scope.isNewProject)
    {
      scope.saveNewProjectAndNewOrganisation();
      return;
    }
    var project = scope.data.project;
    scope.saveCurrent(scope.parts.project, project).then(function(data)
    {
    });
  };

  scope.saveCurrentOrganisation = function()
  {
    if (scope.isNewProject)
    {
      scope.saveNewProjectAndNewOrganisation();
      return;
    }
    var project = scope.data.project;
    var organisation = scope.data.organisation;
    scope.saveCurrent(scope.parts.organisation, organisation).then(function(o)
    {
    });
  };

  scope.saveNewProjectAndNewOrganisation = function()
  {
    var projectPart = scope.parts.project;
    var organisationPart = scope.parts.organisation;

    if (projectPart.form.$invalid)
    {
      scope.parts.project.state =  SavingStateEnum.Invalid;
      if (organisationPart.form.$dirty)
      {
        scope.parts.organisation.state =  SavingStateEnum.MissingDependency;
      }
      return;
    }

    if (projectPart.form.$valid && organisationPart.form.$invalid)
    {
      scope.parts.project.state =  SavingStateEnum.MissingDependency;
      scope.parts.organisation.state =  SavingStateEnum.Invalid;
      return;
    }

    if (projectPart.form.$valid && organisationPart.form.$valid)
    {
      var project = scope.data.project;
      var organisation = scope.data.organisation;
      // Organisation already exists and is unchanged. Save only the project.
      if (organisationPart.form.$pristine)
      {
        project.organisation_id = organisation.id;
        scope.saveCurrent(projectPart, project).then(function(p)
        {
          scope.goto("/projects/"+p.id); // CAUSES "$digest already in progress" error
        });
      }
      // Save organisation first, then project.
      else
      {
        scope.saveCurrent(organisationPart, organisation).then(function (o)
        {
          project.organisation_id = o.id;
          scope.saveCurrent(projectPart, project).then(function (p)
          {
            scope.goto("/projects/" + p.id); // CAUSES "$digest already in progress" error
          });
        });
      }
    }
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
    },
    document:
    {
      form:null,
      state:SavingStateEnum.None
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

  scope.saveCurrentDocument = function()
  {
    var document = scope.data.document;
    scope.saveCurrent(scope.parts.document, document).then(function(d)
    {
    });
  };

  scope.newDocument = function()
  {
    ProjectFactory.createNewDocument(scope.data.eiapermit);
    //scope.toggleDocument(scope.data.document);
  }

  scope.deleteEiaPermit = function()
  {
    ProjectFactory.deleteEiaPermit(scope.routeParams);
    scope.goto("/projects/"+scope.data.project.id);
  }

  scope.toggleDocument = function(d)
  {
//    if (scope.loading)
//    {
//      //console.log("Currently loading. Please wait.");
//      return;
//    }
    if (scope.data.document == d)
    {
      scope.data.document = {};
      scope.parts.document.state = SavingStateEnum.None;
    }
    else
    {
      if (d.is_new)
      {
        scope.data.document = d;
      }
      else
      {
        d.$get(scope.routeParams, function(d)
        {
          scope.data.document = d;
        });
      }
    }
  };

  scope.calculateNumberOfCopiesOfDocument = function()
  {
    scope.data.document.director_copy_no = 1;
    scope.data.document.coordinator_copy_no = scope.data.document.sub_copy_no - 1;
  };

  scope.auth.canSave = function(field)
  {
    switch(field)
    {
      case "new":
      case "delete":
        return scope.userinfo.info.role_1;
      case "teamleader_id":
      case "practitioner_id":
      case "cost":
      case "cost_currency":
      case "status":
      case "document.date_submitted":
      case "document.sub_copy_no":
      case "document.title":
      case "document.type":
      case "document.number":
      case "document.code":
      case "document.consultent":
      case "document.director_copy_no":
      case "document.date_sent_director":
      case "document.coordinator_copy_no":
      case "document.date_copies_coordinator":
      case "document.date_next_appointment":
      case "document.date_sent_from_dep":
      case "document.folio_no":
      case "document.remarks":
        return scope.userinfo.info.role_1;
      case "user_id":
        return scope.userinfo.info.role_2;
      case "inspection_recommended":
      case "date_inspection":
      case "officer_recommend":
      case "fee":
      case "fee_currency":
      case "remarks":
      case "date_sent_ded_approval":
      case "document.sub_final":
      case "document.date_sent_officer":
        return scope.userinfo.info.role_3;
      case "date_fee_notification":
      case "date_fee_payed":
      case "fee_receipt_no":
        return scope.userinfo.info.role_4;
      case "decision":
      case "date_decision":
      case "designation":
      case "date_certificate":
      case "certificate_no":
      case "date_cancelled":
      case "document.conclusion":
        return scope.userinfo.info.role_5;
      default:
        return false;
    }
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
    scope.parts.eiapermit.state = SavingStateEnum.Loaded;
  }
}]);