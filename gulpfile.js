/**
 * A simple Gulp 4 Starter Kit for modern web development.
 *
 * @package @jr-cologne/create-gulp-starter-kit
 * @author JR Cologne <kontakt@jr-cologne.de>
 * @copyright 2018 JR Cologne
 * @license https://github.com/jr-cologne/gulp-starter-kit/blob/master/LICENSE MIT
 * @version v0.4.0-alpha
 * @link https://github.com/jr-cologne/gulp-starter-kit GitHub Repository
 * @link https://www.npmjs.com/package/@jr-cologne/create-gulp-starter-kit npm package site
 *
 * ________________________________________________________________________________
 *
 * gulpfile.js
 *
 * The gulp configuration file.
 *
 */

const gulp                      = require('gulp'),
      del                       = require('del'),
      sourcemaps                = require('gulp-sourcemaps'),
      plumber                   = require('gulp-plumber'),
      scss                      = require('gulp-sass'),
      autoprefixer              = require('gulp-autoprefixer'),
      cssnano                   = require('gulp-cssnano'),
      babel                     = require('gulp-babel'),
      webpack                   = require('webpack-stream'),
      uglify                    = require('gulp-uglify'),
      concat                    = require('gulp-concat'),
      imagemin                  = require('gulp-imagemin'),
      connect                   = require('gulp-connect-php'),
      browserSync               = require('browser-sync').create(),

      src_folder                = './src/',
      src_assets_folder         = src_folder + 'assets/',
      dist_folder               = './dist/',
      dist_assets_folder        = dist_folder + 'assets/',
      node_modules_folder       = './node_modules/',
      dist_node_modules_folder  = dist_folder + 'node_modules/',

      node_dependencies         = Object.keys(require('./package.json').dependencies || {});

gulp.task('clear', () => del([ dist_folder ]));

gulp.task('html', () => {
  return gulp.src([ src_folder + '**/*.html' ], { base: src_folder })
    .pipe(gulp.dest(dist_folder))
    .pipe(browserSync.stream());
});

gulp.task('php', () => {
  return gulp.src([src_folder + '**/*.php'], { base: src_folder })
    .pipe(gulp.dest(dist_folder))
    .pipe(browserSync.stream());
});

gulp.task('scss', () => {
  return gulp.src([ src_assets_folder + 'scss/**/*.scss' ])
    .pipe(sourcemaps.init())
      .pipe(plumber())
      .pipe(scss())
      .pipe(autoprefixer({
        browsers: [ 'last 3 versions', '> 0.5%' ]
      }))
      .pipe(cssnano())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(dist_assets_folder + 'css'))
    .pipe(browserSync.stream());
});

gulp.task('js', () => {
  return gulp.src([ src_assets_folder + 'js/**/*.js' ])
    .pipe(plumber())
    .pipe(webpack({
      mode: 'production'
    }))
    .pipe(sourcemaps.init())
      .pipe(babel({
        presets: [ '@babel/env' ]
      }))
      .pipe(concat('all.js'))
      .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(dist_assets_folder + 'js'))
    .pipe(browserSync.stream());
});

gulp.task('images', () => {
  return gulp.src([ src_assets_folder + 'images/**/*.+(png|jpg|jpeg|gif|svg|ico)' ])
    .pipe(plumber())
    .pipe(imagemin())
    .pipe(gulp.dest(dist_assets_folder + 'images'))
    .pipe(browserSync.stream());
});

gulp.task('vendor', () => {
  if (node_dependencies.length === 0) {
    return new Promise((resolve) => {
      console.log("No dependencies specified");
      resolve();
    });
  }

  return gulp.src(node_dependencies.map(dependency => node_modules_folder + dependency + '/**/*.*'), { base: node_modules_folder })
    .pipe(gulp.dest(dist_node_modules_folder))
    .pipe(browserSync.stream());
});

gulp.task('build', gulp.series('clear', 'php', 'scss', 'js', 'images', 'vendor'));

gulp.task('dev', gulp.series('php', 'scss', 'js'));

gulp.task('serve', () => {
  connect.server({}, function () {
    return browserSync.init({
      proxy: 'localhost/cinemacityapp/dist'
    });
  });
});

gulp.task('watch', () => {
  const watchImages = [
    src_assets_folder + 'images/**/*.+(png|jpg|jpeg|gif|svg|ico)'
  ];

  const watchVendor = [];

  node_dependencies.forEach(dependency => {
    watchVendor.push(node_modules_folder + dependency + '/**/*.*');
  });

  const watch = [
    src_folder + '**/*.php',
    src_assets_folder + 'scss/**/*.scss',
    src_assets_folder + 'js/**/*.js'
  ];

  gulp.watch(watch, gulp.series('dev')).on('change', browserSync.reload);
  gulp.watch(watchImages, gulp.series('images')).on('change', browserSync.reload);
  gulp.watch(watchVendor, gulp.series('vendor')).on('change', browserSync.reload);
});

gulp.task('default', gulp.series('build', gulp.parallel('serve', 'watch')));


