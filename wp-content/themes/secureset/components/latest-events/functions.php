<?php

add_action( 'wp_ajax_nopriv_get_upcoming_events', 'get_upcoming_events' );
add_action( 'wp_ajax_get_upcoming_events', 'get_upcoming_events' );

function get_upcoming_events() {

	if ( !empty( $_GET['location_id'] ) && is_numeric( $_GET['location_id'] ) ) {
		$location_id = filter_input( INPUT_GET, 'location_id', FILTER_VALIDATE_INT );
	} else {
		$locations = get_posts( array( 'post_type' => 'locations' ) );
		$location_id = $locations[0]->ID;
	}

	if ( !empty( $_GET['event_categories'] ) ) {
		$event_categories = explode( ',', filter_input( INPUT_GET, 'event_categories', FILTER_SANITIZE_STRING ) );
	}

	// Get next 6 events in location that have a start date later than "today"
	$args = array(
		'posts_per_page'	=> 6,
		'post_type'			=> 'tribe_events',
		'meta_query'		=> array(
			'relation' => 'AND',
			array(
				'key'		=> '_EventStartDateUTC',
				'value'		=> current_time( 'Y-m-d H:i:s', true ),
				'compare'	=> '>=',
			),
			array(
				'key'		=> 'location',
				'value'		=> $location_id,
				'compare'	=> 'LIKE',
			),
		),
		'meta_key'		=> '_EventStartDateUTC',
		'orderby' 		=> 'meta_value',
		'order' 		=> 'ASC'
	);

	if ( $event_categories ) {
		$args['tax_query'] = array(
			'relation' 	=> 'AND',
			array(
				'taxonomy' 	=> 'tribe_events_cat',
				'field' 	=> 'term_id',
				'terms' 	=> $event_categories,
				'operator' => 'IN',
			)
		);
	}

	$events = get_posts( $args );

	$upcoming_events = array();

	foreach ( $events as $event ) {
		$upcoming_events[] = array(
			'card_title' 	=> $event->post_title,
			'card_date'		=> nl2br( tribe_get_start_date( $event, false, "F d, Y\ng:i a"  ) ),
			'card_link'		=> tribe_get_event_link( $event )
		);
	}
	echo json_encode( $upcoming_events );
	die();
}
