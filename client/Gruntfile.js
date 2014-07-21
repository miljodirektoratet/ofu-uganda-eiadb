module.exports = function (grunt)
{
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    clean: {
      options: {force: true},
      build: ["../build/app/*"]
    },

    concat: {
      css: {
        files: {
          '../build/app/vendor/vendor.min.css': [
            'bower_components/bootstrap/dist/css/bootstrap.min.css',
            'bower_components/select2/select2.css',
            'bower_components/select2-bootstrap-css/select2-bootstrap.css']
        }
      },
      js: {
        files: {
          '../build/app/vendor/vendor.min.js': [
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/angular/angular.min.js',
            'bower_components/angular-route/angular-route.min.js',
            'bower_components/angular-resource/angular-resource.min.js',
            'bower_components/angular-animate/angular-animate.min.js',
            'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
            'bower_components/select2/select2.js',
            'app/js/select2.js',
            'bower_components/lodash/dist/lodash.min.js']
        }
      }
    },

    uglify: {
      app: {
        options: {
          banner: '// Generated with grunt. Do not edit!\n\n'
        },
        files: {
          '../build/app/app.min.js': ['app/js/jqlite.extra.js', 'app/js/app.js',
            'app/js/controllers.js', 'app/js/practitionersController.js',
            'app/js/directives.js', 'app/js/filters.js',
            'app/js/services.js',
            'app/js/validations.js']
        }
      }
    },

    cssmin: {
      app: {
        options: {
          banner: '/* Generated with grunt. Do not edit! */\n\n'
        },
        files: {
          '../build/app/app.min.css': ['app/css/navbar.css', 'app/css/style.css', 'app/css/animations.css']
        }
      }
    },

    copy: {
      vendor: {
        files: [
          {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: '../build/app/vendor/fonts/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['bower_components/select2/select2.png'], dest: '../build/app/vendor/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['bower_components/select2/select2-spinner.gif'], dest: '../build/app/vendor/', filter: 'isFile'}
        ]
      },
      app: {
        files: [
          {expand: true, flatten: true, src: ['app/index.html'], dest: '../build/app/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['app/partials/*.html'], dest: '../build/app/partials/'},
          {expand: true, flatten: true, src: ['app/img/*.png'], dest: '../build/app/img/'},
          {expand: true, flatten: true, src: ['app/img/*.jpg'], dest: '../build/app/img/'},
          {expand: true, flatten: true, src: ['app/img/*.gif'], dest: '../build/app/img/'}
        ]
      }
    },

    replace:
    {
      bootstrapCss:
      {
        src: ['../build/app/vendor/vendor.min.css'],
        overwrite: true,
        replacements: [{ from: '../fonts/', to: 'fonts/' }]
      },
      styleCss:
      {
        src: ['../build/app/app.min.css'],
        overwrite: true,
        replacements: [{ from: '../img/', to: 'img/' }]
      },

      index:
      {
        src: ['../build/app/index.html'],
        overwrite: true,
        replacements: [
          { from: /<!-- Style begin -->[\s\S]*<!-- Style end -->/, to:
            '<link rel="stylesheet" href="vendor/vendor.min.css?v=<%= pkg.version %>"/>\n\t' +
            '<link rel="stylesheet" href="app.min.css?v=<%= pkg.version %>"/>'},
          { from: /<!-- Script begin -->[\s\S]*<!-- Script end -->/, to:
            '<script src="vendor/vendor.min.js?v=<%= pkg.version %>"></script>\n\t' +
            '<script src="app.min.js?v=<%= pkg.version %>"></script>'}]
      }
    },
    bump: {
      options: {
        files: ['package.json', 'bower.json', 'app/js/services.js'],
        updateConfigs: ['pkg'],
        commit: true,
        commitMessage: 'Release v%VERSION%',
        commitFiles: ['-a'], // '-a' for all files
        createTag: true,
        tagName: 'v%VERSION%',
        tagMessage: 'Version %VERSION%',
        push: false,
        pushTo: 'origin',
        gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d' // options to use with '$ git describe'
      }
    },

    release: {
      options: {
        bump: false, //default: true
        file: 'package.json',
        add: true,
        commit: false,
        tag: true,
        push: true,
        pushTags: true,
        npm: false,
        tagName: 'v<%= version %>'
        //commitMessage: 'release <%= version %>'
        //tagMessage: 'Version <%= version %>',
      }
    },

    gitcommit: {
      all: {
        options: {
          message: 'Lazy commit all.',
          verbose: true
        },
        files: {
          src: ['../.']
        }
      }
    }

//    watch: {
//      app: {
//        files: ['app/**/*'],
//        tasks: [],//tasks: ['app'],
//        options: {
//          spawn: false,
//          livereload: true
//        }
//      }
//      ,
//      index: {
//        files: ['public/index.php'],
//        options: {
//          spawn: false,
//          livereload: true
//        }
//      }
//    },

  });

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-text-replace');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-bump');
  grunt.loadNpmTasks('grunt-release');
  grunt.loadNpmTasks('grunt-git');

  grunt.loadNpmTasks('grunt-contrib-watch');


  grunt.registerTask('build', [
    'clean:build',
    'concat',
    'uglify',
    'cssmin',
    'copy',
    'replace'
  ]);

  grunt.registerTask('publish', [
    'bump-only',
    'build',
    'gitcommit:all',
    'release'
  ]);

  // If publish fails (deleted files must be commited manually because of changed behaviour in git 2.0, and this task doesn't add flag --all)
  grunt.registerTask('publish-only', [
    'build',
    'gitcommit:all',
    'release'
  ]);

};