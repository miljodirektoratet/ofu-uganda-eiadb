var validations = angular.module('pax.validations', []);

validations.directive('decimal', function() {
  return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl)
    {
      var decimals = attrs.decimal ? '{0,'+parseInt(attrs.decimal)+'}' : '+';
      var minus = attrs.negativeNumber ? '\\-?' : '';
      var regexp = new RegExp('^'+minus+'\\d+((\\.|\\,)\\d'+decimals+')?$');

      ctrl.$parsers.unshift(function(viewValue)
      {
        if (viewValue == null || viewValue === '')
        {
          ctrl.$setValidity('float', true);
          return undefined;
        }

        if (regexp.test(viewValue))
        {
          ctrl.$setValidity('float', true);
          if (typeof viewValue === "number")
          {
            return viewValue;
          }
          return parseFloat(viewValue.replace(',', '.'));
        }
        ctrl.$setValidity('float', false);
        return undefined;
      });

      ctrl.$formatters.push(function (modelValue)
      {
        if (modelValue == null || modelValue === '')
        {
          ctrl.$setValidity('float', true);
          return undefined;
        }
        if (regexp.test(modelValue))
        {
          ctrl.$setValidity('float', true);
          return modelValue;
        }
        ctrl.$setValidity('float', false);
        return modelValue;
      });
    }
  };
});

validations.directive('integer', function() {
  return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl)
    {
      var minus = attrs.negativeNumber ? '\\-?' : '';
      var regexp = new RegExp('^'+minus+'\\d+$');

      ctrl.$parsers.unshift(function(viewValue)
      {
        if (viewValue == null || viewValue === '')
        {
          ctrl.$setValidity('integer', true);
          return undefined;
        }
        if (regexp.test(viewValue))
        {
          ctrl.$setValidity('integer', true);
          return parseInt(viewValue);
        }
        ctrl.$setValidity('integer', false);
        return undefined;
      });

      ctrl.$formatters.push(function (modelValue)
      {
        if (modelValue == null || modelValue === '')
        {
          ctrl.$setValidity('integer', true);
          return undefined;
        }
        if (regexp.test(modelValue))
        {
          ctrl.$setValidity('integer', true);
          return modelValue;
        }
        ctrl.$setValidity('integer', false);
        return modelValue;
      });
    }
  };
});