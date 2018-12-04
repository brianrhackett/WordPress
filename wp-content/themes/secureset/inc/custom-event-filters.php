<?php

if ( class_exists( 'Tribe__Events__Filterbar__Filter' ) ):

	/**
	 * Custom Location Filter for the plugin the-events-calendar-filerbar
	 */
	class Tribe__Events__Filterbar__Filters__Location extends Tribe__Events__Filterbar__Filter {
		public $type = 'checkbox';

		protected function get_values() {
			// Query for locations and populate this array with them
			global $wpdb;

			// get venue IDs associated with published posts
			$location_ids =
				$wpdb->get_col(
					$wpdb->prepare(
						"SELECT DISTINCT m.meta_value
						FROM {$wpdb->postmeta} m
						INNER JOIN {$wpdb->posts} p
						ON p.ID=m.post_id
						WHERE p.post_type=%s
						AND p.post_status='publish'
						AND m.meta_key='location'
						AND m.meta_value IS NOT NULL
						",
						Tribe__Events__Main::POSTTYPE
				)
			);
			$location_ids = array_filter( $location_ids );
			if ( empty( $location_ids ) ) {
				return array();
			}

			function unserializeArray( &$item, $key ) {
				$item = unserialize( $item )[0];
			}
			array_walk( $location_ids, 'unserializeArray' );

			$limit = apply_filters( 'tribe_eventsfilter_bar_venues_limit', 200, $location_ids );

			$locations = get_posts( array(
				'post_type' => 'locations',
				'post_per_page' => $limit,
				'suppress_filters' => false,
				'post__in' => $location_ids,
				'post_status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC',
			) );

			foreach ( $locations as $key => $location ) {
				$hide_on_site =  get_field( 'hide_on_calendar', $location->ID );
				if ( is_array( $hide_on_site ) && $hide_on_site[0] === 'true' ) {
					unset( $locations[ $key ] );
				}
			}

			$location_array = array();
			foreach ( $locations as $location ) {
				$location_array[] = array(
					'name' => $location->post_title,
					'value' => $location->ID
				);
			}
			return $location_array;
		}

		public function pre_get_posts( WP_Query $query ) {
			if ( is_array( $this->currentValue ) ) {
				$location_ids = $this->currentValue;
			} else {
				$location_ids = array( $location_ids );
			}

			$meta_query = $query->get('meta_query');
			$like_in_arr = array('relation' => 'OR');
			foreach ( $location_ids as $location_id ) {
				$like_in_arr[] = array(
					'key' => 'location',
					'value' => '"' . $location_id . '"',
					'compare' => 'LIKE'
				);
			}
			$meta_query[] = $like_in_arr;
			$query->set( 'meta_query', $meta_query );
		}
	}

	new Tribe__Events__Filterbar__Filters__Location( __( 'Location', '__secureset' ), 'locations' );


	/**
	 * Custom Level Filter for the plugin the-events-calendar-filerbar
	 */
	class Tribe__Events__Filterbar__Filters__Level extends Tribe__Events__Filterbar__Filter {
		public $type = 'radio';

		protected function get_values() {
			// Query for locations and populate this array with them
			global $wpdb;
			$values = array(
				array(
					'name' => 'Beginner',
					'value' => 'beginner',
				),
				array(
					'name' => 'Expert',
					'value' => 'expert',
				)
			);
			return $values;
		}

		/**
		 * Display the given filter in the list on the frontend.
		 *
		 * @return void
		 */
		public function displayFilter() {
			$values = apply_filters( 'tribe_events_filter_values', $this->get_values(), $this->slug );

			if ( ! empty( $values ) ) {
				?>
				<div id="js-custom-level-filter" class="tribe_events_filter_item<?php echo tribe_get_option( 'events_filters_layout', 'vertical' ) == 'horizontal' ? ' closed' : '';
				echo ! empty( $this->currentValue ) ? ' active' : ''; ?>" id="tribe_events_filter_item_<?php echo esc_attr( $this->slug ); ?>">
				<?php
					if ( ! isset( $this->currentValue ) ) {
						$current_value = '';
					} else {
						$current_value = is_array( $this->currentValue ) ? current( $this->currentValue ) : $this->currentValue;
					}
					?>
					<div class="hidden">
						<h3 class="tribe-events-filters-group-heading">
							<?php echo stripslashes( $this->title ); ?><span class="horizontal-drop-indicator"></span>
							<span class="tribe-filter-status"><?php ?></span>
						</h3>
						<div class="tribe-events-filter-group tribe-events-filter-radio">
						<ul>
						<?php foreach ( $values as $option ):

							$data = array();
							if ( isset( $option['data'] ) && is_array( $option['data'] ) ) {
								foreach ( $option['data'] as $attr => $value ) {
									$data[] = 'data-' . esc_attr( $attr ) . '="' . trim( $value ) . '"';
								}
							}
							$data = join( ' ', $data );

							// Support CSS classes per list item
							$class = '';

							if ( isset( $option['class'] ) && ! empty( $option['class'] ) ) {
								$class = ' class="' . esc_attr( $option['class'] ) . '"';
							}

							// output option to screen
							printf( '
								<li%s>
									<label>
										<input type="radio" value="%s" %s name="%s" %s />
										<span title="%s">%s</span>
									</label>
								</li>',
								$class,
								esc_attr( $option['value'] ),
								checked( trim( $option['value'] ), $current_value, false ),
								esc_attr( 'tribe_' . $this->slug ),
								$data,
								esc_html( stripslashes( $option['name'] ) ),
								esc_html( stripslashes( $option['name'] ) )
								);
							?>
						<?php endforeach; ?>
						</ul>
						</div>
					</div>
					<?php
				?>
				</div>
				<?php
			}
		}

		function pre_get_posts( WP_Query $query ) {

			//Get original meta query
			$meta_query = $query->get('meta_query');

			//Add our meta query to the original meta queries
			$meta_query[] = array(
				'key' => 'event_level',
				'value' => $this->currentValue,
				'compare' => '=',
			);
			$query->set( 'meta_query', $meta_query );
		}
	}

	new Tribe__Events__Filterbar__Filters__Level( __( 'Level', '__secureset' ), 'level' );

endif;
