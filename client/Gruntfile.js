module.exports = function(grunt)
{
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    paths: {
      buildPath: '../api/public/app/',
      devPath: '../api/public/dev/'
    },

    generatedBanner: '// Generated with grunt. Do not edit!\n\n'
  });

  grunt.loadNpmTasks('grunt-sync');
  grunt.config('sync', {
    dev: {
      files: [
        {src: ['bower_components/**'], dest: '<%= paths.devPath %>'},
        {cwd: 'app/', src: ['**'], dest: '<%= paths.devPath %>'},
      ],
    }
  });

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.config('clean', {
    options: {force: true},
    build: ['<%= paths.buildPath %>*'],
    dev: ['<%= paths.devPath %>*']
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.config('concat', {
    build: {
      files: {
        '<%= paths.buildPath %>vendor/vendor.min.css': [
          'bower_components/bootstrap/dist/css/bootstrap.min.css',
          'bower_components/select2/select2.css',
          'bower_components/select2-bootstrap-css/select2-bootstrap.css'
        ],
        '<%= paths.buildPath %>vendor/vendor.min.js': [
          'bower_components/jquery/dist/jquery.min.js',
          'bower_components/angular/angular.min.js',
          'bower_components/angular-route/angular-route.min.js',
          'bower_components/angular-resource/angular-resource.min.js',
          'bower_components/angular-animate/angular-animate.min.js',
          'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
          'bower_components/select2/select2.js',
          'app/js/select2.js',
          'bower_components/lodash/dist/lodash.min.js'
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
          'app/js/jqlite.extra.js', 'app/js/app.js',
          'app/js/controllers.js', 'app/js/practitionersController.js', 'app/js/projectControllers.js',
          'app/js/loginController.js',
          'app/js/directives.js', 'app/js/filters.js',
          'app/js/services.js',
          'app/js/validations.js'
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
          'app/css/navbar.css', 'app/css/style.css', 'app/css/animations.css'
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-angular-templates');
  grunt.config('ngtemplates', {
    build:
    {
      cwd: 'app/',
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
        {expand: true, flatten: true, src: ['app/index.html'], dest: '<%= paths.buildPath %>', filter: 'isFile'},
        {expand: true, flatten: false, cwd: 'app/', src: ['img/**'], dest: '<%= paths.buildPath %>'}
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

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.config('watch', {
    src: {
      files: ['*.html', '*.js', 'app/**', '!lib/dontwatch.js'],
      tasks: ['sync:dev'],
    },
  });

  grunt.loadNpmTasks('grunt-bump');
  grunt.config('bump', {
    options: {
      files: ['package.json', 'bower.json', 'app/js/services.js'],
      updateConfigs: ['pkg'],
      commit: true,
      commitMessage: 'Release v%VERSION%',
      commitFiles: ['-a'], // '-a' for all files
      createTag: true,
      tagName: 'v%VERSION%',
      tagMessage: 'Version %VERSION%',
      push: true,
      pushTo: 'origin',
      gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d' // options to use with '$ git describe'
    }
  });

  grunt.registerTask('dev', [
    'clean:dev',
    'sync:dev',
    'watch'
  ]);

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
    'bump-only',
    'build',
    'bump-commit'
    //'release',
  ]);

  grunt.registerTask('publish-minor', [
    'bump-only:minor',
    'build',
    'bump-commit'
    //'release',
  ]);

};