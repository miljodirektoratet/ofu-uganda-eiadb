'use strict';

/* Controllers */

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', 'PractitionersService', function (scope, PractitionersService)
{

  scope.practitioners = PractitionersService.query({}, function() {
    //scope.current = scope.practitioners[1];
  });

  scope.hasEia = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 1 });
  };
  scope.hasAudit = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 2 });
  };
  scope.setCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
    }
    else
    {
      scope.current = p;
      PractitionersService.get({practitionerId:p.id}, function(pfull, getResponseHeaders)
      {
        console.log("Got data for ", p, pfull);
      });
    }
  };

}])

;
