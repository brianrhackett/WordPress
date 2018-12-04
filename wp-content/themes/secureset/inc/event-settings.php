<?php
if ( class_exists( 'Tribe__Events__Main' ) ) {
	// Dequeue filter bar styles and google maps script if on the events page
	function dequeue_filter_bar_styles() {
		wp_dequeue_style( 'tribe-filterbar-styles' );
		if ( tribe_is_event() ) {
			wp_dequeue_script( 'location_modal_google-maps' );
			wp_dequeue_style( 'event-tickets-rsvp' );
		}

	}
	add_action( 'wp_enqueue_scripts', 'dequeue_filter_bar_styles', 100 );

	// This will show the event price even if even tickets addon is installed
	add_filter( 'tribe_events_admin_show_cost_field', '__return_true', 100 );

	/**
	 * This function will add a first and last name
	 */
	function add_first_last_name() {
		$_POST['attendee']['full_name'] = $_POST['attendee']['first_name'] . ' ' . $_POST['attendee']['last_name'];
	}
	add_action( 'tribe_tickets_rsvp_before_order_processing', 'add_first_last_name' );

	/**
	 * Show prev and next buttons always
	 */
	class ContinualMonthViewPagination {
		public function __construct() {
			add_filter( 'tribe_events_the_next_month_link', array( $this, 'next_month' ) );
			add_filter( 'tribe_events_the_previous_month_link', array( $this, 'previous_month' ) );
		}
		public function previous_month() {
			$date = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );
			return '<a data-month="' . $date . '" href="/events/" class="events-month__prev-link btn btn--light" rel="nofollow">Previous</a>';
		}
		public function next_month() {
			$date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );
			return '<a data-month="' . $date . '" href="/events/" class="events-month__next-link btn btn--light" rel="nofollow">Next</a>';
		}
	}
	new ContinualMonthViewPagination;


	add_filter( 'tribe_events_add_no_index_meta', 'kill_tribe_noindex' );

	function kill_tribe_noindex( $add_noindex ) {
		$event_display = get_query_var( 'eventDisplay' );
		if ( $event_display === 'month' ) {
			$add_noindex = false;
		}
		return $add_noindex;
	}

	function custom_title( $title ) {
		$unique_title = $title;
		if (
			tribe_is_month() ||
			tribe_is_week() ||
			tribe_is_day()
		) {
			$custom_title = get_field( 'meta_title', 'option' );
			if ( $custom_title ) {
				$unique_title = $custom_title;
			}
		}
		return $unique_title;
	}
	add_filter( 'wpseo_title', 'custom_title' );

	function event_meta_data() {
		if (
			tribe_is_month() ||
			tribe_is_week() ||
			tribe_is_day()
		) {
			$description = get_field( 'meta_description', 'option' );
			if ( $description ) {
				echo '<meta name="description" content="' . get_field( 'meta_description', 'option' ) . '"/>';
			}
		}
	}
	add_action( 'wp_head', 'event_meta_data' );
}
