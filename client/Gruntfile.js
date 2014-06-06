module.exports = function (grunt)
{

  grunt.initConfig({

    clean: {
      options: {force: true},
      build: ["../build/app/*"]
    },

    concat: {

      vendor: {
        files: {
          '../build/app/vendor/angular.min.js': [
            'bower_components/angular/angular.min.js',
            'bower_components/angular-route/angular-route.min.js',
            'bower_components/angular-resource/angular-resource.min.js',
            'bower_components/angular-bootstrap/ui-bootstrap.min.js']
        }
      }
    },

    uglify: {
      app: {
        options: {
          banner: '// Generated with grunt. Do not edit!\n\n'
        },
        files: {
          '../build/app/app.min.js': ['app/js/app.js','app/js/controllers.js', 'app/js/directives.js', 'app/js/filters.js', 'app/js/services.js']
        }
      }
    },

    cssmin: {
      app: {
        options: {
          banner: '/* Generated with grunt. Do not edit! */\n\n'
        },
        files: {
          '../build/app/app.min.css': ['app/css/navbar.css', 'app/css/style.css']
        }
      }
    },

    copy: {
      vendor: {
        files: [
          {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/css/bootstrap.min.css'], dest: '../build/app/vendor/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: '../build/app/vendor/fonts/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['bower_components/lodash/dist/lodash.min.js'], dest: '../build/app/vendor/', filter: 'isFile'}
        ]
      },
      app: {
        files: [
          {expand: true, flatten: true, src: ['app/index.html'], dest: '../build/app/', filter: 'isFile'},
          {expand: true, flatten: true, src: ['app/partials/*.html'], dest: '../build/app/partials/'},
          {expand: true, flatten: true, src: ['app/img/*.png'], dest: '../build/app/img/'},
          {expand: true, flatten: true, src: ['app/img/*.jpg'], dest: '../build/app/jpg/'}
        ]
      }
    },

    replace: {
      bootstrapCss: {
        src: ['../build/app/vendor/bootstrap.min.css'],
        overwrite: true,
        replacements: [{ from: '../fonts/', to: 'fonts/' }]
      },
      index: {
        src: ['../build/app/index.html'],
        overwrite: true,
        replacements: [
          { from: /<!-- Style begin -->[\s\S]*<!-- Style end -->/, to:
            '<link rel="stylesheet" href="vendor/bootstrap.min.css"/>\n\t' +
            '<link rel="stylesheet" href="app.min.css"/>'},
          { from: /<!-- Script begin -->[\s\S]*<!-- Script end -->/, to:
            '<script src="vendor/angular.min.js"></script>\n\t' +
            '<script src="vendor/lodash.min.js"></script>\n\t' +
            '<script src="app.min.js"></script>'}]
      }
    },

    bump: {
      options: {
        files: ['package.json', 'bower.json', 'app/js/services.js'],
        updateConfigs: [],
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
        commit: true,
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
          verbose: true,
          all: true
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

  grunt.loadNpmTasks('grunt-bower-install-simple');
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
    'bower-install-simple',
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

};