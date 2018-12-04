<?php
/**
 * Template Name: 404
 */
?>
<?php

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<section class="notfound" <?php if( !empty( get_field( 'notfound_background_image ', 'option' ) ) ): ?> style="background-image: url(<?php echo get_field( 'notfound_background_image ', 'option' ); ?>);" <?php endif; ?>>
			<div class="container">
				<div class="notfound__content">
					<h3 class="notfound__title"><?php echo get_field( '404_title ', 'option' ); ?></h3>
					<p class="notfound__copy text-big"><?php echo get_field( '404_copy ', 'option' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--large notfound__button"><?php _e('Return Home', '__secureset'); ?></a>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php get_footer(); ?>
