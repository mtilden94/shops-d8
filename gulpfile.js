'use strict';

// CHANGE PATH FOR YOUR THEME
var theme_path = './web/themes/custom/' + 'shopsPlus/';
//==============================================

var gulp = require('gulp');
var watch = require('gulp-watch');
var vfs = require('vinyl-fs');
var sourcemaps = require('gulp-sourcemaps');
var sass = require('gulp-sass');
var filter = require('gulp-filter');
var autoprefixer = require('gulp-autoprefixer');
// var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
// var uglify = require('gulp-uglify');
//var rename = require('gulp-rename');
//var gulp_image = require('gulp-image');
//var newer = require('gulp-newer');
//var inject = require('gulp-inject');
var clean = require('gulp-clean');
var uglify = require('gulp-uglify');

var browserSync = require('browser-sync');


var path = {
    build: {
        css: theme_path + 'css/',
        js:  theme_path + 'js/build/',
        /*img: theme_path + 'images',*/
        //mg_clean: theme_path + 'images/**/*'
    },
    src: {
        scss: [
            theme_path + 'scss/default.scss',
            theme_path + 'scss/style.scss',
            theme_path + 'scss/print.scss'
        ],
        js: theme_path + 'js/source/scripts.js',
        /*img: [
            theme_path + 'src/images/*.png',
            theme_path + 'src/images/*.jpg',
            theme_path + 'src/images/*.jpeg'
        ],
        img_svg: theme_path + 'src/images/*.svg'*/
    },
    watch: {
        htmlTemplates: theme_path + 'templates/*.html.twig',
        scss: theme_path + 'scss/**/*.scss',
        js: theme_path + 'js/**/*.js',
       /* img: theme_path + 'src/images/**/  /*- *.*' -*/
    }
};

// ============== SERVER =================
gulp.task('server', function () {
    browserSync({
        port: 3000
        /*proxy: "abt.dev"*/
    });
});

/*
 //for conver sass to scss
 var converter = require('sass-convert');
 gulp.task('s2s', function () {
 vfs.src('./sass/!**!/!*.sass')
 .pipe(converter({
 from: 'sass',
 to: 'scss',
 }))
 .pipe(vfs.dest('./scss'));

 });
 */

// ============== SCSS =================

gulp.task('build:scss', function () {
    return gulp.src(path.src.scss, {
        base: theme_path + "scss"
    })
        .pipe(sourcemaps.init())
        .pipe(sass({
            //outputStyle: 'compressed',
            outputStyle: 'nested',
            precision: 10,
            includePaths: require('node-bourbon').includePaths,
            onError: function (err) {
                notify().write(err);
            }
        }))
        .pipe(sourcemaps.write({includeContent: false}))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(autoprefixer({
            browsers: ['last 15 versions', '> 1%'],
            cascade: false
        }))
        .pipe(sourcemaps.write('./_maps'))
        .pipe(gulp.dest(path.build.css))
        .pipe(filter('**/*.css'))
        .pipe(browserSync.reload({stream: true}));

});

// ============== JS =================
gulp.task('build:js', function() {
    return gulp.src(path.src.js)
        .pipe(uglify())
        .pipe(gulp.dest(path.build.js))
        .pipe(browserSync.reload({stream: true}));
});



// ============== IMAGES =================
/*
 gulp.task('images_changed', function () {
 gulp.src(path.src.img)
 .pipe(newer(path.build.img))
 .pipe(gulp_image())
 .pipe(gulp.dest(path.build.img))
 .pipe(reload({stream: true}));
 });*/
/*
gulp.task('build:images', function () {
    //cleang
    gulp.src(path.build.img_clean)
        .pipe(clean());

    //minification jpg, png
 /*   gulp.src(path.src.img)
        .pipe(gulp_image({
            pngquant: true,
            optipng: false,
            zopflipng: true,
            jpegRecompress: false,
            jpegoptim: true,
            mozjpeg: true,
            gifsicle: true,
            svgo: true,
            concurrent: 10
        }))
         .pipe(gulp.dest(path.build.img))
        .pipe(browserSync.reload({stream: true}));
 */

    //copy svg
/*   gulp.src(path.src.img_svg)
        .pipe(gulp.dest(path.build.img));

});
*/

// ============== BUILD =================
gulp.task('build', function () {
    gulp.start('build:scss');
    gulp.start('build:js');
});


// ============== WATCH =================
gulp.task('watch', function () {

    gulp.watch([path.watch.scss], function (event, cb) {
        gulp.start('build:scss');
    });
    gulp.watch([path.watch.js], function (event, cb) {
        gulp.start('build:js');
    });
    gulp.watch([path.watch.htmlTemplates], function (event, cb) {
        browserSync.reload();
    });

    // watch([path.watch.img], function () {
    //    console.log('images change');
    //   gulp.src(path.watch.img)
    //      .pipe(newer(path.build.img))
    //      .pipe(gulp.dest(path.build.img))
    //      .pipe(browserSync.reload({stream: true}));
    //});

});


// ============== DEFAULT =================
gulp.task('default', ['build', 'server', 'watch']);
