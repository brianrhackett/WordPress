<?php
	$locations = get_posts( array( 'post_type' => 'locations' ) );
	foreach ( $locations as $key => $location ) {
		$hide_on_site =  get_field( 'hide_on_site', $location->ID );
		if ( is_array( $hide_on_site ) && $hide_on_site[0] === 'true' ) {
			unset( $locations[ $key ] );
		}
	}
	$location_cookie = @$_COOKIE['secureset_location'];
	$default_location = get_field( 'default_location', 'option' );
	if ( $default_location ) {
		foreach( $locations as $location ) {
			if ( $location->ID == $default_location ) {
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
	$id = uniqid();
?>
<!-- Component: Location Dropdown -->
<section class="location-dropdown js-location-select ">
	<label class="location-dropdown__label"><span class="hide-on-mobile"><?php _e( 'Your ', '__secureset' ); ?></span><?php _e( 'Location:', '__secureset' ); ?></label>

	<div class="dropdown-trigger location-dropdown__trigger js-location-select__trigger" data-toggle="location-dropdown__menu-pane-<?php echo $id; ?>"><?php echo $default_location_title; ?>
	</div>
	<div id="location-dropdown__menu-pane-<?php echo $id; ?>" class="dropdown-pane" data-dropdown data-position="bottom" data-alignment="right" data-v-offset="14" data-close-on-click="true">
		<ul class="location-dropdown__list">
			<?php foreach ( $locations as $location ): ?>
				<?php echo '<li><a data-value="' . $location->ID . '">' . $location->post_title . '</a></li>'; ?>
			<?php endforeach; ?>

		</ul>
		<form class="hidden">
			<select name="location" class="js-header-location-dropdown">
				<?php foreach ( $locations as $location ): ?>
					<?php
						echo '<option value="' . $location->ID . '">' . $location->post_title . '</option>';
					?>
				<?php endforeach; ?>
			</select>
		</form>
	</div>
</section>
