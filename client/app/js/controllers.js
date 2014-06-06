'use strict';

/* Controllers */

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', 'PractitionersService', function (scope, PractitionersService)
{
  scope.practitioners = PractitionersService.query();

  scope.hasEia = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 1 });
  };
  scope.hasAudit = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 2 });
  };
}])

;
