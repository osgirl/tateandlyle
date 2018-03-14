  var gulp = require('gulp');
  var eslint = require('gulp-eslint');
  var gulpStylelint = require('gulp-stylelint');
  var sass = require('gulp-sass');
  var sourcemaps = require('gulp-sourcemaps');
  var autoprefixer = require('gulp-autoprefixer');
  var babel = require('gulp-babel');
  var uglify = require('gulp-uglify');
  var imagemin = require('gulp-imagemin');
  var consoleReporter = require('gulp-stylelint-console-reporter').default;
  var browserSync = require("browser-sync").create();
  var reload = browserSync.reload;

  var config = require('./config.json');

gulp.task('eslint', function() {
  return gulp.src([config.js.input])
  .pipe(eslint())
  .pipe(eslint.format())
  .pipe(eslint.failAfterError());
});

gulp.task('gulpStylelint', function lintCssTask() {
  return gulp.src([config.sass.input])
  .pipe(gulpStylelint({
    reporters: [{formatter: 'string', console: true}]
  }));
});

gulp.task('lint', function() {
  gulp.start(['eslint', 'gulpStylelint']);
});

gulp.task('sass:dev', function() {
  return gulp.src([config.sass.input])
  .pipe(sourcemaps.init())
  .pipe(sass(config.sass.options.dev).on('error', sass.logError))
  .pipe(sourcemaps.write())
  .pipe(autoprefixer(config.autoprefixer))
  .pipe(gulp.dest(config.sass.output))
  .pipe(reload({stream: true}));
});

gulp.task('sass:prod', function() {
  return gulp.src([config.sass.input])
  .pipe(sass(config.sass.options.prod).on('error', sass.logError))
  .pipe(autoprefixer())
  .pipe(gulp.dest(config.sass.output));
});

gulp.task('js:dev', function() {
  return gulp.src([config.js.input])
  .pipe(sourcemaps.init())
  .pipe(gulp.dest(config.js.output))
  .pipe(reload({stream: true}));
});

gulp.task('js:prod', function() {
  return gulp.src([config.js.input])
  // .pipe(uglify())
  .pipe(gulp.dest(config.js.output));
});

gulp.task('images', function() {
  return gulp.src([config.img.input])
  .pipe(imagemin(config.img.options));
});

gulp.task('prod', function() {
  gulp.start(['sass:prod', 'js:prod', 'lint', 'images']);
});

gulp.task('watch', function() {
  if (process.env.BSURL) {
    browserSync.init({
        proxy: config.browserSync.url
    });
  }
  gulp.watch(config.sass.input, ['sass:dev', 'gulpStylelint']).on('change', reload);
  gulp.watch(config.js.input, ['js:dev', 'eslint']).on('change', reload);
});
