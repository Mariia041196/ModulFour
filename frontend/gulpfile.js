var gulp = require("gulp"),
    uglify = require("gulp-uglify"),
    watch = require("gulp-watch")
;

// Minifies JS
gulp.task('js', function(){
    return watch('js/*.js', function() {
        gulp.src('js/*.js')
            .pipe(uglify())
            .pipe(gulp.dest('../webroot/js'))
    })
});

gulp.task('default', function() {
    gulp.run('js');
});