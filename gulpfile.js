/**
 * Gulp configuration file.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: arras
 * @version: 4.0.0
 */

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    return gulp.src('./assets/styles/sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/styles'));
});

gulp.task('sass:watch', function () {
    gulp.watch('./assets/styles/sass/**/*.scss', ['sass']);
});

// Do nothing on default.
gulp.task( 'default', function() {
    "use strict";

});