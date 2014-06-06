'use strict';

/* Controllers */

var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', 'PractitionersService', function (scope, PractitionersService)
{

  scope.practitioners = PractitionersService.query({}, function() {
//    scope.current = scope.practitioners[1];
  });

  scope.hasEia = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 1, 'year':yearForValidPractitionerCertificate });
  };
  scope.hasAudit = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 2, 'year':yearForValidPractitionerCertificate });
  };
  scope.setCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
      PractitionersService.update({ practitionerId:p.id }, p);
      //p.$save({}, function(psaved, putResponseHeaders){console.log("Data saved");}, function(){console.log("Save error");});
    }
    else
    {
      scope.current = p;
      PractitionersService.get({practitionerId:p.id}, function(pfull, getResponseHeaders)
      {
        _.merge(p, pfull);
      });
    }
  };

}])

;
