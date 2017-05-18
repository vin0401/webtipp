module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        less: {
            production: {
                files: {
                    'app/Resources/public/css/app.css': 'app/Resources/public/css/app.less'
                }
            }
        },
        exec: {
            createFontAweSomePath: {
                cmd: 'cp -R app/Resources/public/bower/font-awesome/fonts app/Resources/public/'
            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-exec');

    // Default task(s).
    grunt.registerTask('build', ['exec:createFontAweSomePath', 'less:production']);
};