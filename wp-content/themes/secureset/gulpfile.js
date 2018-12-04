process.env.DISABLE_NOTIFIER = true;
/**
 * Define extensions, paths
 */
var concat = require( 'gulp-concat' ),
	cssnano = require( 'gulp-cssnano' ),
	glob = require( 'glob' ),
	gulp = require( 'gulp' ),
	gutil = require( 'gulp-util' ),
	imagemin = require( 'gulp-imagemin' ),
	livereload = require( 'gulp-livereload' ),
	notify = require( 'gulp-notify' ),
	autoprefixer = require( 'gulp-autoprefixer' ),
	rename = require( 'gulp-rename' ),
	replace = require( 'gulp-replace' ),
	sass = require( 'gulp-sass' ),
	sassGlob = require( 'gulp-sass-glob' ),
	sort = require( 'gulp-sort' ),
	sourcemaps = require( 'gulp-sourcemaps' ),
	stylelint = require( 'gulp-stylelint' ),
	stylelintFormatter = require( 'stylelint-formatter-pretty' ),
	path = require( 'path' ),
	webpack = require( 'webpack-stream' ),
	exec = require( 'child_process' ).exec,
	spawn = require( 'child_process' ).spawn;

var	paths = {
	WATCH_SCSS: [
		'assets/scss/*.scss',
		'assets/scss/**/*.scss',
		'components/**/scss/*.scss'
	],
	WATCH_PHP: [
		'components/**/acf*.php',
		'inc/acf/**/*.php'
	],
	WATCH_JS: [
		'assets/js/**/*.js',
		'components/**/js/*.js'
	],
	SCSS_ENTRY: 'assets/scss/styles.scss',
	IMG: 'assets/img/',
	BUILD: 'assets/build',
	DIST: 'assets/dist'
};

var webpackHash = '';


/**
 * Helper Tasks
 */
function setWebpackEnv( env ) {
	return process.env.NODE_ENV = env;
}


/**
 * Development Tasks
 */

// Running Webpack
function webpackJs( watch, done ) {
	var shouldWatch = ( watch === 'true' ) ? true : false,
		webpackConfig = require( './devconfig/webpack.config.js' );

	webpackConfig.watch = shouldWatch;
	
	console.log(shouldWatch);
	return gulp.src( './assets/js/site.js' )
	    .pipe( webpack( webpackConfig, null, function ( err, stats ) {
				if ( err ) {
					console.log( 'webpackJs Error: ', err );
				}
				if ( stats ) {
					console.log( stats.toString( webpackConfig.stats ) );

					if ( ( webpackHash !== stats.hash ) && shouldWatch ) {
						livereload.reload( 'Browser' );
					}
					webpackHash = stats.hash;
				}
				if ( shouldWatch ) {
					notify( 'JS compiled with webpack' );
				}
			} ) )
	    .pipe( gulp.dest( ( process.env.NODE_ENV === 'dist' ) ? paths.DIST : paths.BUILD ) );
}


// Lint Sass files
function lintSass() {
	return gulp.src( paths.WATCH_SCSS )
		.pipe( stylelint( {
				configFile: './devconfig/stylelint.config.js',
				ignoreFiles: [ 'node_modules/**/*.scss', 'node_modules/**/*.css' ],
				failAfterError: false,
				fix: true, // This options doesn't seem to be working
				reporters: [ {
					formatter: stylelintFormatter,
					console: true
				} ]
			} ) );
}


// Compile Sass files
function compileSass() {
	return gulp.src( paths.SCSS_ENTRY )
		.pipe( sourcemaps.init() )
		.pipe( sassGlob() )
		.pipe( sass({ outputStyle: 'compact' })
			.on( 'error', notify.onError( {
				message: 'Sass failed. Check console for errors'
			} ) )
			.on( 'error', sass.logError ))
		.pipe( autoprefixer({ browsers: '> 1%, ie 10, not ie <=8, iOS >= 7' }) )
		.pipe( sourcemaps.write() )
		.pipe( gulp.dest( paths.BUILD ) )
		.pipe( livereload() )
		.pipe( notify( 'Sass successfully compiled' ) );
}

// Concatinate Component ACF Fields
function compileComponentACF() {
	return gulp.src( paths.WATCH_PHP )
		.pipe( sort() )
		.pipe( replace( /^\s*<\?php|\?>\s*$/g, '' ) ) // Strip Opening/Ending PHP Tags
		.pipe( concat( 'compiled-acf.php' ) )
		.pipe( replace( /^/, '<?php' ) ) // Insert single PHP Tag
		.pipe( gulp.dest( 'inc' ) )
		.pipe( notify( 'Components successfully compiled' ) );
}

/**
 * Production Tasks
 */

// Concatenate, minify, move CSS/SASS files
function buildMinCss() {
	return gulp.src( [ paths.BUILD + '/*.css', paths.BUILD + '/**/*.css' ] )
		.pipe( rename({ suffix: '.min' }) )
		.pipe( cssnano() )
		.pipe( gulp.dest( paths.DIST ) );
}

// Optimize images
function compressImgs() {
	return gulp.src( [ paths.IMG + '*.*', paths.IMG + '**/*.*' ] )
		.pipe( imagemin() )
		.pipe( gulp.dest( paths.IMG ) );
}


/**
 * Build Task Functions
 */
function watch() {
	setWebpackEnv( 'build' );
	webpackJs( 'true' );
	gulp.watch( paths.WATCH_SCSS, gulp.series( gulp.parallel( lintSass, compileSass ) ) );
	gulp.watch( paths.WATCH_PHP, compileComponentACF );
	livereload.listen();
}

function buildTasks( done ) {
	setWebpackEnv( 'build' );
	gulp.series(
		gulp.parallel(
			compileSass,
			compileComponentACF,
			webpackJs
		)
	)();
	done();
}

function stageTasks( done ) {
	setWebpackEnv( 'dist' );
	gulp.parallel(
		buildMinCss,
		webpackJs,
		compileComponentACF
	)();
	done();
}

function prodTasks( done ) {
	setWebpackEnv( 'dist' );
	gulp.parallel(
		buildMinCss,
		webpackJs,
		compressImgs,
		compileComponentACF
	)();
	done();
}

// Default Task
gulp.task( 'default', buildTasks );

// Watch Task
gulp.task( 'watch', watch );

// Stage - minified css and js, no images
gulp.task( 'stage', stageTasks );

// Prod - minified css and js and compressed images
gulp.task( 'prod', prodTasks );
