'use strict';

services.factory('AdvancedFactory', ['$q', '$filter', 'EditCode', 'Valuelists', function ($q, $filter, EditCode, Valuelists)
{
    var factory = {};
    factory.codes = [];
    factory.code = {};
    factory.valuelists = Valuelists;
    factory.retrieveData = function ()
    {
        var deferredCodes = $q.defer();

        factory.empty();

        factory.codes = EditCode.query({}, function (cs)
        {
            deferredCodes.resolve(cs);
        });

        return [deferredCodes.promise];
    };

    factory.retrieveC = function (params)
    {
        var deferred = $q.defer();
        if (params.eiapermitId)
        {
            var hits = $filter('filter')(factory.eiaspermits, {'id': params.eiapermitId});
            if (hits.length == 1)
            {
                factory.eiapermit = hits[0];
                factory.eiapermit.$get(params, function (ep)
                {
                    factory.documents = Document.query(params, function (ds)
                    {

                    });
                    deferred.resolve(ep);
                });
            }
        }
        /*        else if (factory.eiaspermits.length > 0)
         {
         if (_.isEmpty(factory.eiapermit))
         {
         factory.eiapermit = factory.eiaspermits[0];
         }
         }*/
        return deferred.promise;
    };

    factory.empty = function ()
    {
        factory.codes = [];
        factory.code = {};
    };

    factory.createNewCode = function ()
    {
        factory.project = new Code({});
    };

    factory.deleteCode = function (params)
    {
        var index = _.findIndex(factory.codes, {'id': factory.code.id});
        var onDelete = function (index)
        {
            factory.codes.splice(index, 1);
            factory.code = {};
        };
        factory.code.$delete(params, function ()
        {
            onDelete(index);
        });
    };

    factory.save = function (resource)
    {
        var deferred = $q.defer();
        if (resource.is_new)
        {
            //console.log(params);
            resource.$save({}, function (data)
            {
                deferred.resolve(data);
            }, function ()
            {
                deferred.reject("Saving new failed");
            });
        }
        else
        {
            resource.$update({}, function (data)
            {
                deferred.resolve(data);
            }, function ()
            {
                deferred.reject("Saving exisiting failed");
            });
        }
        return deferred.promise;
    };

    return factory;
}]);