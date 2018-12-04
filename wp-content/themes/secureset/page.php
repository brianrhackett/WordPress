<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package __secureset
 */

get_header(); ?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<?php the_field( 'page-background-color' )?>; " >
	<main id="main" class="site-main" role="main">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content() ?>

			<?php endwhile; // End of the loop. ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
