// Function to require all from a directory
function requireAll( r ) {
	r.keys().forEach( r );
}
require( './pages/apply-now-salesforce.js' );

$( document ).ready( function() {

	// Kick off foundation
	$( document ).foundation();

	// Require "self-initing" custom modules from  `assets/js/global` and all components
	requireAll( require.context( './global/', true, /\.js$/ ) );
	requireAll( require.context( './pages/', true, /\.js$/ ) );
	requireAll( require.context( './../../components/', true, /\.js$/ ) );
});

