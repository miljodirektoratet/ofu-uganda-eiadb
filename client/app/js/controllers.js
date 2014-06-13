'use strict';

/* Controllers */

var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', 'Practitioner', function (scope, Practitioner)
{

  scope.practitioners = Practitioner.query({}, function() {
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
  scope.deleteCertificate = function(p, c)
  {
//    var index=p.practitioner_certificates.indexOf(c);
//    p.practitioner_certificates.splice(index,1);
//    console.log("slettet",index);
// TODO: Delete all the way?
    var ci = _.findIndex(p.practitioner_certificates, c);
    p.practitioner_certificates.splice(ci, 1);
    console.log("slettet",ci);
  };
  scope.setCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
      //p.$save({}, function(psaved, putResponseHeaders){console.log("Data saved");}, function(){console.log("Save error");});
      p.$update();
      //PractitionersService.update({ practitionerId:p.id }, p);
      //p.$save({}, function(psaved, putResponseHeaders){console.log("Data saved");}, function(){console.log("Save error");});
    }
    else
    {
      scope.current = p;
      Practitioner.get({id:p.id}, function(pfull, getResponseHeaders)
      {
        _.merge(p, pfull);
      });
    }
  };

}])

;
