/**
 * Modeled mostly after WebDevStudios
 * @see https://github.com/WebDevStudios/wd_s/blob/master/Gulpfile.js
 */

'use strict';

const gulp = require('gulp');

// Style modules.
const sass = require('gulp-sass');
const sassLint = require('gulp-sass-lint');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const mqCSSpacker = require('css-mqpacker');
const sourcemaps = require('gulp-sourcemaps');
const cssnano = require('gulp-cssnano');
//const bourbon = require('bourbon').includePaths;
//const neat = require('bourbon-neat').includePaths;

// Script modules.
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');

// Image modules.
const imagemin = require('gulp-imagemin');

// Utility Modules
const del = require('del');
const beeper = require('beeper');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');

/** ---------- Utility Tasks ---------- */

/**
 * Handle errors and alert the user.
 */
function handleErrors() {
    const args = Array.prototype.slice.call(arguments);

    notify.onError({
        'title': 'Task Failed [<%= error.message %>',
        'message': 'See console.',
        'sound': 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
    }).apply(this, args);

    beeper(); // Beep

    // Prevent the 'watch' task from stopping.
    this.emit('end');
}

/** CSS Tasks */

/**
 * Minify and optimize CSS.
 *
 * https://www.npmjs.com/package/gulp-cssnano
 */
gulp.task('cssminify', ['postcss'], () =>
    gulp.src([
        'assets/css/**/*.css',
        '!assets/css/**/*.min*'
    ])
        .pipe(plumber({'errorHandler': handleErrors}))

        .pipe(cssnano({
            safe: true
        }))

        .pipe(rename({suffix: '.min'}))

        .pipe(gulp.dest('assets/css'))
);

gulp.task('postcss', ['clean:styles'], () =>
    gulp.src('assets/sass/**/*.scss')
        .pipe(plumber({'errorHandler': handleErrors}))

        .pipe(sourcemaps.init())

        .pipe(sass({
            //includePaths: [].concat( bourbon, neat ),
            errLogToConsole: true,
            outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
        }))

        .pipe(postcss([
            autoprefixer({
                browsers: [
                    'last 2 version',
                    '> 1%',
                    'IE 10'
                ],
                cascade: false
            }),
            mqCSSpacker({
                sort: true
            })
        ]))

        .pipe(sourcemaps.write())

        .pipe(gulp.dest('assets/css'))
);

/**
 * Delete style.css and style.min.css before we minify and optimize.
 */
gulp.task('clean:styles', () =>
    del(['assets/css/**/*.css'])
);

/**
 * Clean up SASS.
 */
gulp.task('sass:lint', ['css:minify'], function () {
    gulp.src([
        'assets/sass/**/*style.scss',
        '!assets/sass/**/_normalize.scss'
    ])
        .pipe(sassLint())

        .pipe(sassLint.format())

        .pipe(sassLint.failOnError());
});

/** ---------- Script tasks ---------- */
gulp.task('uglify', ['concat'], function () {
    return gulp.src([
        'assets/js/*',
        '!assets/js/*.min*'
    ])
        .pipe(plumber({'errorHandler': handleErrors}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(babel({
            'presets': [
                ['env', {
                    'targets': {
                        'browsers': ['last 2 versions']
                    }
                }]
            ]
        }))
        .pipe(uglify({
            mangle: false
        }))
        .pipe(gulp.dest('assets/js'));
});

gulp.task('concat', function () {
    return gulp.src('assets/js/concat/*.js')
        .pipe(sourcemaps.init())
        .pipe(concat('project.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('assets/js'));
});

/** ---------- Image Tasks ---------- */
gulp.task('imagemin', function () {
    return gulp.src('assets/images/*')
        .pipe(imagemin({
            'optimizationLevel': 5,
            'progressive': true,
            'interlaced': true
        }))
        .pipe(gulp.dest('assets/images'));
});

// Individual tasks.
gulp.task('styles', ['cssminify']);
gulp.task('scripts', ['uglify']);
gulp.task('images', ['imagemin']);
gulp.task('lint', ['sass:lint']);

// Builder.
gulp.task('build', ['styles', 'scripts', 'images']);

/**
 * Process tasks when changes happen (Watch).
 */
gulp.task('watch', function () {
    gulp.watch('assets/sass/**/*.scss', ['styles']);
    gulp.watch('assets/js/*.js', ['scripts']);
    gulp.watch('assets/images/*', ['images']);
});

// Default Task
gulp.task('default', ['build', 'watch']);