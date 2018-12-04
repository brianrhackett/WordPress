<div class="location-modal" id="js-location-modal">
	<div class="location-modal__flex-wrap">
		<div class="location-modal__logo-mobile">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo-dark.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
			</a>
		</div>
		<div class="location-modal__map" id="js-location-modal-map"></div>
		<div class="location-modal__content-wrap">
			<div class="location-modal__logo-desktop">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo-dark.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
				</a>
			</div>

			<h4 class="location-modal__heading"><?php echo get_field( 'location_modal_heading', 'option'); ?></h4>
			<p class="location-modal__copy"><?php echo get_field( 'location_modal_copy', 'option' ); ?></p>
			<h5 class="location-modal__dropdown-heading"><?php _e( 'Select your location:', '__secureset' ); ?></h5>

			<?php get_component( 'location-select', array( 'modal' => true ) ); ?>

			<button class="js-location-modal-button location-modal__button-mobile"><?php _e( 'select', '__secureset' ); ?></button>
			<button class="js-location-modal-button location-modal__button-desktop btn"><?php _e( 'select', '__secureset' ); ?></button>
		</div>
	</div>
</div>
