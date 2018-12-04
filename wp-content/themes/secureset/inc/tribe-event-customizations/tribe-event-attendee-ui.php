<?php
if ( class_exists( 'Tribe__Events__Main' ) ) {

	/**
	 * Class that exposes the tribe_rsvp_attendees CPT in the WP admin
	 */
	class Tribe_Event_Attendee_UI {

		private $cpt_name = 'tribe_rsvp_attendees';

		public function __construct() {

			// Filters
			add_filter( 'register_post_type_args', array( $this, 'modify_attendee_post_type' ), 20, 2 );

			// Sorting is not working with search currently
			//add_filter( 'manage_edit-' . $this->cpt_name . '_sortable_columns', array( $this, 'make_custom_columns_sortable' ) );
			add_filter( 'posts_join', array( $this, 'modify_search_join' ) );
			add_filter( 'posts_where', array( $this, 'modify_search_where' ) );
			add_filter( 'posts_distinct', array( $this, 'modify_search_distinct' ) );

			// Actions
			add_action( 'manage_' . $this->cpt_name . '_posts_columns', array( $this, 'set_custom_attendee_column_headings' ), 10, 2 );
			add_action( 'manage_' . $this->cpt_name . '_posts_custom_column', array( $this, 'set_custom_attendee_columns' ), 10, 2 );
			add_action( 'pre_get_posts', array( $this, 'custom_columns_sorting' ) );
			add_action( 'admin_footer', array( $this, 'export_attendees_button' ) );
			add_action( 'admin_init', array( $this, 'export_attendees_csv' ) );
		}

		/**
		 * Intercept the main query and modify it for custom fields
		 */
		public function custom_columns_sorting( $query ) {
			
			// Make sure everything checks out
			if ( 
				! is_admin() ||
				! $query->is_main_query()
			) {
				return;
			}
			
			$screen = get_current_screen();
			if ( $screen->id !== 'edit-tribe_rsvp_attendees' )
				return;

			// Modify the query for custom fields
			$query = $this->_modify_query( $query );
		}

		/**
		 * Modfies the query to include the postmeta table
		 */
		public function modify_search_join( $join ) {
			global $wp_query, $wpdb;
			$admin_screen = @$_GET['post_type'];
			if ( 
				! is_admin() ||
				! is_main_query() ||
				! $admin_screen === 'tribe_rsvp_attendees'
			) {
				return $join;
			}
			if ( is_search() ) {
				$join .= ' LEFT JOIN ' . $wpdb->postmeta . ' AS ss_postmeta ON '. $wpdb->posts . '.ID = ss_postmeta.post_id ';
			}
			return $join;
		}

		/**
		 * Modfiy where clause when searching
		 */
		public function modify_search_where( $where ) {
			global $pagenow, $wpdb;
			$admin_screen = @$_GET['post_type'];
			if ( 
				! is_admin() ||
				! is_main_query() ||
				! $admin_screen === 'tribe_rsvp_attendees'
			) {
				return $where;
			}

			if ( is_search() ) {
				$where = preg_replace(
					"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
					"(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where
				);
			}
			return $where;
		}

		/**
		 * Modify where clause add distinct
		 */
		public function modify_search_distinct( $where ) {
			$admin_screen = @$_GET['post_type'];
			if ( 
				! is_admin() ||
				! is_main_query() ||
				! $admin_screen === 'tribe_rsvp_attendees'
			) {
				return $where;
			}

			if ( is_search() ) {
				return "DISTINCT";
			}
			return $where;
		}

		/**
		 * Modifies a WP_Query object to properly handle custom meta fields
		 *
		 * @param  	WP_Query 	Wordpress Query object
		 * @return 	WP_Query 	Wordpress Query object
		 */
		private function _modify_query( $query ) {
			$is_search = $query->is_search;
			// $orderby = $query->get( 'orderby' );

			// If orderby is set, adjust the query appropriately
			// Currently not used due to a bug with search and order by meta fields
			// 
			// if ( $orderby ) {
			// 	switch ( $orderby ) {
			// 		case '_first_name':
			// 			$query->set( 'meta_key', '_first_name' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_last_name':
			// 			$query->set( 'meta_key', '_last_name' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_tribe_rsvp_email':
			// 			$query->set( 'meta_key', '_tribe_rsvp_email' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_phone_number':
			// 			$query->set( 'meta_key', '_phone_number' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_interest':
			// 			$query->set( 'meta_key', '_interest' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_event_title':
			// 			$query->set( 'meta_key', '_event_title' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 		case '_start_date':
			// 			$query->set( 'meta_key', '_start_date' );
			// 			$query->set( 'orderby', 'meta_value_num title' );
			// 			break;
			// 		case '_location':
			// 			$query->set( 'meta_key', '_location' );
			// 			$query->set( 'orderby', 'meta_value title' );
			// 			break;
			// 	}		
			// }

			// If search is set, adjust the query appropriately
			if ( $is_search ) {
				$meta_query = array(
					'relation' => 'OR',
					array(
						'relation' => 'OR',
						array(
							'key' => '_first_name',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_last_name',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_tribe_rsvp_email',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_phone_number',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_interest',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_event_title',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_start_date',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
						array(
							'key' => '_location',
							'value' => get_search_query(),
							'compare' => 'LIKE'
						),
					)
				);
				$query->set( 'meta_query', $meta_query );
			}
			return $query;
		}

		/**
		 * Updates the attendee custom post type so it is accessable via WP Admin
		 * 
		 * @param  array  $args      First param of the register_post_type_args filter https://developer.wordpress.org/reference/hooks/register_post_type_args/
		 * @param  string $post_type Second param of the register_post_type_args filter https://developer.wordpress.org/reference/hooks/register_post_type_args/
		 * @return void
		 */
		public function modify_attendee_post_type( $args, $post_type ) {
			if ( $post_type == 'tribe_rsvp_attendees' ) {
				$args['public'] = false;
				$args['show_ui'] = true;
				$args['show_in_menu'] = true;
				$args['labels']['search_items'] = __( 'Search Attendees', '__secureset' );
				$args['capabilities'] = array(
					'create_posts' => 'do_not_allow'
				);
				$args['map_meta_cap'] = false;
			}
			return $args;
		}

		/**
		 * Makes the custom columns sortable
		 * CURRENTLY UNUSED
		 */
		public function make_custom_columns_sortable( $columns ) {
			$columns['first_name'] = '_first_name';
			$columns['last_name'] = '_last_name';
			$columns['email'] = '_tribe_rsvp_email';
			$columns['phone'] = '_phone_number';
			$columns['interest'] = '_interest';
			$columns['event_title'] = '_event_title';
			$columns['start_date'] = '_start_date';
			$columns['location'] = '_location';
			return $columns;
		}

		/**
		 * Adds columns headings to the attendee list
		 */
		public function set_custom_attendee_column_headings( $columns ) {
			$columns['first_name'] 		= __( 'First Name', '__secureset' );
			$columns['last_name'] 		= __( 'Last Name', '__secureset' );
			$columns['email'] 			= __( 'Email', '__secureset' );
			$columns['phone'] 			= __( 'Phone Number', '__secureset' );
			$columns['interest'] 		= __( 'Interest', '__secureset' );
			$columns['event_title']		= __( 'Event Title', '__secureset' );
			$columns['start_date']		= __( 'Start Date', '__secureset' );
			$columns['location']		= __( 'Location', '__secureset' );
			// unset( $columns['date'] );
			unset( $columns['title'] );
			return $columns;
		}

		/**
		 * 
		 */
		public function set_custom_attendee_columns( $column, $post_id ) {
			switch ( $column ) {
				case 'first_name':
					echo @get_post_meta( $post_id, '_first_name' )[0];
					break;
				case 'last_name':
					echo @get_post_meta( $post_id, '_last_name' )[0];
					break;
				case 'email':
					echo @get_post_meta( $post_id, '_tribe_rsvp_email' )[0];
					break;
				case 'phone':
					echo @get_post_meta( $post_id, '_phone_number' )[0];
					break;
				case 'interest':
					echo @get_post_meta( $post_id, '_interest' )[0];
					break;
				case 'event_title':
					echo @get_post_meta( $post_id, '_event_title' )[0];
					break;
				case 'start_date':
					$start_date = @get_post_meta( $post_id, '_start_date' )[0];
					if ( $start_date ) {
						echo date( 'm/d/y h:i:s a', $start_date );
					}
					break;
				case 'location':
					echo @get_post_meta( $post_id, '_location' )[0];
					break;
			}
		}

		/**
		 * Adds the Export button to the tribe_rsvp_attendees edit screen
		 */
		public function export_attendees_button() {
			$screen = get_current_screen();
			if ( $screen->id !== 'edit-tribe_rsvp_attendees' )
				return;
			?>
			<style>
				.tablenav .actions { display: none !important; }
				.row-actions { display: none !important; }
				.check-column { display: none !important; }
			</style>
			<script type="text/javascript">

				jQuery( document ).ready( function($) {
					var postIds = [];
					$( '#the-list .type-tribe_rsvp_attendees' ).each( function() {
						postIds.push( this.id.replace( 'post-', '' ) );
					});
					postIds = encodeURIComponent( JSON.stringify( postIds ) );

					$( '.tablenav.top .clear, .tablenav.bottom .clear' ).before( '<form style="float: left; clear: left; margin: 0 0 5px;" method="POST"><input type="hidden" id="ss_export" name="ss_export" value="1" /><input class="button button-primary user_export_button" style="margin-top:3px;" type="submit" value="<?php esc_attr_e( 'Export All as CSV', '__secureset' );?>" /><input type="hidden" name="ss_posts" value=\'' + postIds + '\' /></form>' );
				});
		    </script>
		    <?php
		}

		/**
		 * Functionality to export the attendee list as CSV
		 */
		public function export_attendees_csv() {

			// Check to make sure everything checks out			
			if ( 
				! is_admin() ||
				! current_user_can( 'manage_options' ) ||
				empty( $_POST['ss_export'] ) ||
				empty( $_POST['ss_posts'] )
			) {
				return;
			}
			$post_ids = json_decode( urldecode( $_POST['ss_posts'] ) );
			if ( ! $post_ids ) {
				return;
			}

			// Set headers to CSV download
			header( 'Content-type: application/force-download' );
			header( 'Content-Disposition: inline; filename="attendees-' . date( 'YmdHis' ) . '.csv"' );
	
			foreach( $post_ids as $attendee_id ) {
				$first_name = get_field( '_first_name', $attendee_id );
				$last_name = get_field( '_last_name', $attendee_id );
				$email = get_field( '_tribe_rsvp_email', $attendee_id );
				$phone = get_field( '_phone_number', $attendee_id );
				$interest = get_field( '_interest', $attendee_id );
				$event_title = get_field( '_event_title', $attendee_id );
				$start_date = get_field( '_start_date', $attendee_id );
				$location = get_field( '_location', $attendee_id );
				echo '"' . $first_name . '","' . $last_name . '","' . $email . '","' . $phone . '","' . $interest . '","' . $start_date  . '","' . $location . '"' . "\r\n";
			}
			exit;
		}
	}
	new Tribe_Event_Attendee_UI;

} // End Tribe Events class check
