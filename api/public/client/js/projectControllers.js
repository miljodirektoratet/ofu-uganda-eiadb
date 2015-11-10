'use strict';

var testy1 = "x";

controllers.controller('ProjectsController', ['$scope', '$location', '$filter', 'Project', 'UserInfo', function (scope, location, filter, Project, UserInfo)
{
    scope.showFilter = false;
    scope.projects = Project.query({'count': 50});
    scope.projectsCount = 0;
    Project.query({'countOnly': 1}, function (data)
    {
        scope.projectsCount = data[0];
    });
    scope.userinfo = UserInfo;
    scope.goto = function (path)
    {
        location.path(path);
    };

    scope.canSave = function ()
    {
        return scope.userinfo.info.role_1;
    };

    scope.getAllProjects = function ()
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

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "eiaspermits"))
        {
            return ProjectTabEnum.EiasPermits;
        }
        if (_.contains(path, "auditsinspections"))
        {
            return ProjectTabEnum.AuditsInspections;
        }
        if (_.contains(path, "reports"))
        {
            return ProjectTabEnum.Reports;
        }
        return ProjectTabEnum.Project;
    };
    scope.tab = getCurrentTab(location.path());

    scope.goto = function (path)
    {
        $timeout(function ()
        {

            location.path(path);
        });
    };

    scope.auth = {};
    scope.auth.canSave = function ()
    {
        return false;
    }

    scope.saveCurrent = function (part, resource, evenIfPristine)
    {
        evenIfPristine = typeof evenIfPristine !== 'undefined' ? evenIfPristine : false;

        if (part.saveInProgress && part.isNew)
        {
            var deferred = $q.defer();
            deferred.reject();
            return deferred.promise;
        }

        part.saveInProgress = true;
        var deferred = $q.defer();
        if (part.form.$pristine && !evenIfPristine)
        {
            part.saveInProgress = false;
            deferred.reject();
        }
        else if (part.form.$invalid && !(part.isNew && evenIfPristine))
        {
            part.state = SavingStateEnum.Invalid;
            part.saveInProgress = false;
            deferred.reject();
        }
        else
        {
            part.state = part.isNew ? SavingStateEnum.LoadingNew : SavingStateEnum.SavingStarted;
            // New method for saving new. Save first, edit later.
            var params = scope.routeParams;
            if (evenIfPristine)
            {
                params = _.omit(params, 'auditinspectionId');
                params = _.omit(params, 'eiapermitId');
            }

            ProjectFactory.save(params, part.form, resource).then
            (
                function (data)
                {
                    part.state = part.isNew ? SavingStateEnum.LoadingNew : SavingStateEnum.SavingFinished;
                    part.form.$setPristine();
                    part.saveInProgress = false;
                    deferred.resolve(data);
                },
                function (reason)
                {
                    if (console)
                    {
                        console.log("Error on server:", reason);
                    }
                    ;
                    part.state = SavingStateEnum.SavingFailed;
                    part.saveInProgress = false;
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
        project: {
            form: null,
            state: SavingStateEnum.Loading
        },
        organisation: {
            form: null,
            state: SavingStateEnum.Loading
        }
    };

    scope.newProjectExisitingOrganisation = function (o)
    {
        scope.selectOrganisationMode = false;
        ProjectFactory.setOrganisation(o).then(function (o)
        {
            scope.parts.organisation.state = SavingStateEnum.Loaded;
        });
        ProjectFactory.createNewProject(o);
        scope.parts.project.state = SavingStateEnum.Loaded;
    };

    scope.newProjectNewOganisation = function ()
    {
        scope.selectOrganisationMode = false;
        ProjectFactory.createNewOrganisation();
        ProjectFactory.createNewProject(scope.data.organisation);
        scope.parts.project.state = SavingStateEnum.Loaded;
        scope.parts.organisation.state = SavingStateEnum.Loaded;
        scope.parts.organisation.isNew = true;
    };

    scope.saveCurrentProject = function ()
    {
        if (scope.isNewProject)
        {
            scope.saveNewProjectAndNewOrganisation();
            return;
        }
        var project = scope.data.project;
        scope.saveCurrent(scope.parts.project, project).then(function (data)
        {
        });
    };

    scope.saveCurrentOrganisation = function ()
    {
        if (scope.isNewProject)
        {
            scope.saveNewProjectAndNewOrganisation();
            return;
        }
        var project = scope.data.project;
        var organisation = scope.data.organisation;
        scope.saveCurrent(scope.parts.organisation, organisation).then(function (o)
        {
        });
    };

    scope.saveNewProjectAndNewOrganisation = function ()
    {
        var projectPart = scope.parts.project;
        var organisationPart = scope.parts.organisation;

        if (projectPart.form.$invalid)
        {
            scope.parts.project.state = SavingStateEnum.Invalid;
            if (organisationPart.form.$dirty)
            {
                scope.parts.organisation.state = SavingStateEnum.MissingDependency;
            }
            return;
        }

        if (projectPart.form.$valid && organisationPart.form.$invalid)
        {
            scope.parts.project.state = SavingStateEnum.MissingDependency;
            scope.parts.organisation.state = SavingStateEnum.Invalid;
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
                scope.saveCurrent(projectPart, project).then(function (p)
                {
                    scope.goto("/projects/" + p.id); // CAUSES "$digest already in progress" error
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

    scope.auth.canSave = function ()
    {
        return scope.userinfo.info.role_1;
    };

    if (scope.routeParams.projectId == "new")
    {
        scope.selectOrganisationMode = true;
        scope.isNewProject = true;
        scope.parts.project.isNew = true;
        ProjectFactory.empty();
        scope.organisations = Organisation.query();
    }
    else
    {
        var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
        promises[0].then(function ()
        {
            scope.parts.project.state = SavingStateEnum.Loaded;
        });
        promises[1].then(function ()
        {
            scope.parts.organisation.state = SavingStateEnum.Loaded;
        });
    }
}]);