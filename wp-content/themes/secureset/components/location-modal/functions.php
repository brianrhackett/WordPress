<?php

function add_location_modal_scripts() {
	$google_maps_api_key = get_field( 'google_maps_api_key', 'option' );
	if ( $google_maps_api_key ) {
		wp_register_script( 'location_modal_google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key );
		wp_enqueue_script( 'location_modal_google-maps' );
	}
}
add_action( 'wp_enqueue_scripts', 'add_location_modal_scripts' );
