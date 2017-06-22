'use strict';

controllers.controller('SearchTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'Valuelists', 'UserInfo', function (scope, routeParams, location, $q, $timeout, ProjectFactory, Valuelists, UserInfo)
{
    scope.SearchTabEnum = SearchTabEnum;
    scope.routeParams = routeParams;
    scope.userinfo = UserInfo;
    scope.valuelists = Valuelists;
    //scope.data = ProjectFactory;

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
        if (_.contains(path, "externalaudits"))
        {
            return SearchTabEnum.ExternalAudits;
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

controllers.controller('SearchAuditsInspectionsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'AuditInspectionSearch', 'UserInfo', 'Valuelists', 'SearchService', function (scope, routeParams, location, $q, $timeout, AuditInspectionSearch, UserInfo, Valuelists, SearchService)
{
    // We perform searching based on the url. A form submit changes the url (see setSearchUrl()).

    scope.isSearching = false;
    scope.showResultGrid = false;

    scope.gridOptions = {};
    scope.gridOptions.enableHorizontalScrollbar = 0;
    scope.gridOptions.showGridFooter = true;
    scope.gridOptions.minRowsToShow = 10;
    scope.gridOptions.enableColumnMenus = false;
    //scope.gridOptions.enableFiltering = true;
    //scope.gridOptions.enableGridMenu = true;
    scope.gridOptions.enableRowSelection = true;
    scope.gridOptions.enableRowHeaderSelection = false;
    scope.gridOptions.multiSelect = false;
    scope.gridOptions.noUnselect = true;
    scope.gridOptions.enableFooterTotalSelected = false;
    scope.gridOptions.appScopeProvider = {
        onDblClick: function (rowEntity)
        {
            scope.goto("/projects/" + rowEntity.project_id + "/auditsinspections/" + rowEntity.auditinspection_id);
            // TODO: Mark the row that was double clicked.
        }
    };
    scope.gridOptions.rowTemplate = "<div ng-dblclick=\"grid.appScope.onDblClick(row.entity)\" ng-repeat=\"(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name\" class=\"ui-grid-cell\" ng-class=\"{ 'ui-grid-row-header-cell': col.isRowHeader }\" ui-grid-cell ></div>"


    scope.gridOptions.columnDefs = [
        {name: 'auditinspection_code', displayName: 'Number', width: 80, cellTooltip: true, headerTooltip: true},
        {name: 'project_title', displayName: 'Project name', cellTooltip: true, headerTooltip: true},
        {name: 'developer_name', displayName: 'Developer name', cellTooltip: true, headerTooltip: true},
        {name: 'developer_tin', displayName: 'TIN', type:'number', width: 90, cellTooltip: true, headerTooltip: true},
        {name: 'district_district', displayName: 'District', cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_type', displayName: 'Activity', cellTooltip: true, headerTooltip: true},
        {name: 'category_description', displayName: 'Category of project', width: 150, cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_action_taken', displayName: 'Response', cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_performance_level', displayName: 'Performance', width: 110, cellTooltip: true, headerTooltip: true},
        {name: 'auditinspection_date_deadline', displayName: 'Deadline for complete compliance', width: 90, type: 'date', cellFilter: 'date:"d MMM yyyy"', headerTooltip: true}
    ];



    //var openRow = function (row)
    //{
    //    console.log(row);
    //    //SearchService.lastSelectedIndex = row;
    //    var rowEntity = row.entity;
    //    //scope.goto("/projects/" + rowEntity.project_id + "/auditsinspections/" + rowEntity.auditinspection_id);
    //    // TODO: Mark the row that was double clicked.
    //};


    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        //gridApi.selection.on.rowSelectionChanged(scope, openRow);
        scope.gridApi = gridApi;
    };

    scope.setSearchUrl = function ()
    {
        if (_.isEmpty(scope.criteria))
        {
            return;
        }
        var isSameCriteria = _.isEqual(SearchService.criteria, scope.criteria);
        if (isSameCriteria)
        {
            // Force same search.
            SearchService.allowCache = false;
            scope.search();
        }
        else
        {
            location.search(scope.criteria);
        }
    };

    scope.search = function ()
    {
        scope.isSearching = true;
        scope.showResultGrid = false;
        SearchService.search(scope.criteria).then(function (rows)
        {
            scope.gridOptions.data = rows;
            scope.isSearching = false;
            scope.showResultGrid = true;
        });
    };

    scope.reset = function ()
    {
        scope.criteria = {};
        SearchService.criteria = {};
        scope.gridOptions.data = [];
        scope.showResultGrid = false;
    };

    scope.criteria = location.search();

    if (_.isEmpty(scope.criteria) && !_.isEmpty(SearchService.criteria))
    {
        location.search(SearchService.criteria);
    }
    else if (!_.isEmpty(scope.criteria))
    {
        scope.search();
    }
}]);

controllers.controller('SearchProjectsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectSearch', 'UserInfo', 'Valuelists', 'ProjectSearchService', function (scope, routeParams, location, $q, $timeout, ProjectSearch, UserInfo, Valuelists, ProjectSearchService)
{
    // We perform searching based on the url. A form submit changes the url (see setSearchUrl()).

    scope.isSearching = false;
    scope.showResultGrid = false;

    scope.gridOptions = {};
    scope.gridOptions.enableHorizontalScrollbar = 0;
    scope.gridOptions.showGridFooter = true;
    scope.gridOptions.minRowsToShow = 10;
    scope.gridOptions.enableColumnMenus = false;
    //scope.gridOptions.enableFiltering = true;
    //scope.gridOptions.enableGridMenu = true;
    scope.gridOptions.enableRowSelection = true;
    scope.gridOptions.enableRowHeaderSelection = false;
    scope.gridOptions.multiSelect = false;
    scope.gridOptions.noUnselect = true;
    scope.gridOptions.enableFooterTotalSelected = false;
    scope.gridOptions.appScopeProvider = {
        onDblClick: function (rowEntity)
        {
            scope.goto("/projects/" + rowEntity.project_id);
            // TODO: Mark the row that was double clicked.
        }
    };
    scope.gridOptions.rowTemplate = "<div ng-dblclick=\"grid.appScope.onDblClick(row.entity)\" ng-repeat=\"(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name\" class=\"ui-grid-cell\" ng-class=\"{ 'ui-grid-row-header-cell': col.isRowHeader }\" ui-grid-cell ></div>"


    scope.gridOptions.columnDefs = [
        {name: 'project_id', displayName: 'Id', type:'number', width: 50, cellTooltip: true, headerTooltip: true},
        {name: 'project_title', displayName: 'Name', cellTooltip: true, headerTooltip: true},
        {name: 'project_location', displayName: 'Location', cellTooltip: true, headerTooltip: true},
        {name: 'district_district', displayName: 'District', cellTooltip: true, headerTooltip: true},
        {name: 'category_description', displayName: 'Category', cellTooltip: true, headerTooltip: true},
        {name: 'developer_name', displayName: 'Developer name', cellTooltip: true, headerTooltip: true},
        {name: 'developer_tin', displayName: 'TIN', type:'number', width: 90, cellTooltip: true, headerTooltip: true}
    ];


    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
    };

    scope.setSearchUrl = function ()
    {
        if (_.isEmpty(scope.criteria))
        {
            return;
        }
        var isSameCriteria = _.isEqual(ProjectSearchService.criteria, scope.criteria);
        if (isSameCriteria)
        {
            // Force same search.
            ProjectSearchService.allowCache = false;
            scope.search();
        }
        else
        {
            location.search(scope.criteria);
        }
    };

    scope.search = function ()
    {
        scope.isSearching = true;
        scope.showResultGrid = false;
        ProjectSearchService.search(scope.criteria).then(function (rows)
        {
            scope.gridOptions.data = rows;
            scope.isSearching = false;
            scope.showResultGrid = true;
        });
    };

    scope.reset = function ()
    {
        scope.criteria = {};
        ProjectSearchService.criteria = {};
        scope.gridOptions.data = [];
        scope.showResultGrid = false;
    };

    scope.criteria = location.search();

    if (_.isEmpty(scope.criteria) && !_.isEmpty(ProjectSearchService.criteria))
    {
        location.search(ProjectSearchService.criteria);
    }
    else if (!_.isEmpty(scope.criteria))
    {
        scope.search();
    }
}]);