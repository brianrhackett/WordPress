<?php

add_action( 'wp_ajax_nopriv_get_upcoming_programs', 'get_upcoming_programs' );
add_action( 'wp_ajax_get_upcoming_programs', 'get_upcoming_programs' );

function get_upcoming_programs() {

	if ( !empty( $_GET['location_id'] ) && is_numeric( $_GET['location_id'] ) ) {
		$location_id = filter_input( INPUT_GET, 'location_id', FILTER_VALIDATE_INT );
	} else {
		$locations = get_posts( array( 'post_type' => 'locations' ) );
		$location_id = $locations[0]->ID;
	}
	// Get next 6 programs in location that have a start date later than "today"
	$programs = get_posts( array(
		'posts_per_page'	=> 6,
		'post_type'			=> 'programs',
		'meta_query'		=> array(
			'relation' => 'AND',
			array(
				'key'		=> 'start_date',
				'value'		=> current_time( 'Ymd' ),
				'compare'	=> '>=',
			),
			array(
				'key'		=> 'location',
				'value'		=> $location_id,
				'compare'	=> '=',
			),
		),
		'meta_key'		=> 'start_date',
		'orderby' 		=> 'meta_value',
		'order' 		=> 'ASC'
	) );

	$upcoming_programs = array();

	foreach ( $programs as $program ) {
		$p_fields = get_fields( $program->ID );
		$p_type_fields = get_fields( 'program_types_' . $p_fields['program_type'] );

		$startDate = get_field( 'start_date', $program->ID, false);
		$startDate = new DateTime( $startDate );
		$endDate = get_field( 'end_date', $program->ID, false);
		$endDate = new DateTime( $endDate );
		$card_dates = '';
		if ( !empty( $p_fields['start_date'] ) ) {
			$card_dates = ( !empty( $p_fields['end_date'] ) ) ? $startDate->format( 'M j' ) . '-' . $endDate->format( 'M j' ) : $startDate->format( 'M j' );
		}

		$upcoming_programs[] = array(
			'card_icon_url'	 	=> ( !empty( $p_type_fields['program_icon'] ) ) ? wp_get_attachment_image_url( $p_type_fields['program_icon']['id'], 'medium' ) : '',
			'card_icon_color' 	=> ( !empty( $p_type_fields['program_color'] ) ) ? $p_type_fields['program_color'] : '#0270cd',
			'card_title'		=> ( !empty( $p_type_fields['program_type'] ) ) ? esc_attr( $p_type_fields['program_type'] ) : '',
			'card_location' 	=> ( !empty( $p_fields['location'] ) ) ? esc_attr( $p_fields['location']->post_title ) : '',
			'card_dates'		=> esc_attr( $card_dates ),
			'card_link'			=> esc_url( get_post_permalink( $program->ID ) )
		);
	}

	echo json_encode( $upcoming_programs );
	die();
}
