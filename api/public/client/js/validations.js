var validations = angular.module('pax.validations');

// Info:
// https://docs.angularjs.org/api/ng/type/ngModel.NgModelController
// http://stackoverflow.com/questions/22841225/ngmodel-formatters-and-parsers
// https://docs.angularjs.org/guide/forms


validations.directive('decimal', function ()
{
    return {
        require: 'ngModel',
        link: function (scope, elm, attrs, ctrl)
        {
            var min = attrs.min ? parseFloat(attrs.min) : null;
            var max = attrs.max ? parseFloat(attrs.max) : null;
            var decimals = attrs.decimal ? '{0,' + parseInt(attrs.decimal) + '}' : '+';
            var minus = attrs.negativeNumber ? '\\-?' : '';
            var regexp = new RegExp('^' + minus + '\\d+((\\.|\\,)\\d' + decimals + ')?$');

            ctrl.$parsers.push(function (modelValue, viewValue)
            {
                if (ctrl.$isEmpty(modelValue))
                {
                    return null;
                }

                var ret = modelValue.toString().trim().replace(",", ".");
                var f = parseFloat(ret);
                if (!ctrl.$isEmpty(f))
                {
                    return f;
                }
                else
                {
                    return undefined;
                }
            });

            ctrl.$formatters.push(function formatter(modelValue)
            {
                if (!ctrl.$isEmpty(modelValue) && attrs.decimal)
                {
                    // TODO: _.round(parseInt(attrs.decimal)) is better. Update lodash.
                    return parseFloat(modelValue).toFixed(parseInt(attrs.decimal));
                }
                return modelValue;
            });

            ctrl.$validators.decimalInRange = function (modelValue, viewValue)
            {
                if (ctrl.$isEmpty(modelValue))
                {
                    return true;
                }
                if (regexp.test(viewValue))
                {
                    return isNumberInRange(min, max, viewValue);
                }
                return false;
            };
        }
    };
});

validations.directive('integer', function ()
{
    return {
        require: 'ngModel',
        link: function (scope, elm, attrs, ctrl)
        {
            var min = attrs.min ? parseInt(attrs.min) : null;
            var max = attrs.max ? parseInt(attrs.max) : null;
            var minus = attrs.negativeNumber ? '\\-?' : '';
            var regexp = new RegExp('^' + minus + '\\d+$');

            ctrl.$validators.integerInRange = function (modelValue, viewValue)
            {
                if (ctrl.$isEmpty(modelValue))
                {
                    return true;
                }
                if (regexp.test(viewValue))
                {
                    return isNumberInRange(min, max, viewValue);
                }
                return false;
            };
        }
    };
});

validations.directive('certificateNumber', function ()
{
    return {
        require: 'ngModel',
        link: function (scope, elm, attrs, ctrl)
        {
            var regexp = new RegExp('^CC\/(EIA|EA|EP)\/[0-9]{3}\/[0-9]{2}$');

            ctrl.$validators.certificateNumber = function (modelValue, viewValue)
            {
                if (ctrl.$isEmpty(modelValue))
                {
                    return true;
                }
                return regexp.test(viewValue);
            };
        }
    };
});

function isNumberInRange(min, max, number)
{
    if (min !== null && number < min)
    {
        return false;
    }
    if (max !== null && number > max)
    {
        return false;
    }
    return true;
}