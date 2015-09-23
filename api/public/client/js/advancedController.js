'use strict';

controllers.controller('AdvancedController', ['$scope', '$routeParams', 'EditCode', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, EditCode, $timeout, $q, $interval, uiGridConstants)
{
    scope.routeParams = $routeParams;

    scope.parts =
    {
        code: {
            form: null,
            state: SavingStateEnum.Loading
        }
    };

    scope.gridOptions = {};
    scope.gridOptions.enableCellEditOnFocus = true;
    scope.gridOptions.showGridFooter = true;
    scope.gridOptions.minRowsToShow = 15;
    scope.gridOptions.rowEditWaitInterval = 1000;
    scope.gridOptions.enableFiltering = true;
    scope.gridOptions.headerRowHeight= 50;

    scope.gridOptions.columnDefs = [
        {name: 'id', type: 'number', enableCellEdit: false, width: 60},
        {name: 'description1', cellTooltip: true, width: '*'},
        {name: 'description2', cellTooltip: true, width: 150},
        {name: 'value1', type: 'number', width: 100},
        {name: 'dropdown_list', cellTooltip: true, width: 150},
        {name: 'updated_by', enableCellEdit: false, width: 120},
        {name: 'updated_at', enableCellEdit: false, enableFiltering: false, type: 'date', cellFilter: 'date:"d MMM yyyy HH:mm:ss"', width: 160},
        {
            name: 'delete',
            displayName: '',
            enableSorting: false,
            enableCellEdit: false,
            enableFiltering: false,
            enableColumnMenu: false,
            width: 80,
            cellTemplate: '<div><button ng-show="row.entity.deleted_at" ng-click="grid.appScope.undeleteRow(row.entity)" class="btn undelete btn-sm btn-link">undelete</button><button ng-hide="row.entity.deleted_at" ng-click="grid.appScope.deleteRow(row.entity)" class="btn delete btn-sm btn-link">delete</button></div>'
        }
    ];

    scope.saveRow = function (rowEntity)
    {
        var promise = rowEntity.$update();
        scope.gridApi.rowEdit.setSavePromise(rowEntity, promise);
    };

    scope.deleteRow = function (rowEntity)
    {
        var promise = rowEntity.$delete({});
        scope.gridApi.rowEdit.setSavePromise(rowEntity, promise);
    };

    scope.undeleteRow = function (rowEntity)
    {
        rowEntity.deleted_at = null;
        scope.saveRow(rowEntity);
    };

    scope.addRow = function ()
    {
        var rowEntity = new EditCode();
        var promise = rowEntity.$save();
        promise.then(function (savedRowEntity)
        {
            scope.gridOptions.data.push(savedRowEntity);
            $timeout(function ()
            {
                scope.gridApi.cellNav.scrollToFocus(savedRowEntity, scope.gridOptions.columnDefs[0]);
            });
        });

    };

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
        gridApi.rowEdit.on.saveRow(scope, scope.saveRow);
    };

    EditCode.query({}, function (cs)
    {
        scope.gridOptions.data = cs;
    });
}]);