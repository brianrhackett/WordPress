<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php global $custom_page_location; ?>
	<section class="latest-programs <?php echo $fields['mode']; ?>">
		<div class="container">
			<?php if ( !empty( $fields['title'] ) ) : ?>
				<h2 class="latest-programs__title component-title"><?php echo $fields['title'] ?></h2>
			<?php endif; ?>
			<div class="latest-programs__select">
				<div class="label">Select your location:</div>
				<div class="selector">
					<?php echo get_component( 'location-select' ); ?>
				</div>
			</div>
			<div class="latest-programs__container js-latest-programs__container">
				<?php
					$locations = get_posts( array( 'post_type' => 'locations' ) );
					$location_cookie = @$_COOKIE['secureset_location'];
					$default_location_id = $locations[0]->ID;
					foreach ( $locations as $location ) {
						if ( isset( $location_cookie ) && (int)$location_cookie === (int)$location->ID ) {
							$default_location_id = $location->ID;
						}
					}
					if ( $custom_page_location ) {
						$default_location_id = $custom_page_location;
					}
					// Get next 6 programs in current location that have a start date later than "today"
					$programs = get_posts( array(
						'posts_per_page'	=> 6,
						'post_type'			=> 'programs',
						'meta_query'		=> array(
							'relation' => 'AND',
							array(
								'key'		=> 'start_date',
								'value'		=> date( 'Ymd' ),
								'compare'	=> '>=',
							),
							array(
								'key'		=> 'location',
								'value'		=> $default_location_id,
								'compare'	=> '=',
							),
						),
						'meta_key'		=> 'start_date',
						'orderby' 		=> 'meta_value',
						'order' 		=> 'ASC'
					) );

					foreach ( $programs as $program ) :
						$p_fields = get_fields( $program->ID );
						$p_type_fields = get_fields( 'program_types_' . $p_fields['program_type'] ); ?>
							<a class="latest-programs__item" href="<?php echo get_post_permalink( $program->ID );?>">
								<div class="latest-programs__item-info">
								<?php
									if ( !empty( $p_type_fields['program_icon'] ) ) : ?>
										<div class="latest-programs__item-icon" style="background-color:<?php echo ( !empty( $p_type_fields['program_color'] ) ) ? $p_type_fields['program_color'] : '#0270cd'; ?>;">
											<?php echo wp_get_attachment_image( $p_type_fields['program_icon']['id'], 'medium' ); ?>
										</div>
										<?php
									endif;
									if ( !empty( $p_type_fields['program_type'] ) ) : ?>
										<h6 class="latest-programs__item-title"><?php echo esc_attr( $p_type_fields['program_type'] ); ?></h6>
										<?php
									endif;

									if ( !empty( $p_fields['location'] ) ) : ?>
										<p class="small latest-programs__item-location"><?php echo esc_attr( $p_fields['location']->post_title ); ?></p>
										<?php
									endif;
									if ( !empty( $p_fields['start_date'] ) || !empty( $p_fields['end_date'] ) ) : ?>
										<p class="latest-programs__item-dates">
											<?php
											// get raw date
											$startDate = get_field( 'start_date', $program->ID, false);
											$startDate = new DateTime( $startDate );
											$endDate = get_field( 'end_date', $program->ID, false);
											$endDate = new DateTime( $endDate );
											if ( !empty( $p_fields['start_date'] ) ) :
												echo esc_attr( ( !empty( $p_fields['end_date'] ) ) ? $startDate->format( 'M j' ) . '-' . $endDate->format( 'M j' ) : $startDate->format( 'M j' ) );
											endif;
											?>
										</p>
										<?php
									endif;
								?>
								</div>
								<div class="latest-programs__item-button">Learn More</div>
							</a>
						<?php
					endforeach;
				?>
			</div>
			<a class="latest-programs__more-button btn" href="<?php echo $fields['custom_cta'] ? $fields['cta_link']['url'] : get_home_url( '', '/programs/' );?>">
				<?php echo $fields['custom_cta'] ? $fields['cta_link']['title'] : 'View More' ?>
			</a>
		</div>
	</section>
<?php endif; ?>
