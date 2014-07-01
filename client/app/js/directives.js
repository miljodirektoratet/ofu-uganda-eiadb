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


directives.directive('numberDecimal', function() {
  return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl)
    {
      ctrl.$parsers.unshift(function(viewValue)
      {
        var decimals = parseInt(attrs.numberDecimal);
        var minus = attrs.numberNegative ? '\\-?' : '';
        var regexp = new RegExp('^'+minus+'\\d+((\\.|\\,)\\d{0,'+decimals+'})?$');
        if (regexp.test(viewValue))
        {
          ctrl.$setValidity('float', true);
          return parseFloat(viewValue.replace(',', '.'));
        }
        else
        {
          ctrl.$setValidity('float', false);
          return undefined;
        }
      });
    }
  };
});

directives.directive('numberInteger', function() {
  return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl)
    {
      ctrl.$parsers.unshift(function(viewValue)
      {
        var minus = attrs.numberNegative ? '\\-?' : '';
        var regexp = new RegExp('^'+minus+'\\d+$');
        if (regexp.test(viewValue))
        {
          ctrl.$setValidity('integer', true);
          return parseFloat(viewValue.replace(',', '.'));
        }
        else
        {
          ctrl.$setValidity('integer', false);
          return undefined;
        }
      });
    }
  };
});