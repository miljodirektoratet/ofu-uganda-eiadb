'use strict';

controllers.controller('AdvancedController', ['$scope', 'ProjectFactory', '$timeout', '$q', function (scope, ProjectFactory, $timeout, $q)
{
    scope.parts =
    {
        eiapermit: {
            form: null,
            state: SavingStateEnum.Loading
        },
        document: {
            form: null,
            state: SavingStateEnum.None
        }
    };
}]);