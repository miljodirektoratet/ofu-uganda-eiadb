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


directives.directive("addPractitionerButton", ['Practitioner', function (Practitioner)
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

directives.directive('animateNewElement', ['$animate', function(animate)
{
  return function(scope, element, attrs)
  {
    scope.$watch(attrs.animateNewElement, function(nv,ov)
    {
      if (nv === true)
      {
        console.log(element);
        var className = 'new-element';
        animate.addClass(element, className, function ()
        {
          animate.removeClass(element, className);
        });
      }
    })
  }
}]);

directives.directive('hoverOnParent', [function()
{
  return {
    restrict: "A",
    link: function (scope, element, attrs)
    {
      var selector = attrs.hoverOnParent;
      element.parent(selector).bind('mouseenter', function ()
      {
        element.addClass('btn-link-hover');
      });
      element.parent(selector).bind('mouseleave', function ()
      {
        element.removeClass('btn-link-hover');
      });
    }
  }
}]);