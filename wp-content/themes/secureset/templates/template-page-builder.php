<?php
/**
 * Template Name: Page Builder
 *
 * @package __secureset
 */
$has_page_location = get_field( 'has_page_location' );
if ( $has_page_location === 'yes' ) {
	$page_location = get_field( 'page_location' );
	global $custom_page_location;
	$custom_page_location = $page_location;
}
get_header(); ?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<?php the_field( 'page-background-color' ); ?>" >
	<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_page_builder( 'main_page_builder' ); ?>

	<?php endwhile; // End of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
