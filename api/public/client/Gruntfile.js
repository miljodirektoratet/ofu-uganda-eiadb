module.exports = function(grunt)
{
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        paths: {
            buildPath: '../app/'
        },

        generatedBanner: '// Generated with grunt. Do not edit!\n\n'
    });


    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.config('clean', {
        options: {force: true},
        build: ['<%= paths.buildPath %>*']
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.config('concat', {
        build: {
            files: {
                '<%= paths.buildPath %>vendor/vendor.min.css': [
                    'bower_components/bootstrap/dist/css/bootstrap.min.css',
                    'bower_components/select2/select2.css',
                    'bower_components/select2-bootstrap-css/select2-bootstrap.css',
                    'bower_components/angular-ui-grid/ui-grid.min.css'
                ],
                '<%= paths.buildPath %>vendor/vendor.min.js': [
                    'bower_components/jquery/dist/jquery.min.js',
                    'bower_components/angular/angular.min.js',
                    'bower_components/angular-route/angular-route.min.js',
                    'bower_components/angular-resource/angular-resource.min.js',
                    'bower_components/angular-animate/angular-animate.min.js',
                    'bower_components/angular-messages/angular-messages.min.js',
                    'bower_components/angular-sanitize/angular-sanitize.min.js',
                    'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
                    'bower_components/select2/select2.min.js',
                    'js/select2.js',
                    'bower_components/lodash/lodash.min.js',
                    'bower_components/ng-file-upload/ng-file-upload-all.min.js',
                    'bower_components/angular-ui-grid/ui-grid.min.js'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.config('uglify', {
        build: {
            options: {
                banner: '<%= generatedBanner %>'
            },
            files: {
                '<%= paths.buildPath %>app.min.js': [
                    'js/jqlite.extra.js',
                    'js/app.js',
                    'js/controllers.js', 'js/practitionersController.js',
                    'js/projectControllers.js',
                    'js/eiaspermitsTabsController.js', 'js/eiaspermitsController.js', 'js/eiasPermitsDocumentsController.js', 'js/eiasPermitsHearingsController.js',
                    'js/externalauditsTabsController.js', 'js/externalauditsController.js', 'js/externalauditsDocumentsController.js',
                    'js/auditsInspectionsControllers.js',
                    'js/permitslicensesController.js',
                    'js/searchControllers.js', 'js/searchEiasPermitsControllers.js', 'js/searchPermitsLicensesControllers.js', 'js/statisticsControllers.js', 'js/searchExternalAuditsControllers.js',
                    'js/advancedController.js', 'js/loginController.js',
                    'js/directives.js', 'js/filters.js',
                    'js/services.js', 'js/projectFactory.js', 'js/advancedFactory',
                    'js/validations.js',
                    'js/excelLib.js',
                    'js/excelExport.js'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.config('cssmin', {
        build: {
            options: {
                banner: '<%= generatedBanner %>'
            },
            files: {
                '<%= paths.buildPath %>app.min.css': [
                    'css/navbar.css', 'css/style.css', 'css/animations.css'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.config('ngtemplates', {
        build:
        {
            cwd: '',
            src: 'partials/*.html',
            dest: '<%= paths.buildPath %>partials.min.js',
            options:
            {
                module: 'seroApp',
                htmlmin: {
                    collapseBooleanAttributes:      true,
                    collapseWhitespace:             true,
                    removeAttributeQuotes:          true,
                    removeComments:                 true, // Only if you don't use comment directives!
                    removeEmptyAttributes:          true,
                    removeRedundantAttributes:      true,
                    removeScriptTypeAttributes:     true,
                    removeStyleLinkTypeAttributes:  true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.config('copy', {
        build: {
            files: [
                {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: '<%= paths.buildPath %>vendor/fonts/', filter: 'isFile'},
                {expand: true, flatten: true, src: ['bower_components/select2/select2.png'], dest: '<%= paths.buildPath %>vendor/', filter: 'isFile'},
                {expand: true, flatten: true, src: ['bower_components/select2/select2-spinner.gif'], dest: '<%= paths.buildPath %>vendor/', filter: 'isFile'},
                {expand: true, flatten: true, src: ['bower_components/angular-ui-grid/ui-grid.svg','bower_components/angular-ui-grid/ui-grid.ttf','bower_components/angular-ui-grid/ui-grid.woff'], dest: '<%= paths.buildPath %>vendor/', filter: 'isFile'},
                {expand: true, flatten: true, src: ['index.html'], dest: '<%= paths.buildPath %>', filter: 'isFile'},
                {expand: true, flatten: false, src: ['img/**'], dest: '<%= paths.buildPath %>'}
            ]
        }
    });

    grunt.loadNpmTasks('grunt-text-replace');
    grunt.config('replace', {
        bootstrapCss:
        {
            src: ['<%= paths.buildPath %>vendor/vendor.min.css'],
            overwrite: true,
            replacements: [{ from: '../fonts/', to: 'fonts/' }]
        },
        styleCss:
        {
            src: ['<%= paths.buildPath %>app.min.css'],
            overwrite: true,
            replacements: [{ from: '../img/', to: 'img/' }]
        },
        debug:
        {
            src: ['<%= paths.buildPath %>partials.min.js'],
            overwrite: true,
            replacements: [{ from: /\(Dirty.*?\)/g, to: '' }]
        },
        index:
        {
            src: ['<%= paths.buildPath %>index.html'],
            overwrite: true,
            replacements: [
                {
                    from: /<!-- Style begin -->[\s\S]*<!-- Style end -->/,
                    to: '<link rel="stylesheet" href="vendor/vendor.min.css?v=<%= pkg.version %>"/>\n\t' +
                    '<link rel="stylesheet" href="app.min.css?v=<%= pkg.version %>"/>'
                },
                {
                    from: /<!-- Script begin -->[\s\S]*<!-- Script end -->/,
                    to: '<script src="vendor/vendor.min.js?v=<%= pkg.version %>"></script>\n\t' +
                    '<script src="app.min.js?v=<%= pkg.version %>"></script>\n\t' +
                    '<script src="partials.min.js?v=<%= pkg.version %>"></script>'
                }
            ]
        }
    });

    grunt.loadNpmTasks('grunt-bump');
    grunt.config('bump', {
        options: {
            files: ['package.json', 'bower.json', 'js/services.js'],
            updateConfigs: ['pkg'],
            commit: true,
            commitMessage: 'Release v%VERSION%',
            commitFiles: ['-a'], // '-a' for all files
            createTag: true,
            tagName: 'v%VERSION%',
            tagMessage: 'Version %VERSION%',
            push: true,
            pushTo: 'origin',
            gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d', // options to use with '$ git describe'
            regExp: false
        }
    });


    grunt.registerTask('build', [
        'clean:build',
        'concat:build',
        'uglify:build',
        'cssmin:build',
        'ngtemplates:build',
        'copy:build',
        'replace:bootstrapCss',
        'replace:styleCss',
        'replace:debug',
        'replace:index'
    ]);

    grunt.registerTask('publish', [
        'bump-only:minor',
        'build',
        'bump-commit'
    ]);

    grunt.registerTask('publish-major', [
        'bump-only:major',
        'build',
        'bump-commit'
    ]);

};