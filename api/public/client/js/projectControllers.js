"use strict";

var testy1 = "x";
var paginationCount = 20;

controllers.controller("ProjectsController", [
  "$scope",
  "$location",
  "$filter",
  "Project",
  "UserInfo",
  function(scope, location, filter, Project, UserInfo) {
    scope.showFilter = false;
    scope.projects = Project.query({ count: 50 });
    scope.projectsCount = 0;
    Project.query({ countOnly: 1 }, function(data) {
      scope.projectsCount = data[0];
    });
    scope.userinfo = UserInfo;
    scope.goto = function(path) {
      location.path(path);
    };

    scope.canSave = function() {
      return scope.userinfo.info.role_1;
    };

    scope.getAllProjects = function() {
      scope.projects = Project.query();
      scope.showFilter = true;
    };
  }
]);

controllers.controller("ProjectTabsController", [
  "$scope",
  "$routeParams",
  "$location",
  "$q",
  "$timeout",
  "ProjectFactory",
  "UserInfo",
  "Valuelists",
  function(
    scope,
    routeParams,
    location,
    $q,
    $timeout,
    ProjectFactory,
    UserInfo,
    Valuelists
  ) {
    scope.SavingStateEnum = SavingStateEnum;
    scope.ProjectTabEnum = ProjectTabEnum;
    scope.routeParams = routeParams;
    scope.userinfo = UserInfo;
    scope.valuelists = Valuelists;
    scope.data = ProjectFactory;
    var getCurrentTab = function(path) {
      if (_.contains(path, "eiaspermits")) {
        return ProjectTabEnum.EiasPermits;
      }
      if (_.contains(path, "auditsinspections")) {
        return ProjectTabEnum.AuditsInspections;
      }
      if (_.contains(path, "externalaudits")) {
        return ProjectTabEnum.ExternalAudits;
      }
      if (_.contains(path, "permitslicenses")) {
        return ProjectTabEnum.PermitsLicenses;
      }
      return ProjectTabEnum.Project;
    };
    scope.tab = getCurrentTab(location.path());

    scope.goto = function(path) {
      $timeout(function() {
        location.path(path);
      });
    };

    scope.auth = {};
    scope.auth.canSave = function() {
      return false;
    };

    scope.saveCurrent = function(part, resource, evenIfPristine) {
      evenIfPristine =
        typeof evenIfPristine !== "undefined" ? evenIfPristine : false;

      if (part.saveInProgress && part.isNew) {
        var deferred = $q.defer();
        deferred.reject();
        return deferred.promise;
      }

      part.saveInProgress = true;
      var deferred = $q.defer();
      if (part.form.$pristine && !evenIfPristine) {
        part.saveInProgress = false;
        deferred.reject();
      } else if (part.form.$invalid && !(part.isNew && evenIfPristine)) {
        part.state = SavingStateEnum.Invalid;
        part.saveInProgress = false;
        deferred.reject();
      } else {
        part.state = part.isNew
          ? SavingStateEnum.LoadingNew
          : SavingStateEnum.SavingStarted;
        // New method for saving new. Save first, edit later.
        var params = scope.routeParams;
        if (evenIfPristine) {
          params = _.omit(params, "auditinspectionId");
          params = _.omit(params, "eiapermitId");
          params = _.omit(params, "externalauditId");
        }

        ProjectFactory.save(params, resource).then(
          function(data) {
            // User have navigated away if part.form is undefined.
            if (!_.isUndefined(part.form)) {
              part.state = part.isNew
                ? SavingStateEnum.LoadingNew
                : SavingStateEnum.SavingFinished;
              part.form.$setPristine();
              part.saveInProgress = false;
              deferred.resolve(data);
            }
          },
          function(reason) {
            if (console) {
              console.log("Error on server:", reason);
            }
            part.state = SavingStateEnum.SavingFailed;
            part.saveInProgress = false;
          }
        );
      }
      return deferred.promise;
    };
  }
]);

