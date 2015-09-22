'use strict';

controllers.controller('SearchTabsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, $timeout, ProjectFactory, UserInfo, Valuelists)
{
    scope.SearchTabEnum = SearchTabEnum;
    scope.routeParams = routeParams;
    scope.userinfo = UserInfo;
    scope.valuelists = Valuelists;
    scope.data = ProjectFactory;

    var getCurrentTab = function (path)
    {
        if (_.contains(path, "projects"))
        {
            return SearchTabEnum.Projects;
        }
        if (_.contains(path, "eiaspermits"))
        {
            return SearchTabEnum.EiasPermits;
        }
        if (_.contains(path, "auditsinspections"))
        {
            return SearchTabEnum.AuditsInspections;
        }
        return null;
    };
    scope.tab = getCurrentTab(location.path());

}]);

controllers.controller('SearchAuditsInspectionsController', ['$scope', '$routeParams', '$location', '$q', '$timeout', 'ProjectFactory', 'UserInfo', 'Valuelists', function (scope, routeParams, location, $q, $timeout, ProjectFactory, UserInfo, Valuelists)
{

}]);

