<?php if ( is_array( $fields ) && !empty( $fields ) ) : ?>
	<?php
		global $custom_page_location;
		$locations = get_posts( array( 'post_type' => 'locations', 'limit' => -1 ) );
		$current_location = null;
		$current_location_id = get_current_location_id();

		foreach ( $locations as &$location ) {
			$location->email = get_field( 'email', $location->ID );
			$location->city = get_field( 'city', $location->ID );
			$location->state = get_field( 'state', $location->ID );
			$location->full_address = get_field( 'full_address', $location->ID );
			$location->phone = get_field( 'phone', $location->ID );
			$location->latitude = get_field( 'latitude', $location->ID );
			$location->longitude = get_field( 'longitude', $location->ID );
			if ( $custom_page_location ) {
				if ( $location->ID === $custom_page_location ) {
					$current_location = $location;
				}
			} else {
				if ( $location->ID === $current_location_id ) {
					$current_location = $location;
				}
			}
		}
	?>

	<section class="location-details <?php echo $fields['mode']; ?> map--<?php echo $fields['toggle_map']; ?>">
		<script type="application/json" class="js-location-details-data"><?php echo json_encode( $locations ); ?></script>
		<?php if ( !empty( $fields['title'] ) ) : ?>
			<h2 class="location-details__title component-title"><?php echo $fields['title']; ?></h2>
		<?php endif; ?>

		<div class="location-details__background">

			<div class="container">
				<div class="location-details__location-bar location-details__location-bar--mobile">
					<h3 class="location-details__location-bar-label"><?php _e( 'Select your location:', '__secureset' ); ?></h3>
					<?php get_component( 'location-select' ); ?>
				</div>
			</div>

			<div class="js-location-details-map location-details__map"></div>

			<div class="location-details__location-bar location-details__location-bar--desktop">
				<h3 class="location-details__location-bar-label"><?php _e( 'Select your location:', '__secureset' ); ?></h3>
				<div class="location-details__location-bar-wrap">
					<?php get_component( 'location-select' ); ?>
				</div>
			</div>

			<div class="location-details__content container">
				<div class="js-location-details-title location-details__content-title">
					<h3 class="component-title"><?php echo $current_location->post_title; ?></h3>
				</div>

				<div class="js-location-details-address location-details__content-address">
					<?php
						$address_link = $fields['address_link'];
						if ( $address_link ) {
							echo '<a href="' . $address_link['url'] . '" target="' . $address_link['target'] . '">';
						}
						echo $current_location->full_address;
						if ( $address_link ) {
							echo '</a>';
						}
					?>


				</div>

				<div class="location-details__content-phone-email-wrap">
					<a class="js-location-details-phone location-details__content-telephone" href="tel:+<?php echo $current_location->phone; ?>"><?php echo $current_location->phone; ?></a><br />
					<a class="js-location-details-email location-details__content-email" href="mailto:<?php echo $current_location->email; ?>"><?php echo $current_location->email; ?></a>
				</div>
			</div>

		</div>
	</section>
<?php endif; ?>
