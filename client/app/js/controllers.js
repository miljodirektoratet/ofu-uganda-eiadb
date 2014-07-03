'use strict';

/* Controllers */

var vlists = {};
var yearForValidPractitionerCertificate = 2013;

angular.module('seroApp.controllers', [])

.controller('PractitionersController', ['$scope', '$filter', 'Practitioner', 'Valuelist', '$animate', function (scope, filter, Practitioner, Valuelist, animate)
{
  scope.certificateYearMin = 2000;
  scope.certificateYearMax = 2015;
  scope.valuelists = Valuelist.get({'id':'all'}, function(){vlists=scope.valuelists});
  scope.practitioners = Practitioner.query();//{}, function(){scope.setNewCurrent(scope.practitioners[0]);});

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
    scope.toggleRow(p);

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
  scope.deleteCertificate = function(index, p, c)
  {
    if (c.is_new)
    {
      p.practitioner_certificates.splice(index, 1);
    }
    else
    {
      c.is_deleted=true;
    }
  };
  scope.newCertificate = function(p)
  {
    var c =
    {
      'year':yearForValidPractitionerCertificate,
      'date_of_entry':new Date(),
      'is_new':true
    };
    c.cert_no = scope.certificateNumber(c);
    p.practitioner_certificates.unshift(c);
  };
  scope.toggleRow = function(newP)
  {
    // Save.
    if (scope.current)
    {

      console.log(this.form);
      return;

      var oldP = scope.current;
      var form = scope.currentForm;
      console.log(form);
      if (form.$invalid)
      {
        alert("Form not valid. Can't save.");
        return;
      }
      if (form.$dirty)
      {
        if (oldP.is_new)
        {
          oldP.$save({}, function(p){createDatesInJsonData(p);showSaveInfo();});
        }
        else
        {
          // oldP.$update({}, createDatesInJsonData);
          oldP.$update({}, function(p){createDatesInJsonData(p);showSaveInfo();});
        }
      }
    }

    // Set current.
    if (scope.current == newP)
    {
      scope.current = null;
    }
    else
    {
      scope.current = newP;
      scope.currentForm = this.form;
      if (!newP.is_new)
      {
        newP.$get({}, createDatesInJsonData);
      }
    }
  };

  scope.certificateNumber = function(c)
  {
    // Not in use yet. Should perhaps let user input everything and validate against this?
    var practitionertypePart = "E";
    var practitionertype = _.find(scope.valuelists["practitionertype"], {'id': c.cert_no});
    if (practitionertype)
    {
      practitionertypePart = practitionertype.description1;
    }
    var numberPart = "XXX";
    var yearPart = c.year.toString().substr(2);
    var no = "CC/"+practitionertypePart+"/"+numberPart+"/"+yearPart;
    return no;
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
