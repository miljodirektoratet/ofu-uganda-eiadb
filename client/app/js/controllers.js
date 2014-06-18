'use strict';

/* Controllers */

var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', '$filter', 'Practitioner', function (scope, filter, Practitioner)
{

  scope.practitioners = Practitioner.query({}, function() {
//    scope.current = scope.practitioners[1];
  });

  var filterCertificates = function(certificates, certType, year)
  {
    if (!certificates) {return false;}
    var e = function(value)
    {
      if (value.cert_type !== certType) {return false;}
      if (value.year !== year) {return false;}
      if (value.is_deleted) {return false;}
      return true;
    };
    return filter('filter')(certificates, e, true).length > 0;
  };
  scope.hasEia = function(p)
  {
    var has = filterCertificates(p.practitioner_certificates, 10, yearForValidPractitionerCertificate);
    p.cert_eia = has ? "eia":null;
    return has;
  };
  scope.hasAudit = function(p)
  {
    var has = filterCertificates(p.practitioner_certificates, 12, yearForValidPractitionerCertificate);
    p.cert_au = has ? "audit":null;
    return has;
  };

  scope.newPractitioner = function()
  {
    var pData =
    {
      'practitioner_certificates':[],
      'is_new':true
    };
    var p = new Practitioner(pData);
    scope.practitioners.unshift(p);
    scope.setCurrent(p);

  };
  scope.deletePractitioner = function(index, p)
  {
    scope.current = null;
    p.$delete();
    scope.practitioners.splice(index, 1);
  };
  scope.deleteCertificate = function(c)
  {
    c.is_deleted=true;
  };
  scope.newCertificate = function(p)
  {
    var c =
    {
      'year':2014,
      'date_of_entry':new Date(),
      'is_new':true
    };
    p.practitioner_certificates.unshift(c);
  };
  scope.setCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
      if (p.is_new)
      {
        p.$save({}, createDatesInJsonData);
      }
      else
      {
        p.$update({}, createDatesInJsonData);
      }
    }
    else
    {
      scope.current = p;
      if (!p.is_new)
      {
        p.$get({}, createDatesInJsonData);
      }
    }
  };

  scope.practitionerOrderBy = function(p)
  {
    var sortName = p.person.trim().substring(p.person.trim().lastIndexOf(" "));
    return sortName;
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
