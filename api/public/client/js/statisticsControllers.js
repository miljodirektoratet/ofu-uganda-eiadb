'use strict';

controllers.controller('StatisticsTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'Valuelists', 'StatisticsService', function (scope, routeParams, location, $q, $timeout, ProjectFactory, Valuelists, StatisticsService)
{
    scope.routeParams = routeParams;
    //scope.userinfo = UserInfo;
    scope.valuelists = Valuelists;
    //scope.data = ProjectFactory;
    scope.StatisticsService = StatisticsService;
    scope.StatisticsTabEnum = StatisticsTabEnum;

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "projects"))
        {
            return StatisticsTabEnum.Projects;
        }
        if (_.contains(path, "eiaspermits"))
        {
            return StatisticsTabEnum.EiasPermits;
        }
        if (_.contains(path, "auditsinspections"))
        {
            return StatisticsTabEnum.AuditsInspections;
        }
        return null;
    };

    scope.tab = getCurrentTab(location.path());

    scope.goto = function (path)
    {
        $timeout(function ()
        {
            location.path(path);
        });
    };
}]);


controllers.controller('StatisticsProjectsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectStatistics', 'UserInfo', 'Valuelists', 'StatisticsService', function (scope, routeParams, location, $q, $timeout, ProjectStatistics, UserInfo, Valuelists, StatisticsService)
{
    scope.data = {};

    scope.isLoadingData = true;

    StatisticsService.getProjectData().then(function (data)
    {
        scope.data = data;
        scope.isLoadingData = false;
    });
}]);