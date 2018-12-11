<?php
/**
 * The template for displaying all single posts.
 *
 * @package __secureset
 */

get_header();
global $post;
$course_id = $post->ID;

$meta_query_args = array(
	array(
		'key' => '_related_course',
		'value' => 's:'.strlen($course_id).':"'.$course_id.'";',
		'compare' => 'LIKE'
	)
);
$meta_query = new WP_Meta_Query( $meta_query_args );

$bundles = get_posts(array(
	'meta_query' => $meta_query_args,
	'post_type' => 'product'
));

?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<?php the_field( 'page-background-color' )?>; " >
	<main id="main" class="site-main single-course" role="main">
		<?php 
			foreach($bundles as $i=>$bundle):
				get_component('bundle-alternator',array(
					'bundle' => $bundle->ID,
					'mode' => ($i%2 ? 'dark' : 'light'),
					'display_type' => 'grid'
				));
			endforeach;

			echo do_shortcode("[learndash_course_progress course_id=\"{$course_id}\"]"); // progress of logged in user for course
		
			echo do_shortcode("[ld_lesson_list orderby=\"date\" order=\"ASC\" course_id=\"{$course_id}\"]"); // shortcode to list lessons associated with course
			
			get_component('course-instructor',array(
				'mode' => 'light',
				'course' => $course_id,
			));
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
