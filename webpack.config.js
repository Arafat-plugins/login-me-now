const path = require( 'path' );
const CopyWebpackPlugin = require('copy-webpack-plugin');
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const { log } = require( 'console' );
const LOGIN_ME_NOW_NAMESPACE = '@login-me-now/';

const devHost = 'login-me-now.test';

/**
 * Given a string, returns a new string with dash separators converted to
 * camelCase equivalent. This is not as aggressive as `_.camelCase` in
 * converting to uppercase, where Lodash will also capitalize letters
 * following numbers.
 *
 * @param {string} string Input dash-delimited string.
 * @return {string} Camel-cased string.
 */
function camelCaseDash( string ) {
	return string.replace( /-([a-z])/g, ( _, letter ) => letter.toUpperCase() );
}

module.exports = {
	...defaultConfig,
	entry: {
		'dashboard-app': './src/dashboard/DashboardApp.js',
	},
	resolve: {
		alias: {
			'@DashboardApp': path.resolve( __dirname, 'src/dashboard/dashboard-app/' ),
			'@Admin': path.resolve( __dirname, 'src/dashboard/' ),
			'@Utils': path.resolve( __dirname, 'src/dashboard/utils/' ),
			'@Skeleton': path.resolve( __dirname, 'src/dashboard/common/skeleton/' ),
			'@Common': path.resolve( __dirname, 'src/dashboard/common/' ),
			'@helpers': path.resolve( __dirname, 'src/helpers' ),
		},
	},
	output: {
		path: path.resolve( __dirname, './assets' ),
		filename: '[name].js',
		clean: false,
	},
	plugins: [
		...defaultConfig.plugins.filter(
			( plugin ) =>
				plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
		),
		new DependencyExtractionWebpackPlugin( {
			requestToExternal( request ) {
				if ( request.startsWith( LOGIN_ME_NOW_NAMESPACE ) ) {
					return [
						'login-me-now',
						camelCaseDash(
							request.substring( LOGIN_ME_NOW_NAMESPACE.length )
						),
					];
				}
			},
			requestToHandle( request ) {
				if ( request.startsWith( LOGIN_ME_NOW_NAMESPACE ) ) {
					return `login-me-now/${ camelCaseDash(
						request.substring( LOGIN_ME_NOW_NAMESPACE.length )
					) }`;
				}
			},
		} ),
		new CopyWebpackPlugin({
			patterns: [
				{ from: 'src/images', to: 'images' },
			],
		}),
	],
	devServer: {
		devMiddleware: {
			writeToDisk: true,
		},
		allowedHosts: 'auto',
		port: 8887,
		host: devHost,
		proxy: {
			'./build': {
				pathRewrite: {
					'^./build': '',
				},
			},
		},
		headers: { 'Access-Control-Allow-Origin': '*' },
	},
};
