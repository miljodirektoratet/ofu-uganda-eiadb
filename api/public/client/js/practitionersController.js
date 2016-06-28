'use strict';

controllers.controller('PractitionersController', ['$scope', '$filter', '$animate', 'UserInfo', 'Practitioner', 'Valuelists', function (scope, filter, animate, UserInfo, Practitioner, Valuelists)
{
  scope.certificateYearMin = 2000;
  scope.certificateYearMax = new Date().getFullYear()+1;
  scope.certificateYearValid = new Date().getFullYear();
  //scope.certificateYearValid = 2013;
  scope.current = null;
  scope.currentForm = null;
  scope.userinfo = UserInfo;
  scope.valuelists = Valuelists;
  scope.practitioners = Practitioner.query();//{}, function(){scope.setNewCurrent(scope.practitioners[0]);});

  var filterCertificates = function(certificates, certType, year, conditions)
  {
    if (!certificates) {return false;}
    var e = function(value)
    {
      if (value.cert_type != certType) {return false;}
      if (value.year !== year) {return false;}
      if (conditions > 0 && value.conditions != conditions) {return false;}
      if (value.is_deleted) {return false;}
      if (value.is_cancelled) {return false;}
      return true;
    };
    return filter('filter')(certificates, e, true).length > 0;
  };
    scope.hasEiaTL = function(p)
    {
        var has = filterCertificates(p.practitioner_certificates, 50, scope.certificateYearValid, 38);
        p.cert_eia = has ? "eia":null;
        return has;
    };
    scope.hasEiaTM = function(p)
    {
        var has = filterCertificates(p.practitioner_certificates, 50, scope.certificateYearValid, 39);
        p.cert_eia = has ? "eia":null;
        return has;
    };
    scope.hasAuditTL = function(p)
    {
        var has = filterCertificates(p.practitioner_certificates, 51, scope.certificateYearValid, 38);
        p.cert_au = has ? "audit":null;
        return has;
    };
    scope.hasAuditTM = function(p)
    {
        var has = filterCertificates(p.practitioner_certificates, 51, scope.certificateYearValid, 39);
        p.cert_au = has ? "audit":null;
        return has;
    };
  scope.hasPartnership = function(p)
  {
    var has = filterCertificates(p.practitioner_certificates, 52, scope.certificateYearValid, 0);
    p.cert_ep = has ? "partnership":null;
    return has;
  };

  scope.newPractitioner = function()
  {
    if (scope.currentForm && scope.currentForm.$invalid)
    {
      alert("Current form not valid. Can't create new practitioner.");
      return;
    }

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
      scope.currentForm.$setDirty();
    }
  };
  scope.newCertificate = function(p)
  {
    var c =
    {
      'year':scope.certificateYearValid,
      'date_of_entry':new Date(),
      'is_new':true
    };
    c.cert_no = scope.certificateNumber(c);
    p.practitioner_certificates.unshift(c);
  };

  scope.calculateCertificateNumber = function(c)
  {
      c.cert_no = scope.certificateNumber(c);
  };

  scope.canSave = function()
  {
    return scope.userinfo.info.role_6;
  };

  var savePractitioner = function(p)
  {
    if (!scope.canSave())
    {
      return;
    }
    if (p.is_new)
    {
      p.$save({}, function(p){createDatesInJsonData(p);showSaveInfo();});
    }
    else
    {
      // oldP.$update({}, createDatesInJsonData);
      p.$update({}, function(p){createDatesInJsonData(p);showSaveInfo();});
    }
  };

  scope.toggleRow = function(newP)
  {
    if (scope.loading)
    {
      //console.log("Currently loading. Please wait.");
      return;
    }
    // Save.
    if (scope.canSave() && scope.current)
    {
      var oldP = scope.current;
      var form = scope.currentForm;
      if (form.$invalid)
      {
        alert("Form not valid. Can't save.");
        return;
      }
      if (form.$dirty)
      {
        savePractitioner(oldP);
        // TODO: This is happening before the callback. Tsk tsk.
        form.$setPristine();
      }
      else
      {
//        console.log("No changes to save.");
      }
    }

    // Set current.
    if (scope.current == newP)
    {
      scope.current = null;
    }
    else
    {
      if (newP.is_new)
      {
        scope.current = newP;
      }
      else
      {
        scope.loading=newP;
        newP.$get({}, function(p)
        {
          createDatesInJsonData(p);
          scope.loading=null;
          scope.current = newP;
        });
      }
    }
  };

  scope.setCurrentForm = function(form)
  {
    // Need to set this with ngInit. This means that currentForm is set when a row is opened (because of the ngIf).
    scope.currentForm = form;
  };

  scope.certificateNumber = function(c)
  {
    var practitionertypePart = "E";
      // The + is to convert c.cert_type to a integer (don't know why it is not. Because select2?).
    var practitionertype = _.find(scope.valuelists["practitionertype"], {'id': +c.cert_type});
    if (practitionertype)
    {
      practitionertypePart = practitionertype.description1;
    }
    var numberPart = c.number ? ("00"+c.number).slice(-3) : "000";
    var yearPart = c.year ? c.year.toString().substr(2) : "00";
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
    return;
    _.forEach(p.practitioner_certificates, function(c)
    {
      var tempDate = new Date(c.date_of_entry.replace(/-/g,"/"));
      c.date_of_entry = filter('date')(tempDate, 'd. MMM yyyy');
    });
  };

}])