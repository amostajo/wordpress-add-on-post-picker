/**
 * Grunt file.
 * Minifies JS with uglyfy.
 * Minifies CSS with cssmin.
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @version 1.0
 */
module.exports = function(grunt) {

	/**
	 * Project configuration.
	 * @since 1.0
	 */
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> Built date:<%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: 'src/js/<%= pkg.name %>.js',
				dest: 'src/build/<%= pkg.name %>.min.js'
			},
			vue: {
				src: [
					'vendor/bower_components/vue/dist/vue.min.js',
					'vendor/bower_components/vue-resource/dist/vue-resource.min.js'
				],
				dest: 'src/build/vue-<%= pkg.name %>.min.js'
			}
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					'src/build/<%= pkg.name %>.min.css': ['src/css/<%= pkg.name %>.css']
				}
			}
		},
        copy: {
            fonts: {
                nonull: true,
                expand: true,
                src: 'vendor/bower_components/font-awesome/fonts/*',
                dest: 'src/fonts/',
                flatten: true,
                filter: 'isFile'
            },
            fontawesome: {
                nonull: true,
                expand: true,
                src: 'vendor/bower_components/font-awesome/css/font-awesome.min.css',
                dest: 'src/build/',
                flatten: true,
                filter: 'isFile'
            }
        }
	});

	/**
	 * Load the plugin that provides the "uglify" task.
	 * @since 1.0
	 */
	grunt.loadNpmTasks('grunt-contrib-uglify');

	/**
	 * Load the plugin that provides the "cssmin" task.
	 * @since 1.0
	 */
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	/**
	 * Load the plugin that provides the "copy" task.
	 * @since 1.0
	 */
    grunt.loadNpmTasks('grunt-contrib-copy');

	/**
	 * Default task(s).
	 * @since 1.0
	 */
	grunt.registerTask('default', ['uglify', 'cssmin']);
};