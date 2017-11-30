module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "public/css/wp-notes-public.css": "public/less/wp-notes-public.less",
          "admin/css/wp-notes-admin.css": "admin/less/wp-notes-admin.less"
        }
      }
    },
    watch: {
      styles: {
        files: ['**/less/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  // Default task(s).
  grunt.registerTask('default', ['less', 'watch']);

};