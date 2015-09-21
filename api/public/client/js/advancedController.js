'use strict';

controllers.controller('AdvancedController', ['$scope', '$routeParams', 'AdvancedFactory', '$timeout', '$q', '$interval', 'uiGridConstants', function (scope, $routeParams, AdvancedFactory, $timeout, $q, $interval, uiGridConstants)
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
        {name: 'id', type: 'number', width: 60 },
        {name: 'description1', cellTooltip:true, width: '*'},
        {name: 'description2', cellTooltip:true, width: 150},
        {name: 'value1', type: 'number', width: 100},
        {name: 'dropdown_list', cellTooltip:true, width: 150},
        {name: 'updated_by',  enableCellEdit: false, width: 120},
        {name: 'updated_at', enableCellEdit: false, enableFiltering: false, type: 'date', cellFilter: 'date:"d MMM yyyy"', width: 130},
        {name: 'deleted_at', enableCellEdit: false, enableFiltering: false, type: 'date', cellFilter: 'date:"d MMM yyyy"', width: 130}
    ];

    scope.saveRow = function (rowEntity)
    {
        console.log(rowEntity);
        var promise = AdvancedFactory.save(rowEntity);
        scope.gridApi.rowEdit.setSavePromise(rowEntity, promise);



        /*
         // create a fake promise - normally you'd use the promise returned by $http or $resource
         var promise = $q.defer();
         $scope.gridApi.rowEdit.setSavePromise(rowEntity, promise.promise);

         // fake a delay of 3 seconds whilst the save occurs, return error if gender is "male"
         $interval(function ()
         {
         if (rowEntity.gender === 'male')
         {
         promise.reject();
         }
         else
         {
         promise.resolve();
         }
         }, 3000, 1);*/
    };

    scope.gridOptions.onRegisterApi = function (gridApi)
    {
        scope.gridApi = gridApi;
        gridApi.rowEdit.on.saveRow(scope, scope.saveRow);
    };

    var promises = AdvancedFactory.retrieveData();
    promises[0].then(function (cs)
    {
        scope.gridOptions.data = cs;
    });
}]);