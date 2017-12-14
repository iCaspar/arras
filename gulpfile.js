'use strict'

var gulp = require('gulp'),

  // Sass and CSS modules.
  bourbon = require('bourbon').includePaths,
  neat = require('bourbon-neat').includePaths,
  sass = require('gulp-sass'),
  sassLint = require('gulp-sass-lint'),
  postcss = require('gulp-postcss'),
  autoprefixer = require('autoprefixer'),
  mqCSSpacker = require('css-mqpacker'),
  sourcemaps = require('gulp-sourcemaps'),
  cssnano = require('gulp-cssnano'),

  // Script modules.
  uglify = require('gulp-uglify'),
  concat = require('gulp-concat'),

  // Image modules.
  imagemin = require('gulp-imagemin'),

  // Utilities
  rename = require('gulp-rename'),
//    plumber = require('gulp-plumber'),
  notify = require('gulp-notify')

/** Utility Tasks */

/**
 * Error handling.
 *
 * @function
 */
// function handleErrors() {
//     var args = Array.prototype.slice.call(arguments);
//
//     notify.onError({
//         title: 'Task Failed [<%= error.message %>',
//         message: 'See Console',
//         sound: 'Sosumi'
//     }).apply(this.args);
//
//     gutil.beep();
//
//     // Prevent watch from stopping.
//     this.emit('end');
// }

/** CSS Tasks */

gulp.task('sass:postcss', function () {

  return gulp.src('assets/src/sass/**/*.scss')

    .pipe(sourcemaps.init())

    .pipe(sass({
      //includePaths: [].concat( bourbon, neat ),
      errLogToConsole: true,
      outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
    }))

    .pipe(postcss([
      autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
      }),
      mqCSSpacker({
        sort: true
      })
    ]))

    .pipe(sourcemaps.write())

    .pipe(gulp.dest('assets/src/css'))
})

gulp.task('sass:lint', ['css:minify'], function () {
  gulp.src([
    'assets/src/sass/**/*.scss',
    '!assets/src/sass/base/_normalize.scss'
  ])
    .pipe(sassLint())
    .pipe(sassLint.format())
    .pipe(sassLint.failOnError())
})

gulp.task('css:minify', ['sass:postcss'], function () {
  return gulp.src('assets/src/css/**/*.css')
    .pipe(cssnano({
      safe: true
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('assets/dist/css'))
})

/** Script tasks */
gulp.task('uglify', ['concat'], function () {
  return gulp.src('assets/src/js/*')
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(uglify({
      mangle: false
    }))
    .pipe(gulp.dest('assets/dist/js'))
})

gulp.task('concat', function () {
  return gulp.src('assets/src/js/concat/*.js')
    .pipe(sourcemaps.init())
    .pipe(concat('project.js'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/dist/js'))
})

/** Image Tasks */
gulp.task('imagemin', function () {
  return gulp.src('assets/src/images/*')
    .pipe(imagemin({
      'optimizationLevel': 5,
      'progressive': true,
      'interlaced': true
    }))
    .pipe(gulp.dest('assets/dist/images'))
})

// Individual tasks.
gulp.task('styles', ['sass:lint'])
gulp.task('scripts', ['uglify'])
gulp.task('images', ['imagemin'])

// Builder.
gulp.task('build', ['styles', 'scripts', 'images'])

// Watcher.
gulp.task('watch', ['build'], function () {
  gulp.watch('assets/src/sass/**/*.scss', ['styles'])
})