'use strict';

controllers.controller('SearchTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, $timeout, ProjectFactory, UserInfo, Valuelists)
{
    scope.SearchTabEnum = SearchTabEnum;
    scope.routeParams = routeParams;
    scope.userinfo = UserInfo;
    scope.valuelists = Valuelists;
    scope.data = ProjectFactory;

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "projects"))
        {
            return SearchTabEnum.Projects;
        }
        if (_.contains(path, "eiaspermits"))
        {
            return SearchTabEnum.EiasPermits;
        }
        if (_.contains(path, "auditsinspections"))
        {
            return SearchTabEnum.AuditsInspections;
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

controllers.controller('SearchAuditsInspectionsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'AuditInspectionSearch', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, $timeout, AuditInspectionSearch, UserInfo, Valuelists)
{
    scope.isSearching = false;

    scope.criteria = routeParams;
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
        }
    },
    scope.gridOptions.rowTemplate = "<div ng-dblclick=\"grid.appScope.onDblClick(row.entity)\" ng-repeat=\"(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name\" class=\"ui-grid-cell\" ng-class=\"{ 'ui-grid-row-header-cell': col.isRowHeader }\" ui-grid-cell ></div>"


    scope.gridOptions.columnDefs = [
        {name: 'auditinspection_code', displayName: 'Number', width: 80, cellTooltip: true, headerTooltip: true},
        {name: 'project_title', displayName: 'Project title', cellTooltip: true, headerTooltip: true},
        {name: 'organisation_name', displayName: 'Developer name', cellTooltip: true, headerTooltip: true},
        {name: 'district_district', displayName: 'District', cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_type', displayName: 'Type', cellTooltip: true, headerTooltip: true},
        {name: 'category_description', displayName: 'Category of project', cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_action_taken', displayName: 'Action taken', cellTooltip: true, headerTooltip: true},
        {name: 'project_grade', displayName: 'Grade', width: 80, cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_date_deadline', displayName: 'Deadline to correct deviations', type: 'date', cellFilter: 'date:"d MMM yyyy"', headerTooltip: true}
    ];

    //scope.goto = function(url)
    //{
    //  console.log(url);
    //};

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
    };

    scope.search = function ()
    {
        scope.isSearching = true;
        AuditInspectionSearch.query(scope.criteria, function (rows)
        {
            scope.gridOptions.data = rows;
            scope.isSearching = false;
        });
    };

    scope.reset = function ()
    {
        scope.criteria = {};
        scope.gridOptions.data = [];
    };

}]);

