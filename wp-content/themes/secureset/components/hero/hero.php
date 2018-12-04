<?php if ( is_array( $fields ) && !empty( $fields ) ) :
	$hero_type = ( !empty( $fields['hero_type'] ) ) ? $fields['hero_type'] : false; ?>
<?php // die('<pre>'.print_r($fields,1));?>
	<section class="hero <?php if ( $hero_type ) : echo esc_attr( 'hero--' . $hero_type ); endif; ?> <?php if( !empty( $fields['hero_theme'] ) ) { echo 'hero__theme--' . $fields['hero_theme']; };?>">
		<?php
			if ( $hero_type === 'hero-nonav' ) : ?>
				<div class="hero__header container">
					<div class="hero__logo">
						<?php
							if ( !empty( $fields['replacement_logo'] ) ) :
								echo wp_get_attachment_image( $fields['replacement_logo'], 'medium' );
							else : ?>
								<img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
								<?php
							endif;
						?>
					</div>
				</div>
				<?php
			endif;
			if ( $hero_type !== 'hero-text' ) : ?>
				<div class="hero__gradient-overlay<?php if( $fields[ 'grayscale' ] ) { echo ' hero__gradient-overlay--grayscale'; }; ?>"></div>
				<?php
				 	$desktop_image_src = false;

					if ( $fields['background_image'] ) :
						if ( is_numeric( $fields['background_image'] ) ) {
							$desktop_image_src = wp_get_attachment_image_src( $fields['background_image'], 'full' )[0];
						} else {
							$desktop_image_src = $fields['background_image'];
						}
					endif;

					$mobile_image_src = $desktop_image_src;
					if ( $fields['background_image_mobile'] ) :
						if ( is_numeric( $fields['background_image_mobile'] ) ) {
							$mobile_image_src = wp_get_attachment_image_src( $fields['background_image_mobile'], 'full' )[0];
						} else {
							$mobile_image_src = $fields['background_image_mobile'];
						}
					endif;

					if ( $desktop_image_src ) : ?>
						<div class="hero__image--desktop<?php if( $fields[ 'grayscale' ] ) { echo ' hero__image--grayscale'; }; ?>" style="background-image: url('<?php echo $desktop_image_src; ?>');" ></div>
						<?php
					endif;

					if ( $mobile_image_src ) : ?>
						<div class="hero__image--mobile<?php if( $fields[ 'grayscale' ] ) { echo ' hero__image--grayscale'; }; ?>" style="background-image: url('<?php echo $mobile_image_src; ?>');" ></div>
						<?php
					endif;

			endif;
		?>
		<div class="container">
			<div class="hero__content">
				<?php
					if ( $fields['hero_pre_title'] && $hero_type === 'hero-search') : ?>
						<div class="hero__pre-headline"><?php echo esc_attr( $fields['hero_pre_title'] ); ?></div>
						<?php
					endif;

					if ( $fields['hero_title'] ) : ?>
						<h1 class="hero__headline"><span <?php if ( is_program_landing_page() && isset( $GLOBALS['program_type_hex_color'] ) ) { echo 'style="background-image: linear-gradient(to right, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 100%);"'; } ?>><?php echo esc_attr( $fields['hero_title'] ); ?></span></h1>
						<?php
					endif;

					if ( $fields['hero_copy'] ) : ?>
						<div class="hero__copy"><?php echo wp_kses_post( $fields['hero_copy'] ); ?></div>
						<?php
					endif;
				?>
				<div class="hero__cta-group">
					<?php
						if ( !empty( $fields['hero_ctas'] ) ) :
							$ctas = $fields['hero_ctas'];
							foreach ( $ctas as $key => $cta ) :
								get_component( 'cta', array(
										'cta_text' => $cta[ 'clone_cta_text' ],
										'cta_color' => $cta[ 'clone_cta_color' ],
										'cta_new_window' => $cta[ 'clone_cta_new_window' ],
										'cta_link_type' => $cta[ 'clone_cta_link_type' ],
										'cta_custom_url' => $cta[ 'clone_cta_custom_url' ],
										'cta_internal_url' => $cta[ 'clone_cta_internal_url' ],
										'cta_file_url' => $cta[ 'clone_cta_file_url' ]
									)
								);
							endforeach;
						endif;
					?>
				</div>
			</div>
		</div>

		<?php 
		if ( $hero_type === 'hero-video' ) {
			$video = $fields['hero_video'];
			if($video) {
				preg_match( '/src="(.+?)"/', $video, $matches );
				$src =  $matches[1];
		?>	
				<div class="js-full-vid full-vid">
					<div class="full-vid-holder" ><iframe width="100%" height="100%" src="" class="js-full-video-iframe full-video-iframe" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"  data="<?php echo $src; ?>"></iframe><div class="exit">&times;</div></div>
					<div class="container">
						<span class="js-full-vid-play-button media-helper__play-button playpause">Play Video</span>
					</div>
				</div>
		<?php 
			}
		} 
		?>
	</section>
<?php endif;
