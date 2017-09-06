'use strict';

controllers.controller('SearchPermitsLicensesController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'PermitLicenseSearch', 'UserInfo', 'Valuelists', 'PermitLicenseSearchService', function (scope, routeParams, location, $q, $timeout, PermitLicenseSearch, UserInfo, Valuelists, PermitLicenseSearchService)
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
            scope.goto("/projects/" + rowEntity.project_id + "/permitslicenses/" + rowEntity.permitlicense_id);
            // TODO: Mark the row that was double clicked.
        }
    };
    scope.gridOptions.rowTemplate = "<div ng-dblclick=\"grid.appScope.onDblClick(row.entity)\" ng-repeat=\"(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name\" class=\"ui-grid-cell\" ng-class=\"{ 'ui-grid-row-header-cell': col.isRowHeader }\" ui-grid-cell ></div>"


    scope.gridOptions.columnDefs = [
        {name: 'permitlicense_id', displayName: 'PL Id', type:'number', width: 80, cellTooltip: true, headerTooltip: true},
        {name: 'permitlicense_date_submitted', displayName: 'Date of submission', width: 130, type: 'date', cellFilter: 'date:"d MMM yyyy"', headerTooltip: true},
        {name: 'permitlicense_regulation', displayName: 'Regulation', width: 80, cellTooltip: true, headerTooltip: true},
        {name: 'permitlicense_officer_assigned', displayName: 'Team leader',  cellTooltip: true, headerTooltip: true},
        {name: 'project_title', displayName: 'Project name', cellTooltip: true, headerTooltip: true}
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
        _.forOwn(scope.dateCriteria, function(value, key)
        {
            if (value instanceof Date)
            {
                // HACK: To get out of timezone trouble.
                value.setHours(12);
                scope.criteria[key] = value.toJSON().substr(0,10);
            }
        });

        if (_.isEmpty(scope.criteria))
        {
            return;
        }

        var isSameCriteria = _.isEqual(PermitLicenseSearchService.criteria, scope.criteria);
        if (isSameCriteria)
        {
            // Force same search.
            PermitLicenseSearchService.allowCache = false;
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
        PermitLicenseSearchService.search(scope.criteria).then(function (rows)
        {
            scope.gridOptions.data = rows;
            scope.isSearching = false;
            scope.showResultGrid = true;
        });
    };

    scope.reset = function ()
    {
        scope.criteria = {};
        scope.dateCriteria = {};
        PermitLicenseSearchService.criteria = {};
        scope.gridOptions.data = [];
        scope.showResultGrid = false;
    };

    scope.criteria = location.search();
    scope.dateCriteria = {};
    if (scope.criteria.permitlicense_date_submission_from)
    {
        scope.dateCriteria.permitlicense_date_submission_from = new Date(scope.criteria.permitlicense_date_submission_from);
    }
    if (scope.criteria.permitlicense_date_submission_to)
    {
        scope.dateCriteria.permitlicense_date_submission_to = new Date(scope.criteria.permitlicense_date_submission_to);
    }

    if (_.isEmpty(scope.criteria) && !_.isEmpty(PermitLicenseSearchService.criteria))
    {
        location.search(PermitLicenseSearchService.criteria);
    }
    else if (!_.isEmpty(scope.criteria))
    {
        scope.search();
    }
}]);