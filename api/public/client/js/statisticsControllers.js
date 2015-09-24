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
    scope.isLoadingResultGrid = false;
    scope.showResultGrid = false;

    scope.gridOptions = {};
    scope.gridOptions.enableHorizontalScrollbar = 0;
    scope.gridOptions.showGridFooter = true;
    scope.gridOptions.minRowsToShow = 10;
    scope.gridOptions.enableColumnMenus = false;
    //scope.gridOptions.enableFiltering = true;
    //scope.gridOptions.enableGridMenu = true;
    //scope.gridOptions.enableRowSelection = true;
    //scope.gridOptions.enableRowHeaderSelection = false;
    //scope.gridOptions.multiSelect = false;
    //scope.gridOptions.enableFooterTotalSelected = false;
    scope.gridOptions.appScopeProvider = {
        onDblClick: function (rowEntity)
        {
            scope.goto("/projects/" + rowEntity.project_id + "/auditsinspections/" + rowEntity.auditinspection_id);
            // TODO: Mark the row that was double clicked.
        }
    };
    scope.gridOptions.rowTemplate = "<div ng-dblclick=\"grid.appScope.onDblClick(row.entity)\" ng-repeat=\"(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name\" class=\"ui-grid-cell\" ng-class=\"{ 'ui-grid-row-header-cell': col.isRowHeader }\" ui-grid-cell ></div>"

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
    };

    StatisticsService.getProjectData().then(function (data)
    {
        scope.data = data;
        scope.isLoadingData = false;
    });
}]);