'use strict';

controllers.controller('SearchTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'UserInfo', 'SearchService', function (scope, routeParams, location, $q, $timeout, ProjectFactory, UserInfo, SearchService)
{
    scope.SearchTabEnum = SearchTabEnum;
    scope.routeParams = routeParams;
    //scope.userinfo = UserInfo;
    //scope.valuelists = Valuelists;
    //scope.data = ProjectFactory;
    scope.SearchService = SearchService;

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

services.factory('SearchService', ['AuditInspectionSearch', '$q', function (AuditInspectionSearch, $q)
{
    var factory = {};
    factory.criteria = {};
    factory.allowCache = true;
    factory.rows = [];

    factory.search = function (criteria)
    {
        //console.log("allowCache", factory.allowCache);
        var deferred = $q.defer();

        var isSameCriteria = _.isEqual(factory.criteria, criteria);
        //console.log("isSameCriteria", isSameCriteria, factory.criteria, criteria);

        if (isSameCriteria && factory.allowCache)
        {
            //console.log("From cache");
            deferred.resolve(factory.rows);
        }
        else
        {
            //console.log("From server");
            factory.criteria = _.clone(criteria);
            AuditInspectionSearch.query(factory.criteria, function (rows)
            {
                //console.log("From server finished");
                factory.rows = rows;
                deferred.resolve(factory.rows);
                factory.allowCache = true;
            });
        }
        return deferred.promise;
    };

    return factory;
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

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
    };

    scope.setSearchUrl = function ()
    {
        if (_.isEmpty(scope.criteria))
        {
            // TODO: Empty location.search. location.search({}) is not working.
            // This empty if works, but if one navigates back to the tab, the location.search values will be used.
            // Hence we need to empty it.
            return;
        }
        scope.criteria.reset = 0;
        var isSameCriteria = _.isEqual(SearchService.criteria, scope.criteria);
        if (isSameCriteria)
        {
            // Force same search.
            SearchService.allowCache = false;
            scope.search();
            location.search(scope.criteria);
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
        scope.criteria = {'reset': 1};
        SearchService.criteria = {};
        scope.gridOptions.data = [];
        scope.showResultGrid = false;
        location.search(scope.criteria);
    };


    scope.criteria = location.search();
    if (scope.criteria.reset == 1)
    {
        return;
    }
    if (_.isEmpty(scope.criteria) && !_.isEmpty(SearchService.criteria))
    {
        location.search(SearchService.criteria);
    }
    else if (!_.isEmpty(scope.criteria))
    {
        scope.search();
    }
}]);