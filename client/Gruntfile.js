module.exports = function (grunt)
{

  grunt.initConfig({
//    concat: {
//
//      vendor: {
//        files: {
//          'public/vendor/angular/angular.min.js': ['bower_components/angular/angular.min.js',
//            'bower_components/angular-route/angular-route.min.js',
//            'bower_components/angular-resource/angular-resource.min.js',
//            'bower_components/angular-bootstrap/ui-bootstrap.min.js'],
//          'public/vendor/angular/angular.js': ['bower_components/angular/angular.js',
//            'bower_components/angular-route/angular-route.js',
//            'bower_components/angular-resource/angular-resource.js',
//            'bower_components/angular-bootstrap/ui-bootstrap.js']
//        }
//      },
//      app: {
//        options: {
//          banner: '// Generated via grunt. Do not edit!\n\n'
//        },
//        files: {
//          'public/app.js': ['app/app.js']
//        }
//      }
//    },

//    copy: {
//      vendor: {
//        files: [
//          {expand: true, flatten: true, src: ['bower_components/angular*/*.map'], dest: 'public/vendor/angular/', filter: 'isFile'},
//          {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/css/bootstrap.*'], dest: 'public/vendor/bootstrap/css/', filter: 'isFile'},
//          {expand: true, flatten: true, src: ['bower_components/bootstrap/dist/fonts/*'], dest: 'public/vendor/bootstrap/fonts/', filter: 'isFile'},
//          {expand: true, flatten: true, src: ['bower_components/underscore/underscore.js'], dest: 'public/vendor/', filter: 'isFile'}
//        ]
//      }
//    },

    watch: {
      app: {
        files: ['app/**/*'],
        tasks: [],//tasks: ['app'],
        options: {
          spawn: false,
          livereload: true
        }
      }
//      ,
//      index: {
//        files: ['public/index.php'],
//        options: {
//          spawn: false,
//          livereload: true
//        }
//      }
    },

    bump: {
      options: {
        files: ['package.json', 'bower.json', 'app/js/app.js']//,
//        updateConfigs: [],
//        commit: true,
//        commitMessage: 'Release v%VERSION%',
//        commitFiles: ['package.json'], // '-a' for all files
//        createTag: true,
//        tagName: 'v%VERSION%',
//        tagMessage: 'Version %VERSION%',
//        push: true,
//        pushTo: 'upstream',
//        gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d' // options to use with '$ git describe'
      }
    }

  });

  grunt.loadNpmTasks('grunt-bower-install-simple');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-bump');

  grunt.registerTask('publish', [
    'bower-install-simple',
    'concat',
    'copy'
  ]);

  //grunt.registerTask('app', ['concat:app']);

};