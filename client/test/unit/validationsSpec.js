'use strict';

/* jasmine specs for directives go here */

describe('validations.integer', function()
{
  var $scope, form;
  beforeEach(module('pax.validations'));

  describe('positive integer', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" integer />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass with integer', function()
    {
      form.somenum.$setViewValue(3);
      expect($scope.model.somenum).toEqual(3);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with integer as string', function()
    {
      form.somenum.$setViewValue('3');
      expect($scope.model.somenum).toEqual(3);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass with string', function()
    {
      form.somenum.$setViewValue('a');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should not pass with float', function()
    {
      form.somenum.$setViewValue(1.2);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should not pass with float as string', function()
    {
      form.somenum.$setViewValue('1,2');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should not pass with negative integer', function()
    {
      form.somenum.$setViewValue(-4);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should pass with big integers', function()
    {
      form.somenum.$setViewValue('123456789012345678903333456777533312');
      expect($scope.model.somenum).toEqual(123456789012345678903333456777533312);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass with small floats', function()
    {
      form.somenum.$setViewValue('0.000000000000000000000000000000000000000000123');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should pass with null', function()
    {
      form.somenum.$setViewValue(null);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with 0', function()
    {
      form.somenum.$setViewValue(0);
      expect($scope.model.somenum).toBe(0);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with empty string', function()
    {
      form.somenum.$setViewValue('');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when inits with integer', function()
    {
      $scope.model = { somenum: 2 };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when inits with null', function()
    {
      $scope.model = { somenum: null };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when inits with string', function()
    {
      $scope.model = { somenum: 'notint' };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(false);
    });
  });

  describe('negative integer', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" integer negative-number="true" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass with negative integer', function()
    {
      form.somenum.$setViewValue(-5);
      expect($scope.model.somenum).toEqual(-5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with negative integer as string', function()
    {
      form.somenum.$setViewValue('-5');
      expect($scope.model.somenum).toEqual(-5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass with string', function()
    {
      form.somenum.$setViewValue('notint');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should pass with positive integer', function()
    {
      form.somenum.$setViewValue(5);
      expect($scope.model.somenum).toEqual(5);
      expect(form.somenum.$valid).toBe(true);
    });
  });

  describe('integer with min', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" integer min="10" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass when equal to min', function()
    {
      form.somenum.$setViewValue(10);
      expect($scope.model.somenum).toEqual(10);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when greater than min', function()
    {
      form.somenum.$setViewValue(11);
      expect($scope.model.somenum).toEqual(11);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when less than min', function()
    {
      form.somenum.$setViewValue(9);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
  });

  describe('integer with max', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" integer max="10" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass when equal to max', function()
    {
      form.somenum.$setViewValue(10);
      expect($scope.model.somenum).toEqual(10);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when less than max', function()
    {
      form.somenum.$setViewValue(9);
      expect($scope.model.somenum).toEqual(9);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when greater than max', function()
    {
      form.somenum.$setViewValue(11);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
  });

});


describe('validations.decimal', function()
{
  var $scope, form;
  beforeEach(module('pax.validations'));

  describe('positive decimal2', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" decimal="2" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass with integer', function()
    {
      form.somenum.$setViewValue(3);
      expect($scope.model.somenum).toEqual(3);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with decimal as string', function()
    {
      form.somenum.$setViewValue('3,5');
      expect($scope.model.somenum).toEqual(3.5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass with string', function()
    {
      form.somenum.$setViewValue('a');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should not pass with negative decimal', function()
    {
      form.somenum.$setViewValue(-4.5);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should not pass with more decimals than 2', function()
    {
      form.somenum.$setViewValue('2.693');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should pass with 2 decimals', function()
    {
      form.somenum.$setViewValue('2.69');
      expect($scope.model.somenum).toEqual(2.69);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with null', function()
    {
      form.somenum.$setViewValue(null);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with 0', function()
    {
      form.somenum.$setViewValue(0);
      expect($scope.model.somenum).toBe(0);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with empty string', function()
    {
      form.somenum.$setViewValue('');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when inits with decimal', function()
    {
      $scope.model = { somenum: 2.2 };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when inits with null', function()
    {
      $scope.model = { somenum: null };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when inits with string', function()
    {
      $scope.model = { somenum: 'notdecimal' };
      $scope.$digest();
      expect(form.somenum.$valid).toBe(false);
    });
  });

  describe('negative decimalX', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" decimal negative-number="true" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass with negative integer', function()
    {
      form.somenum.$setViewValue(5.2);
      expect($scope.model.somenum).toEqual(5.2);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with negative decimal', function()
    {
      form.somenum.$setViewValue(-5.4);
      expect($scope.model.somenum).toEqual(-5.4);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with negative decimal as string', function()
    {
      form.somenum.$setViewValue('-5,4');
      expect($scope.model.somenum).toEqual(-5.4);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass with string', function()
    {
      form.somenum.$setViewValue('notdecimal');
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
    it('should pass with positive decimal', function()
    {
      form.somenum.$setViewValue(5.4);
      expect($scope.model.somenum).toEqual(5.4);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with many decimals when not specified', function()
    {
      form.somenum.$setViewValue(5.412345657);
      expect($scope.model.somenum).toEqual(5.412345657);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with big decimal', function()
    {
      form.somenum.$setViewValue('12345670315.678903777533312');
      expect($scope.model.somenum).toEqual(12345670315.678903777533312);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass with small decimal', function()
    {
      form.somenum.$setViewValue('0.000000000000000000000000000000000000000000123');
      expect($scope.model.somenum).toEqual(0.000000000000000000000000000000000000000000123);
      expect(form.somenum.$valid).toBe(true);
    });
  });

  describe('decimal with min', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" decimal min="10.5" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass when equal to min', function()
    {
      form.somenum.$setViewValue(10.5);
      expect($scope.model.somenum).toEqual(10.5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when greater than min', function()
    {
      form.somenum.$setViewValue(11.5);
      expect($scope.model.somenum).toEqual(11.5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when less than min', function()
    {
      form.somenum.$setViewValue(10.499);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
  });

  describe('decimal with max', function()
  {
    beforeEach(inject(function($compile, $rootScope)
    {
      $scope = $rootScope;
      var element = angular.element('<form name="form">' + '<input ng-model="model.somenum" name="somenum" decimal max="10.5" />' + '</form>');
      $scope.model = { somenum: null };
      $compile(element)($scope);
      $scope.$digest();
      form = $scope.form;
    }));

    it('should pass when equal to max', function()
    {
      form.somenum.$setViewValue(10.5);
      expect($scope.model.somenum).toEqual(10.5);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should pass when less than max', function()
    {
      form.somenum.$setViewValue(10.499);
      expect($scope.model.somenum).toEqual(10.499);
      expect(form.somenum.$valid).toBe(true);
    });
    it('should not pass when greater than max', function()
    {
      form.somenum.$setViewValue(10.51);
      expect($scope.model.somenum).toBeUndefined();
      expect(form.somenum.$valid).toBe(false);
    });
  });

});