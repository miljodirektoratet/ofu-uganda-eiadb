var validations = angular.module('pax.validations', []);

validations.directive('decimal', function() {
  return {
    require: 'ngModel',
    link: function(scope, elm, attrs, ctrl)
    {
      var decimals = parseInt(attrs.decimal);
      var minus = attrs.numberNegative ? '\\-?' : '';
      var regexp = new RegExp('^'+minus+'\\d+((\\.|\\,)\\d{0,'+decimals+'})?$');

      ctrl.$parsers.unshift(function(viewValue)
      {
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

      ctrl.$formatters.push(function (modelValue)
      {
        if (modelValue === undefined)
        {
          return undefined;
        }
        console.log(regexp, modelValue);
        if (!regexp.test(modelValue))
        {
          ctrl.$setValidity('float', false);
        }
        // Return the original value regardless of its validity,
        // so it shows up in the view (even if it is invalid).
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
      var minus = attrs.numberNegative ? '\\-?' : '';
      var regexp = new RegExp('^'+minus+'\\d+$');

      ctrl.$parsers.unshift(function(viewValue)
      {
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

      ctrl.$formatters.push(function (modelValue)
      {
        console.log(regexp, modelValue);
        if (!regexp.test(modelValue))
        {
          ctrl.$setValidity('integer', false);
        }
        // Return the original value regardless of its validity,
        // so it shows up in the view (even if it is invalid).
        return modelValue;
      });
    }
  };
});