controllers.controller("ProjectController", [
  "$scope",
  "$q",
  "ProjectFactory",
  "Organisation",
  "$timeout",
  function(scope, $q, ProjectFactory, Organisation, $timeout) {
    scope.selectOrganisationMode = false;
    scope.isNewProject = false;

    scope.parts = {
      project: {
        form: null,
        state: SavingStateEnum.Loading
      },
      organisation: {
        form: null,
        state: SavingStateEnum.Loading
      }
    };

    scope.newProjectExisitingOrganisation = function(o) {
      scope.selectOrganisationMode = false;
      ProjectFactory.setOrganisation(o).then(function(o) {
        scope.parts.organisation.state = SavingStateEnum.Loaded;
      });

      // Do we just want to change the organisation?
      if (ProjectFactory.project.id > 0) {
        ProjectFactory.project.organisation_id = o.id;
        $timeout(function() {
          scope.saveCurrentProject(true);
        });
      } else {
        ProjectFactory.createNewProject(o);
      }

      scope.parts.project.state = SavingStateEnum.Loaded;
    };

    scope.newProjectNewOganisation = function() {
      scope.selectOrganisationMode = false;
      ProjectFactory.createNewOrganisation();

      // Do we just want to change the organisation?
      if (ProjectFactory.project.id > 0) {
        //ProjectFactory.project.organisation_id = null;
      } else {
        ProjectFactory.createNewProject(scope.data.organisation);
      }

      scope.parts.project.state = SavingStateEnum.Loaded;
      scope.parts.organisation.state = SavingStateEnum.Loaded;
      scope.parts.organisation.isNew = true;
    };

    scope.loadMore = function() {
      paginationCount += 20;
      var searchWord = scope.data.searchWord;
      var promise = Organisation.query({
        offset: paginationCount,
        searchWord: searchWord
      });
      var prevList = scope.organisations;
      promise.$promise.then(function(organisations) {
        var newList = organisations[0].organisations;
        scope.organisations = prevList.concat(newList);
        scope.currentCount = organisations[0].properties.currentCount;
      });
    };

    scope.search = function() {
      var searchWord = scope.data.searchWord;
      paginationCount = 0;
      var promise = Organisation.query({ searchWord: searchWord });
      promise.$promise.then(function(organisations) {
        var newList = organisations[0].organisations;
        scope.organisations = newList;
        console.log(organisations[0].properties.totalCount);
        scope.totalCount = organisations[0].properties.totalCount;
        scope.currentCount = organisations[0].properties.currentCount;
      });
    };
    scope.saveCurrentProject = function(evenIfPristine) {
      evenIfPristine =
        typeof evenIfPristine !== "undefined" ? evenIfPristine : false;

      if (scope.isNewProject) {
        scope.saveNewProjectAndNewOrganisation();
        return;
      }
      var project = scope.data.project;
      scope
        .saveCurrent(scope.parts.project, project, evenIfPristine)
        .then(function(data) {});
    };

    scope.saveCurrentOrganisation = function() {
      if (scope.isNewProject) {
        scope.saveNewProjectAndNewOrganisation();
        return;
      }
      var project = scope.data.project;
      var organisation = scope.data.organisation;
      scope
        .saveCurrent(scope.parts.organisation, organisation)
        .then(function(o) {
          if (o.id !== project.organisation_id) {
            project.organisation_id = o.id;
            scope.saveCurrentProject(true);
          }
        });
    };

    scope.saveNewProjectAndNewOrganisation = function() {
      var projectPart = scope.parts.project;
      var organisationPart = scope.parts.organisation;

      if (projectPart.form.$invalid) {
        scope.parts.project.state = SavingStateEnum.Invalid;
        if (organisationPart.form.$dirty) {
          scope.parts.organisation.state = SavingStateEnum.MissingDependency;
        }
        return;
      }

      if (projectPart.form.$valid && organisationPart.form.$invalid) {
        scope.parts.project.state = SavingStateEnum.MissingDependency;
        scope.parts.organisation.state = SavingStateEnum.Invalid;
        return;
      }

      if (projectPart.form.$valid && organisationPart.form.$valid) {
        var project = scope.data.project;
        var organisation = scope.data.organisation;
        // Organisation already exists and is unchanged. Save only the project.
        if (organisationPart.form.$pristine) {
          project.organisation_id = organisation.id;
          scope.saveCurrent(projectPart, project).then(function(p) {
            scope.goto("/projects/" + p.id); // CAUSES "$digest already in progress" error
          });
        }
        // Save organisation first, then project.
        else {
          scope.saveCurrent(organisationPart, organisation).then(function(o) {
            project.organisation_id = o.id;
            scope.saveCurrent(projectPart, project).then(function(p) {
              scope.goto("/projects/" + p.id); // CAUSES "$digest already in progress" error
            });
          });
        }
      }
    };

    scope.auth.canSave = function(field) {
      switch (field) {
        case "has_industrial_waste_water":
          return scope.userinfo.info.role_3;
        default:
          return scope.userinfo.info.role_1;
      }
    };

    scope.auth.canDelete = function() {
      if (scope.isNewProject) {
        return false;
      }

      if (scope.parts.project.state == SavingStateEnum.Loading) {
        return false;
      }

      if (
        scope.data.eiaspermits.length > 0 ||
        scope.data.auditsinspections.length > 0
      ) {
        return false;
      }

      return scope.auth.canSave();
    };

    scope.deleteProject = function() {
      ProjectFactory.deleteProject(scope.routeParams).then(function() {
        scope.goto("/projects");
      });
    };

    scope.changeDeveloper = function() {
      // TODO:
      scope.selectOrganisationMode = true;
      var promise = Organisation.query();
      promise.$promise.then(function(organisations) {
        scope.organisations = organisations[0].organisations;
        scope.totalCount = organisations[0].totalCount;
        scope.currentCount = organisations[0].currentCount;
      });
    };

    scope.checkInputForGoogleMaps = function(formElement) {
      //console.log("checkInputForGoogleMaps", formElement);
      var rawValue = formElement.$viewValue;

      if (rawValue && rawValue.indexOf(", ") !== -1) {
        var coordinates = rawValue.split(", ");
        var lat = coordinates[0];
        var long = coordinates[1];

        scope.data.project.latitude = lat;
        scope.data.project.longitude = long;
      }
    };

    if (scope.routeParams.projectId == "new") {
      scope.selectOrganisationMode = true;
      scope.isNewProject = true;
      scope.parts.project.isNew = true;
      ProjectFactory.empty();
      var promise = Organisation.query();
      scope.data.searchWord;
      promise.$promise.then(function(organisations) {
        scope.organisations = organisations[0].organisations;
        scope.totalCount = organisations[0].properties.totalCount;
        scope.currentCount = organisations[0].properties.currentCount;
      });
    } else {
      var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
      promises[0].then(function() {
        scope.parts.project.state = SavingStateEnum.Loaded;
      });
      promises[1].then(function() {
        scope.parts.organisation.state = SavingStateEnum.Loaded;
      });
    }
  }
]);
