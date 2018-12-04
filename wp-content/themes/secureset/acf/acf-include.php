<?php
add_filter( 'acf/settings/path', 'my_acf_settings_path' );

function my_acf_settings_path( $path ) {

	// update path
	$path = get_stylesheet_directory() . '/acf/advanced-custom-fields-pro/';

	// return
	return $path;
}


// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

	// update path
	$dir = get_stylesheet_directory_uri() . '/acf/advanced-custom-fields-pro/';

	// return
	return $dir;
}


// 3. Hide ACF field group menu item (when WP_DEBUG === false)
if ( WP_DEBUG !== true ) {
	add_filter('acf/settings/show_admin', '__return_false');
}


// 4. Include ACF
include_once( get_stylesheet_directory() . '/acf/advanced-custom-fields-pro/acf.php' );

// 5. Include ACF plugins
// include_once( get_stylesheet_directory() . '/acf/acf-flexible-content/acf-flexible-content.php' );

?>
