<?php
	global $custom_page_location;
	$locations = get_posts( array( 'post_type' => 'locations' ) );
	foreach ( $locations as $key => $location ) {
		$hide_on_site =  get_field( 'hide_on_site', $location->ID );
		if ( is_array( $hide_on_site ) && $hide_on_site[0] === 'true' ) {
			unset( $locations[ $key ] );
		}
	}
	$location_cookie = @$_COOKIE['secureset_location'];
	$default_location_field_id = get_field( 'default_location', 'option' );
	if ( $default_location_field_id ) {
		foreach( $locations as $location ) {
			if ( $location->ID == $default_location_field_id ) {
				$default_location_id = $location->ID;
				$default_location_title = $location->post_title;
				$default_location_lat = get_field( 'latitude', $default_location_id );
				$default_location_long = get_field( 'longitude', $default_location_id );
				break;
			}
		}
	} else {
		$default_location_id = $locations[0]->ID;
		$default_location_title = $locations[0]->post_title;
		$default_location_lat = get_field( 'latitude', $default_location_id );
		$default_location_long = get_field( 'longitude', $default_location_id );
	}

	foreach ( $locations as $location ) {
		if ( isset( $location_cookie ) && (int)$location_cookie === (int)$location->ID ) {
			$default_location_title = $location->post_title;
			$default_location_id = $location->ID;
			$default_location_lat = get_field( 'latitude', $location->ID );
			$default_location_long = get_field( 'longitude', $location->ID );
		}
	}

	if ( $custom_page_location && !isset( $fields['modal'] ) ) {
		$default_location_id = $custom_page_location;
		$location = get_post( $default_location_id );
		$default_location_title = $location->post_title;
		$default_location_id = $location->ID;
		$default_location_lat = get_field( 'latitude', $location->ID );
		$default_location_long = get_field( 'longitude', $location->ID );
	}
	$id = uniqid();
?>
<!-- Component: Location Select -->
<div class="location-select js-location-select" data-default-location-id="<?php echo $default_location_id; ?>" data-default-location-lat="<?php echo $default_location_lat; ?>" data-default-location-long="<?php echo $default_location_long; ?>" data-custom-page-location="<?php if ( $custom_page_location ) { echo 'true'; } else { echo 'false'; } ?>">
	<div class="location-container">
		<div class="dropdown-trigger location-dropdown__trigger js-location-select__trigger" data-toggle="location-select__menu-pane-<?php echo $id; ?>">
			<div class="location-title">
				<?php echo $default_location_title; ?>
			</div>
		</div>
		<div id="location-select__menu-pane-<?php echo $id; ?>" class="js-location-select-menu-pane dropdown-pane" data-dropdown data-position="bottom" data-alignment="left" data-v-offset="0" data-close-on-click="true">

			<ul class="location-select__list">
				<?php if ( isset( $fields['modal'] ) ) : ?>
					<li><a data-value="<?php echo $default_location_id; ?>" data-lat="<?php echo $default_location_lat; ?>" data-long="<?php echo $default_location_long; ?>" ><?php _e( 'Corporate Campus', 'secureset' ); ?></a></li>
				<?php endif; ?>
				<?php foreach ( $locations as $location ) : ?>
					<?php echo '<li><a data-value="' . $location->ID . '" data-lat="' . get_field( 'latitude', $location->ID ) . '" data-long="' . get_field( 'longitude', $location->ID ) . '">' . $location->post_title . '</a></li>'; ?>
				<?php endforeach; ?>
			</ul>

			<form class="hidden">
				<select name="location">
					<?php if ( isset( $fields['modal'] ) ) : ?>
						<option value="<?php echo $default_location_id; ?>" data-lat="<?php echo $default_location_lat; ?>" data-long="<?php echo $default_location_long; ?>"><?php _e( 'Corporate Compus' ); ?></option>
					<?php endif; ?>
					<?php foreach ( $locations as $location ) : ?>
						<?php
							$selected = '';
							if ( $location->ID == $default_location_field_id ) {
								$selected = 'selected="selected"';
							}
						?>
						<?php echo '<option ' . $selected . ' value="' . $location->ID . '" data-lat="' . get_field( 'latitude', $location->ID ) . '" data-long="' . get_field( 'longitude', $location->ID ) . '">' . $location->post_title . '</option>'; ?>
					<?php endforeach; ?>
				</select>
			</form>
		</div>
	</div>
</div>
