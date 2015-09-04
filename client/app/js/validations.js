var validations = angular.module('pax.validations', []);

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

            ctrl.$parsers.unshift(function (viewValue)
            {
                if (viewValue == null || viewValue === '')
                {
                    ctrl.$setValidity('float', true);
                    return undefined;
                }

                if (regexp.test(viewValue))
                {
                    var number = viewValue;
                    if (typeof viewValue !== "number")
                    {
                        number = parseFloat(viewValue.replace(',', '.'));
                    }
                    if (isNumberInRange(min, max, number))
                    {
                        ctrl.$setValidity('float', true);
                        return number;
                    }
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
                    var number = modelValue;
                    if (typeof modelValue !== "number")
                    {
                        number = parseFloat(modelValue.replace(',', '.'));
                    }
                    if (isNumberInRange(min, max, number))
                    {
                        ctrl.$setValidity('float', true);
                        return number;
                    }
                }
                ctrl.$setValidity('float', false);
                return modelValue;
            });
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

            ctrl.$parsers.unshift(function (viewValue)
            {
                // TODO: Why and how?
                if (viewValue == null || viewValue === '')
                {
                    ctrl.$setValidity('integer', true);
                    return undefined;
                }
                if (regexp.test(viewValue))
                {
                    var number = parseInt(viewValue);
                    if (isNumberInRange(min, max, number))
                    {
                        ctrl.$setValidity('integer', true);
                        return number;
                    }
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
                    var number = parseInt(modelValue);
                    if (isNumberInRange(min, max, number))
                    {
                        ctrl.$setValidity('integer', true);
                        return number;
                    }
                }
                ctrl.$setValidity('integer', false);
                return modelValue;
            });
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
            ctrl.$parsers.unshift(function (viewValue)
            {
                if (viewValue == null || viewValue === '')
                {
                    ctrl.$setValidity('certificate-number', true);
                    return undefined;
                }
                if (regexp.test(viewValue))
                {
                    ctrl.$setValidity('certificate-number', true);
                    return viewValue;
                }
                ctrl.$setValidity('certificate-number', false);
                return undefined;
            });

            ctrl.$formatters.push(function (modelValue)
            {
                if (modelValue == null || modelValue === '')
                {
                    ctrl.$setValidity('certificate-number', true);
                    return undefined;
                }
                if (regexp.test(modelValue))
                {
                    ctrl.$setValidity('certificate-number', true);
                    return modelValue;
                }
                ctrl.$setValidity('certificate-number', false);
                return modelValue;
            });
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