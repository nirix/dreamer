var gulp       = require('gulp')
    watch      = require('gulp-watch'),
    sass       = require('gulp-sass'),
    coffee     = require('gulp-coffee'),
    concat     = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps');

var sassPaths = [
    'node_modules/bootstrap-sass/assets/stylesheets'
];

var sassWatchPaths = [
    'scss/*.scss',
    'scss/*/*.scss'
];

var beSassy = function() {
    console.log('Being Sassy');

    gulp.src([
        './scss/dreamer.scss',
        './scss/admin.scss'
    ])
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed', includePaths: sassPaths}).on('error', sass.logError))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('../assets/css'));
}

var makeCoffee = function() {
    console.log('Making coffee');

    gulp.src('./coffee/*.coffee')
        .pipe(coffee())
        .pipe(gulp.dest('../assets/js'));
}

gulp.task('compile', function(){
    beSassy();
    makeCoffee();
    gulp.start('assets');
});

// Watch for changes
gulp.task('watch', function(){
    watch('scss/**/*.scss', beSassy);
    watch('./coffee/**/*.coffee', makeCoffee);

    gulp.start('assets');
});

// Compile Sass
gulp.task('sass', beSassy);

// Compile CoffeeScript
gulp.task('coffee', makeCoffee);

// JavaScripts
gulp.task('assets', function() {
    gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js'
    ])
    .pipe(concat('js.js'))
    .pipe(gulp.dest('../assets/js'));

    gulp.src([
        'node_modules/font-awesome/fonts/*'
    ])
    .pipe(gulp.dest('../assets/fonts'));
});
