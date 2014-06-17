'use strict';

/* Controllers */

var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', '$filter', 'Practitioner', function (scope, filter, Practitioner)
{

  scope.practitioners = Practitioner.query({}, function() {
//    scope.current = scope.practitioners[1];
  });

  scope.hasEia = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 10, 'year':yearForValidPractitionerCertificate });
  };
  scope.hasAudit = function(p)
  {
    return _.some(p.practitioner_certificates,  { 'cert_type': 12, 'year':yearForValidPractitionerCertificate });
  };

  scope.newPractitioner = function()
  {
    alert("Not implemented yet.");
  };
  scope.deleteCertificate = function(c)
  {
    alert("I know. Some sort of confirming is coming.");
    c.is_deleted=true;
  };
  scope.newCertificate = function(p)
  {
    var c =
    {
      'id':0,
      'year':2014,
      'date_of_entry':filter('date')(new Date(), "yyyy-MM-dd")
    };
    p.practitioner_certificates.push(c);
  };
  scope.setCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
      //p.$update({}, function(pSaved){mergePractitionerObject(p, pSaved)}, function(){console.log("Error when saving")});
      p.$update({}, createDatesInJsonData);
    }
    else
    {
      scope.current = p;
      //p.$get();
      p.$get({}, createDatesInJsonData);
    }
  };

  function createDatesInJsonData(p)
  {
    //return;
    _.forEach(p.practitioner_certificates, function(c)
    {
      c.date_of_entry = new Date(c.date_of_entry);
    });
  };

}])

.controller('DatePickerController', ['$scope', function (scope)
{
  scope.open = function($event)
  {
    $event.preventDefault();
    $event.stopPropagation();
    scope.opened = true;
  };
  scope.datepickerOptions =
  {
    startingDay: 1
    //,showButtonBar: false // Not working
  };
}])
;
