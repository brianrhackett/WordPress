var path = require( 'path' ),
	webpack = require( 'webpack' ),
	Uglify = require( 'uglifyjs-webpack-plugin' );

const ENV = process.env.NODE_ENV;
const IS_PROD = process.env.NODE_ENV === 'dist';

var config = {
	entry: {
		// These arrays will take module names as well ( 'slick-carousel', 'fancybox', etc. )
		// 'vendor' and 'app' refer to the custom modules in `/assets/js/`
		vendor: [ 'vendor' ],
		site: [ 'site' ]
	},
	output: {
		path: path.join( __dirname, '/../assets/' + ENV ),
		publicPath: '/',
		filename: ( IS_PROD ) ? '[name].bundle.min.js' : '[name].bundle.js'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				enforce: 'pre',
				include: [
					path.join( __dirname, '/../assets/js' )
				],
				exclude: [
					/node_modules/,
					path.join( __dirname, '/../assets/js/vendor' ),
					path.join( __dirname, '/../assets/js/lib' )
				],
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: ['es2015']
						},
					},
					{
						loader: 'jshint-loader',
						options: {
							emitErrors: false,
						},
					},
					{
						loader: 'eslint-loader',
						options: {
							failOnWarning: false,
							failOnError: true,
							configFile: path.join( __dirname, '/eslintrc.json' ),
							fix: true // Set this to false if the auto fix options is causing problems
						}
					}
				]
			}
		]
	},
	externals: {
		'jquery': 'jQuery'
	},
	plugins: [
		new webpack.HashedModuleIdsPlugin(),
		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			filename: ( IS_PROD ) ? 'vendor.bundle.min.js' : 'vendor.bundle.js'
		}),
		// THIS IS FOR MINIFIED/DIST ONLY
		new Uglify({
			parallel: 8,
			test: /\.js($|\?)/i,
			sourceMap: ( ! IS_PROD ),
			uglifyOptions: {
				compress: IS_PROD
			}
		}),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			debounce: 'lodash.debounce'
		})
	],
	resolve: {
		modules: [
			path.join( __dirname, '/../node_modules' ),
			path.join( __dirname, '/../assets/js' ),
			path.join( __dirname, '/../assets/lib' ),
			path.join( __dirname, '/../components' )
		],
		extensions: [ '.js' ],
		unsafeCache: true
	},
	stats: {
		assets: true,
		cached: false,
		cachedAssets: false,
		children: false,
		colors: true,
		errors: true,
		errorDetails: false,
		hash: false,
		modules: false,
		warnings: true,
		version: false
	},
	target: 'web',
	watchOptions: {
		ignored: [ path.join( __dirname, '/../node_modules/' ), path.join( __dirname, '/../assets/lib/' ) ]
	},
	devtool: ( ! IS_PROD ) ? 'source-map' : 'hidden-source-map',
};
module.exports = config;
