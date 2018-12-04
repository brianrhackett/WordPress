<?php
/**
 * Update icon file css path.
 *
 * @return string
 */
function override_acf_icomoon_filepath() {
	return get_stylesheet_directory() . '/assets/fonts/icomoon/location-icon-styles.css';
}
add_filter( 'icomoon_filepath', 'override_acf_icomoon_filepath' );

/**
 * Update icon file css url
 *
 * @return string
 */
function override_acf_icomoon_fileurl() {
	return get_stylesheet_directory_uri() . '/assets/fonts/icomoon/location-icon-styles.css';
}
add_filter( 'icomoon_fileurl', 'override_acf_icomoon_fileurl' );

/**
 * Update icon files.
 *
 * @return array
 */
function override_acf_icomoon_fonts() {
	return array(
		'woff2' => get_stylesheet_directory_uri() . '/assets/fonts/icomoon/icomoon.woff?ousyjt',
		'ttf'  => get_stylesheet_directory_uri() . '/assets/fonts/icomoon/icomoon.ttf?ousyjt',
		'woff' => get_stylesheet_directory_uri() . '/assets/fonts/icomoon/icomoon.woff?ousyjt',
		'svg'  => get_stylesheet_directory_uri() . '/assets/fonts/icomoon/icomoon.svg?ousyjt#icomoon'
	);
}
add_filter( 'icomoon_fonts', 'override_acf_icomoon_fonts' );

/**
 * font family for theme
 */
function override_acf_icomoon_font_family() {
	return 'icomoon';
}
add_filter( 'icomoon_font_family_name', 'override_acf_icomoon_font_family' );
