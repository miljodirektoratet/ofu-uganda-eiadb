'use strict';

/* Directives */


var directives = angular.module('seroApp.directives', []).
  directive('appVersion', ['version', function (version)
  {
    return function (scope, elm, attrs)
    {
      elm.text(version);
    };
  }]);


directives.directive("addPractitionerButton", [ 'Practitioner', function (Practitioner)
{
  return {
    restrict: "A",
    link: function (scope, element, attrs)
    {
      element.bind("click", function ()
      {
        var newTest = new Practitioner({"person": "Gunnar Nymann", "city": "Oslo"});
        newTest.$save();
      });
    }
  }
}]);