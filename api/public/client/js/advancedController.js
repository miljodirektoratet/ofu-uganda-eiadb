'use strict';

controllers.controller('AdvancedCodesController', ['$scope', '$routeParams', 'EditCode', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, EditCode, $timeout, $q, $interval, uiGridConstants)
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

controllers.controller('AdvancedUsersController', ['$scope', '$routeParams', 'EditUser', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, EditUser, $timeout, $q, $interval, uiGridConstants)
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


    scope.gridOptions.columnDefs = [
        {name: 'id', type: 'number', enableCellEdit: false, width: 60},
        {name: 'initials', cellTooltip: true, width: 80},
        {name: 'name', cellTooltip: true, width: '*'},
        {name: 'job_position_code', cellTooltip: true, width: 80},
        {name: 'job_position_name', cellTooltip: true, width: 100},
        {name: 'email', cellTooltip: true, width: 100},
        {name: 'password', cellTooltip: true, width: 80},
        {name: 'is_passive', type: 'number', width: 90},
        {name: 'role_ids', enableCellEdit: true, width: 90},
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
        var rowEntity = new EditUser();
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

    EditUser.query({}, function (cs)
    {
        scope.gridOptions.data = cs;
    });
}]);

controllers.controller('AdvancedLeadAgenciesController', ['$scope', '$routeParams', 'EditLeadAgency', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, EditLeadAgency, $timeout, $q, $interval, uiGridConstants)
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


    scope.gridOptions.columnDefs = [
        {name: 'id', type: 'number', enableCellEdit: false, width: 60},
        {name: 'short_name', cellTooltip: true, width: 150},
        {name: 'long_name', cellTooltip: true, width: '*'},
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
        var rowEntity = new EditLeadAgency();
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

    EditLeadAgency.query({}, function (cs)
    {
        scope.gridOptions.data = cs;
    });
}]);


controllers.controller('AdvancedEmailOrderController', ['$scope', '$routeParams', 'EditEmailOrder', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, EditEmailOrder, $timeout, $q, $interval, uiGridConstants)
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


    scope.gridOptions.columnDefs = [
        {name: 'id', type: 'number', enableCellEdit: false, width: 60},
        {
            name: 'foreign_id',
            enableCellEdit: false,
            width: 80,
            cellTemplate: '<a href="/resolveLink/emailOrder/{{row.entity.foreign_type}}/{{row.entity.foreign_id}}" ng-click="grid.appScope.visitLink(row.entity)">{{row.entity.foreign_id}}</a>'
        },
        {name: 'foreign_type', enableCellEdit: false, width: 80},
        {name: 'order_status', enableCellEdit: true, width: 80},
        {name: 'subject', enableCellEdit: false, width: 120},
        {name: 'body', enableCellEdit: false, width: 160},
        {name: 'recipient', enableCellEdit: true, width: 160},
        {name: 'cc', enableCellEdit: false, width: 120},
        {name: 'bcc', enableCellEdit: false, width: 120},
        {name: 'remarks_from_service', enableCellEdit: false, width: 200},
        {name: 'remarks', enableCellEdit: true, width: 120},
        {name: 'updated_by', enableCellEdit: false, width: 120},
        {name: 'updated_at', enableCellEdit: false, enableFiltering: false, type: 'date', cellFilter: 'date:"d MMM yyyy HH:mm:ss"', width: 160},
        {name: 'created_by', enableCellEdit: false, enableFiltering: false, type: 'date', cellFilter: 'date:"d MMM yyyy HH:mm:ss"', width: 160},
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

    scope.exportEmailOrders = function(data) {
        exportObj.exportData(data, "emailOrders");
    };

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

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
        gridApi.rowEdit.on.saveRow(scope, scope.saveRow);
    };

    EditEmailOrder.query({}, function (cs)
    {
        scope.gridOptions.data = cs;
    });
}]);