module.exports = function( grunt ) {

  grunt.initConfig({

    //Uglify
    uglify : {
      options : {
        mangle : false
      },

      my_target : {
        files : {
          'js/champs.min.js' : [ 
            'assets/_js/nora/base/*.js',
            'assets/_js/nora/components/*.js',
            'assets/_js/nora/helpers/*.js',
            'assets/_js/nora/*.js',
            'assets/_js/*.js',
          ]
        }
      }
    }, 

    //Less
    less: {
      development: {
        options: {
          paths: [
            "assets/_css",
            "assets/_css/nora/base",
            "assets/_css/nora/components",
            "assets/_css/nora",
          ]
        },

        files: {
          "css/champs.css": [
            "assets/_css/nora/base/*.css",
            "assets/_css/nora/base/*.less",
            "assets/_css/nora/components/*.css",
            "assets/_css/nora/components/*.less",
            "assets/_css/nora/*.css",
            "assets/_css/nora/*.less",
            "assets/_css/*.css",
            "assets/_css/*.less",
          ]
        }
      }
    }, 

    //Watch
    watch : {
      dist : {
        files : [
          'assets/_js/nora/base/*.js',
          'assets/_js/nora/helpers/*.js',
          'assets/_js/nora/components/*.js',
          'assets/_js/nora/*.js',
          'assets/_js/*.js',
          'assets/_css/nora/components/*',
          'assets/_css/nora/base/*',
          'assets/_css/nora/*.css',
          'assets/_css/nora/*.less',
          'assets/_css/*.less',
          'assets/_css/*.css'
        ],

        tasks : [ 'uglify', 'less', 'cssmin' ]
      }
    }, 

    //Css Min
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'css',
          src: ['champs.css'],
          dest: 'css',
          ext: '.min.css'
        }]
      }
    }

  });

  // Plugins do Grunt
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks( 'grunt-contrib-watch' );
  grunt.loadNpmTasks('grunt-contrib-cssmin');


  // Tarefas que serão executadas
  grunt.registerTask( 'default', [ 'uglify', 'less', 'cssmin' ] );

  grunt.registerTask( 'w', [ 'watch' ] );
};