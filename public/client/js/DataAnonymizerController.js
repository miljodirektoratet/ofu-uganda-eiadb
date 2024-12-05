'use strict';

/* Controllers */

var controllers = angular.module('seroApp.controllers');

controllers.controller('DataAnonymizerController', ['$scope', '$http', function (scope, $http)
{
    scope.defaultBtnTxt = 'anonymize';
    scope.loaded = true;
    scope.successState = parseInt(localStorage.reloaded_dac);
    localStorage.reloaded_dac = 0;
    scope.working = false;
    console.log(scope.successState, scope.working, "params");
    scope.done = 0;
    scope.anonymize = function (field)
    {
        scope.working = true;
        $http({
            method: 'GET',
            url: '/anonymizerData/v1/'+field,
            params: scope.criteria
        }).then(function successCallback(response)
        {
            scope.working = false;
            scope.successState = response.data.status;
            scope.done = 2;
            if (scope.successState) {
                localStorage.reloaded_dac = scope.successState;
                window.location.reload();
            }
        }, function errorCallback(response)
        {
            scope.done = 2;
            scope.working = false;
            scope.successState = 0;
        });
    };

}]);