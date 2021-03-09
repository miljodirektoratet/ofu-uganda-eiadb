module.exports = function(config){
    config.set({

        basePath : '../',

        files : [
            'bower_components/angular/angular.js',
            'bower_components/angular-route/angular-route.js',
            'bower_components/angular-mocks/angular-mocks.js',

            'app/js/app.js',
            'app/js/services.js',
            'app/js/projectFactory.js',
            'app/js/controllers.js',
            'app/js/practitionersController.js',
            'app/js/projectControllers.js',
            'app/js/eiasPermitsControllers.js',
            'app/js/auditsInspectionsControllers.js',
            'app/js/loginController.js',
            'app/js/PirkingController.js',
            'app/js/DataAnonymizerController.js',
            'app/js/filters.js',
            'app/js/directives.js',
            'app/js/validations.js',
            'test/unit/**/*.js'
        ],

        autoWatch : true,

        frameworks: ['jasmine'],

        browsers : ['Firefox'],//, 'Chrome'],

        plugins : [
            'karma-chrome-launcher',
            'karma-firefox-launcher',
            'karma-jasmine'
        ],

        junitReporter : {
            outputFile: 'test_out/unit.xml',
            suite: 'unit'
        }

    });
};