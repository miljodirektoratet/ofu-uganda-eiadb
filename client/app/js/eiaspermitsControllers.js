'use strict';

controllers.controller('EiasPermitsController', ['$scope', 'ProjectFactory', function (scope, ProjectFactory)
{
  scope.isNewEiaPermit = false;
  scope.parts =
  {
    eiapermit:
    {
      form:null,
      state:SavingStateEnum.Loading
    },
    document:
    {
      form:null,
      state:SavingStateEnum.None
    }
  };

  scope.hasEiaPermit = function()
  {
    return !_.isEmpty(scope.data.eiapermit);
  };

  scope.saveCurrentEiaPermit = function()
  {
    var eiapermit = scope.data.eiapermit;
    scope.saveCurrent(scope.parts.eiapermit, eiapermit).then(function(ep)
    {
      if (scope.isNewEiaPermit)
      {
        scope.goto("/projects/"+scope.data.project.id+"/eiaspermits/"+ep.id);
      }
    });
  };

  scope.saveCurrentDocument = function()
  {
    var document = scope.data.document;
    scope.saveCurrent(scope.parts.document, document).then(function(d)
    {
    });
  };

  scope.newDocument = function()
  {
    ProjectFactory.createNewDocument(scope.data.eiapermit);
    //scope.toggleDocument(scope.data.document);
  }

  scope.deleteEiaPermit = function()
  {
    ProjectFactory.deleteEiaPermit(scope.routeParams);
    scope.goto("/projects/"+scope.data.project.id);
  }

  scope.toggleDocument = function(d)
  {
//    if (scope.loading)
//    {
//      //console.log("Currently loading. Please wait.");
//      return;
//    }
    if (scope.data.document == d)
    {
      scope.data.document = {};
      scope.parts.document.state = SavingStateEnum.None;
    }
    else
    {
      if (d.is_new)
      {
        scope.data.document = d;
      }
      else
      {
        d.$get(scope.routeParams, function(d)
        {
          scope.data.document = d;
        });
      }
    }
  };

  scope.calculateNumberOfCopiesOfDocument = function()
  {
    scope.data.document.director_copy_no = 1;
    scope.data.document.coordinator_copy_no = scope.data.document.sub_copy_no - 1;
  };

  scope.calculateDocumentCode = function()
  {
    var typeObject = _.find(scope.valuelists["documenttype"], {'id': parseInt(scope.data.document.type)});
    var typeCode = typeObject ? typeObject.description1 : "";
    var number = scope.data.document.number ? scope.data.document.number : "";
    scope.data.document.code = typeCode + number;
  };

  scope.auth.canSave = function(field)
  {
    switch(field)
    {
      case "new":
      case "delete":
        return scope.userinfo.info.role_1;
      case "teamleader_id":
      case "practitioner_id":
      case "cost":
      case "cost_currency":
      case "status":
      case "document.date_submitted":
      case "document.sub_copy_no":
      case "document.title":
      case "document.type":
      case "document.number":
      case "document.code":
      case "document.consultent":
      case "document.director_copy_no":
      case "document.date_sent_director":
      case "document.coordinator_copy_no":
      case "document.date_copies_coordinator":
      case "document.date_next_appointment":
      case "document.date_sent_from_dep":
      case "document.folio_no":
      case "document.remarks":
        return scope.userinfo.info.role_1;
      case "user_id":
        return scope.userinfo.info.role_2;
      case "inspection_recommended":
      case "date_inspection":
      case "officer_recommend":
      case "fee":
      case "fee_currency":
      case "remarks":
      case "date_sent_ded_approval":
      case "document.sub_final":
      case "document.date_sent_officer":
        return scope.userinfo.info.role_3;
      case "date_fee_notification":
      case "date_fee_payed":
      case "fee_receipt_no":
        return scope.userinfo.info.role_4;
      case "decision":
      case "date_decision":
      case "designation":
      case "date_certificate":
      case "certificate_no":
      case "date_cancelled":
      case "document.conclusion":
        return scope.userinfo.info.role_5;
      default:
        return false;
    }
  };

  var promises = ProjectFactory.retrieveProjectData(scope.routeParams);
  promises[3].then(function(ep)
  {
    scope.parts.eiapermit.state = SavingStateEnum.Loaded;
  });

  if (scope.routeParams.eiapermitId == "new")
  {
    ProjectFactory.createNewEiaPermit(scope.data.project);
    scope.isNewEiaPermit = true;
    scope.parts.eiapermit.state = SavingStateEnum.Loaded;
    scope.parts.eiapermit.isNew = true;
  }
}]);