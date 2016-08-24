module.exports = function(grunt) {
    
    grunt.initConfig({
        concat: {
            default: {
                src: [
                    'javascript/functions.js',
                    'javascript/moment.js',
                    'javascript/transition.js',
//                     'javascript/alert.js',
                    'javascript/button.js',
//                     'javascript/carousel.js',
                    'javascript/collapse.js',
                    'javascript/dropdown.js',
                    'javascript/modal.js',
                    'javascript/tooltip.js',
//                     'javascript/popover.js',
//                     'javascript/scrollspy.js',
                    'javascript/tab.js',
//                     'javascript/affix.js',
                    'javascript/Chart.js',
                    'javascript/chart-builder.js',
                    'javascript/colorpicker-color.js',
                    'javascript/colorpicker.js',
                    'javascript/bootstrap-datetimepicker.js',
                    'javascript/bootstrap-select.js',
                    'javascript/ajax-bootstrap-select.js',
                    'javascript/jquery.autosize.js',
                    'javascript/file-uploader.js',
                    'javascript/form-control-image.js',
                    'javascript/slugify.js',
                    'javascript/bootstrap-tokenfield.js',
                    'javascript/locationpicker.jquery.js',
                    'javascript/images-uploader.js',
                    'javascript/button-confirm.js',
                    'javascript/tinymce.js',
                    'javascript/object-filter.js',
                    'javascript/password-masker.js',
                    'javascript/google-map.js',
                    'javascript/list-group-filter.js',
                    'javascript/main.js'
                ],
                dest: 'js/portal.js'
            }
        },
        
        less: {
            default: {
                files: {
                    'css/style.css': 'less/bootstrap.less'
                }
            },
            dist: {
                files: {
                    'css/style.min.css': 'less/bootstrap.less'
                },
                options: {
                    compress: true
                }
            }
        },
        
        watch: {
            files: ['javascript/*.js', 'less/*.less', 'less/mixins/*.less'],
            tasks: ['concat', 'less']
        },
        
        uglify: {
            dist: {
                files: {
                    'js/portal.min.js': 'js/portal.js'
                },
                options: {
                    compress: true,
                    report: 'gzip',
                    preserveComments: false
                }
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    
    
    grunt.registerTask('dist', [
        'less:dist',
        'concat:default',
        'uglify:dist'
    ]);
}