"use strict";

var testy1 = "x";
var paginationCount = 20;
var projectPagerOffset = 0;
controllers.controller("ProjectsController", [
  "$scope",
  "$location",
  "$filter",
  "Project",
  "UserInfo",
  function(scope, location, filter, Project, UserInfo) {
    scope.projectSearchTxt = "Search";
    scope.loadMoreProjectsTxt = "Load more";
    scope.projects = Project.query({
      count: 20
    });
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

    scope.loadMoreProjects = function() {
      scope.loadMoreProjectsTxt = "Loading..";
      projectPagerOffset += 20;
      Project.query(
        { count: 20, offset: projectPagerOffset, searchWord: scope.searchWord },
        function(response) {
          if (response.length == 0) {
            scope.hideProjectLoader = true;
            return;
          }
          var newList = scope.projects.concat(response);
          scope.projects = newList;
          scope.loadMoreProjectsTxt = "Load more";
        }
      );
    };

    scope.searchProjects = function() {
      scope.projectSearchTxt = "Searching...";
      Project.query({ count: 20, searchWord: scope.searchWord }, function(
        response
      ) {
        scope.hideProjectLoader = false;
        scope.projects = response;
        scope.projectSearchTxt = "Search";
      });
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
    scope.loadMoreBtnTxt = "Load more";
    scope.searchBtnTxt = "search";
    scope.organisations = [];
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
      } else if ((part.form.$invalid || this.coordinateError) && !(part.isNew && evenIfPristine)) {
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
    scope.coordinateError = DisplayStateEnum.Hide;
    scope.districtState = {
      isError: DisplayStateEnum.Hide,
      suggestion: ""
    };
    scope.currentCoordinateObject = {};
    scope.coordinateNetworkIssues = DisplayStateEnum.Hide;
    scope.checkingCoordinates = false;
    scope.currentLong = "";
    scope.currentLat = "";
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

    scope.loadMoreDevelopers = function(e) {
      scope.loadMoreBtnTxt = "Loading...";
      paginationCount += 20;
      var searchWord = scope.data.searchWord;
      var promise = Organisation.query({
        offset: paginationCount,
        searchWord: searchWord
      });
      var prevList = scope.organisations;
      var self = this;
      promise.$promise.then(function(organisations) {
        var newList = organisations[0].organisations;
        var organisationUnion = prevList.concat(newList);
        scope.organisations = organisationUnion.sort(scope.projectSortScript);
        scope.currentCount = organisations[0].properties.currentCount;
        scope.loadMoreBtnTxt = "Load more";
      });
    };

    scope.search = function() {
      scope.searchBtnTxt = "searching...";
      var searchWord = scope.data.searchWord;
      paginationCount = 0;
      var promise = Organisation.query({ searchWord: searchWord });
      promise.$promise.then(function(organisations) {
        var newList = organisations[0].organisations.sort(
          scope.projectSortScript
        );
        scope.organisations = newList;
        scope.totalCount = organisations[0].properties.totalCount;
        scope.currentCount = organisations[0].properties.currentCount;
        scope.searchBtnTxt = "search";
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

      if (projectPart.form.$invalid || this.coordinateError) {
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
        scope.organisations = organisations[0].organisations.sort(
          scope.projectSortScript
        );
        scope.totalCount = organisations[0].totalCount;
        scope.currentCount = organisations[0].currentCount;
      });
    };

    scope.verifyCoordinates = function(data, firstRender) {
      if(firstRender && scope.parts.project.state == SavingStateEnum.Loading) {
        return;
      }

      var lat = (scope.data.project.latitude)? scope.data.project.latitude.trim(): scope.data.project.latitude;
      var long = (scope.data.project.longitude)? scope.data.project.longitude.trim(): scope.data.project.longitude;
      scope.data.project.latitude = lat;
      scope.data.project.longitude = long;
      function checkingCoordinate(state) {
        if(state) {
          scope.coordinateError = state;
        }
        scope.checkingCoordinates = state;
      };
      if(scope.isNewProject && !lat && !long) {
        scope.coordinateError = DisplayStateEnum.Hide;
        return;
      }
      
      if(scope.parts.project.state == SavingStateEnum.Loading) {
        return;
      }
        
        if(scope.currentLong == long && scope.currentLat == lat) {
          return;
        }
        if(!lat && !long) {
          scope.coordinateError = DisplayStateEnum.Hide;
          return;
        }
        scope.currentLat = lat;
        scope.currentLong = long;
        checkingCoordinate(true);
      isCoordinateWithinUganda(lat, long, function(isInUganda, data){
        scope.$apply( function () {
        if(!isInUganda) {
          //TODO remove view function
          document.getElementById('latitude').classList.remove('ng-valid');
          document.getElementById('longitude').classList.remove('ng-valid');
          scope.coordinateError = DisplayStateEnum.Show;
          if(data.error == "network") {
            scope.coordinateNetworkIssues = DisplayStateEnum.Show;
          } else {
            scope.coordinateNetworkIssues = DisplayStateEnum.Hide;
          }
        } else {
          scope.currentCoordinateObject = data;
          scope.coordinateError = DisplayStateEnum.Hide;
          
          //check if districts match
          isDistrictMatching(data);

            scope.saveCurrentProject();
        }
        checkingCoordinate(false);
      })
      });
    };

    scope.onDistrictChange = function() {
      isDistrictMatching(scope.currentCoordinateObject);
      scope.saveCurrentProject();
    }
    
    function isDistrictMatching(data) {
      var apacKwanCheck = function(currentDistrict, returnedDistrict) {
        var matchingDistricts = ['kwania', 'apac'];
        var output  = (matchingDistricts.includes(currentDistrict) && matchingDistricts.includes(returnedDistrict));
        return output;
      }

      function extractDistrict(data)
      {
        var district = 'None';
        if(data.address.state) {
          district = data.address.state;
        } else {
          var addressSplit = data.display_name.split(",");
          var addressSize = addressSplit.length;
          for(var i = 0; i < addressSize; i++) {
              var output = _.find(scope.valuelists.district, function(districtItem){
                return (districtItem.description1.trim().toLowerCase() == addressSplit[i].trim().toLowerCase()); 
              });
              if(output) {
                district = output.description1;
              }
          }
        }
        return district.trim().toLowerCase();
      }
      var currentDistrict = _.find(scope.valuelists.district, 'id', parseInt(scope.data.project.district_id));
      var currentDistrictStr = currentDistrict.description1.trim().toLowerCase();
      var returnedDistrict = extractDistrict(data);
      if(( currentDistrictStr != returnedDistrict) && !apacKwanCheck(currentDistrictStr, returnedDistrict) ) {
        scope.districtState.isError = DisplayStateEnum.Show;
        scope.districtState.suggestion = (extractDistrict(data) == 'apac')? 'Apac/Kwania': extractDistrict(data);
        return false;
      } else {
        scope.districtState.isError = DisplayStateEnum.Hide;
        return true;
      }
    }

    scope.splitCoordinates = function(type) {
      setTimeout(function() {
        var splitValues = document.getElementById(type).value.split(",");
        if(splitValues.length < 2) {
          return;
        }
        scope.data.project.latitude = splitValues[0];
        scope.data.project.longitude = splitValues[1];
    }, 0);
     
    }

    if (scope.routeParams.projectId == "new") {
      scope.selectOrganisationMode = true;
      scope.isNewProject = true;
      scope.parts.project.isNew = true;
      ProjectFactory.empty();
      var promise = Organisation.query();
      promise.$promise.then(function(organisations) {
        scope.organisations = organisations[0].organisations.sort(
          scope.projectSortScript
        );
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

    scope.projectSortScript = function(a, b) {
      if (a.projectCount < b.projectCount) return 1;
      if (a.projectCount > b.projectCount) return -1;
      return 0;
    };

  }
    
]);
