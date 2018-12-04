<?php

function custom_og_meta() {
	$yoast_og_image = get_post_meta( get_the_id(), '_yoast_wpseo_opengraph-image' );
	if ( ! $yoast_og_image ) {
		add_action( 'wpseo_add_opengraph_images', 'add_og_image' );
	}
}

function add_og_image( $og ) {
	$page_builder = get_field( 'main_page_builder' );
	$hero_image_id = false;
	if( is_array( $page_builder ) ) {
		foreach ( $page_builder as $key => $component ) {
			if ( isset( $page_builder[ $key ]['hero_type'] ) ) {
				$hero_image_id = $page_builder[ $key ]['background_image'];
				break;
			}
		}
	}

	if ( $hero_image_id ) {
		$hero_image_url = wp_get_attachment_image_src( $hero_image_id, 'large' );
		$og->add_image( $hero_image_url[0] );
	}
}

add_action( 'wpseo_opengraph', 'custom_og_meta' );
?>
