<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php
		global $custom_page_location;
		$event_categories = $fields['event_categories'];
	?>

	<section class="latest-events <?php echo $fields['mode']; ?>" >
		<div class="container">
			<?php if ( !empty( $fields['title'] ) ) : ?>
				<h2 class="latest-events__title component-title"> <?php echo $fields['title'] ?></h2>
			<?php endif; ?>
			<div class="latest-events__select">
				<div class="label"><?php _e( 'Select your location:', '__secureset' ); ?></div>
				<div class="selector">
					<?php echo get_component( 'location-select' ); ?>
				</div>
			</div>

			<div class="latest-events__container js-latest-events__container" data-event-categories="<?php echo implode( ',', $event_categories ); ?>">
				<?php
					if ( $custom_page_location ) {
						$location_id = $custom_page_location;
					} else {
						$location_id = get_current_location_id();
					}

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
								'relation' => 'OR',
								array(
									'key'		=> 'location',
									'value'		=> $location_id,
									'compare'	=> 'LIKE',
								),
								array(
									'key'		=> 'online',
									'value'		=> '"true"',
									'compare'	=> 'LIKE',
								),
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

					if ( !empty( $events ) ) :
						foreach ( $events as $post ) : ?>
							<?php setup_postdata( $post ); ?>
							<a href="<?php echo tribe_get_event_link( $post );?>" class="latest-events__item">
								<div class="latest-events__item-info">
									<h6 class="latest-events__item-title">
										<?php echo $post->post_title; ?>
									</h6>
									<div class="latest-events__item-date">
										<?php echo nl2br( tribe_get_start_date( $post, false, "F d, Y\ng:i a"  ) ); ?>
									</div>
								</div>
								<div class="latest-events__item-button"><?php _e( 'Learn More', '__secureset' ); ?></div>
							</a>
							<?php
						endforeach;
						wp_reset_postdata();
					else : ?>
						<div class="latest-events__item">
							<div class="latest-events__item-info">
								<h6 class="latest-events__item-title">Sorry, no upcoming events for your location.</h6>
							</div>
						</div>
						<?php
					endif;
				?>
			</div>
			<a class="latest-events__calendar-button btn" href="<?php echo esc_url( Tribe__Events__Main::instance()->getLink() ); ?>"><?php _e( 'View Full Calendar', '__secureset' ); ?></a>
		</div>
	</section>
<?php endif; ?>
