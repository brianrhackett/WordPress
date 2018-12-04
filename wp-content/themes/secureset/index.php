<?php

/**
 * The main template file. Used to display posts with filters and search.
 *
 * @package __secureset
 */
global $post;
$page_for_posts_id = get_option( 'page_for_posts' );
$page_for_posts_obj = get_post( $page_for_posts_id );
$query_string = $_SERVER['QUERY_STRING'];
get_header(); ?>
<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image', $page_for_posts_id ) ?>' ); background-color:<?php the_field( 'page-background-color', $page_for_posts_id )?>; ">
	<main id="main" class="site-main" role="main">
		

	</main>
	<!-- #main -->
</div>
<!-- #primary -->
<?php get_footer(); ?>
