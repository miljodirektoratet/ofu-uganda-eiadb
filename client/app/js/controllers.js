'use strict';

/* Controllers */

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', 'PractitionersService', function (scope, PractitionersService)
{
  scope.practitioners = PractitionersService.query();
}])

;
