'use strict';

/* Services */

var version = {"version": "0.0.4"};

// Demonstrate how to register services
// In this case it is a simple value service.
var services = angular.module('seroApp.services', []).
  value("version", version.version);

services.factory('PractitionersService', ['$resource', function ($resource)
{
  // TODO: Use anything to auth? (for example auth-token).
  // {headers: { 'auth-token': 'C3PO R2D2' }}
  return $resource('/api/public/v1/practitioner/:practitionerId', { practitionerId: '@practitionerId' });
}]);