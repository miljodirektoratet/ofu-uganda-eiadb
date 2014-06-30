'use strict';

/* Controllers */

var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', '$filter', 'Practitioner', 'Valuelist', '$animate', function (scope, filter, Practitioner, Valuelist, animate)
{

  scope.valuelists = Valuelist.get({'id':'all'});
  scope.practitioners = Practitioner.query();

  var filterCertificates = function(certificates, certType, year)
  {
    if (!certificates) {return false;}
    var e = function(value)
    {
      if (value.cert_type !== certType) {return false;}
      if (value.year !== year) {return false;}
      if (value.is_deleted) {return false;}
      if (value.is_cancelled) {return false;}
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
    //console.log(scope.valuelists.practitionertype);
    var pData =
    {
      'practitioner_certificates':[],
      'is_new':true
    };
    var p = new Practitioner(pData);
    scope.practitioners.unshift(p);
    scope.setNewCurrent(p);

  };
  scope.deletePractitioner = function(index, p)
  {
    scope.current = null;
    if (!p.is_new)
    {
      p.$delete();
    }
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
      'year':yearForValidPractitionerCertificate,
      'date_of_entry':new Date(),
      'is_new':true
    };
    p.practitioner_certificates.unshift(c);
  };
  scope.saveCurrent = function()
  {
    if (scope.current)
    {
      var p = scope.current;
      if (p.is_new)
      {
        p.$save({}, function(p){createDatesInJsonData(p);showSaveInfo();});
      }
      else
      {
       // p.$update({}, createDatesInJsonData);
        p.$update({}, function(p){createDatesInJsonData(p);showSaveInfo();});
      }
    }
  };

  scope.changeNumericBoolean = function(field)
  {
    return field === 0 ? 1 : 0;
  };

  var showSaveInfo = function()
  {
    return;
//    var element = angular.element(document.getElementById('infoMessageBox'));
//    var className = 'infomessagebox';
//    animate.addClass(element, className, function ()
//    {
//      setTimeout(function(){animate.removeClass(element, className);},1000);
//    });
  };

  scope.setNewCurrent = function(p)
  {
    if (scope.current == p)
    {
      scope.current = null;
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
