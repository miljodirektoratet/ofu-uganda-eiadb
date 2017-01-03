'use strict';

controllers.controller('EiasPermitsTabsController', ['$scope', '$location', function (scope, location)
{
    scope.fileUploadPattern = fileUploadPattern;
    scope.fileUploadNgfPattern = fileUploadNgfPattern;
    scope.fileUploadMaxSize = fileUploadMaxSize;

    scope.EiasPermitsTabEnum = EiasPermitsTabEnum;

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "hearings"))
        {
            return EiasPermitsTabEnum.Hearings;
        }
        if (_.contains(path, "documents"))
        {
            return EiasPermitsTabEnum.Documents;
        }
        return EiasPermitsTabEnum.EiaPermit;
    };
    scope.eptab = getCurrentTab(location.path());

    scope.checkDisabled = function(number, $event)
    {
        if (scope.isDisabled(number))
        {
            $event.preventDefault();
        }
    };

    scope.isDisabled = function(number)
    {
        return _.isUndefined(number);
    };
}]);