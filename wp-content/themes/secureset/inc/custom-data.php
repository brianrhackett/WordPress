<?php
/**
 * Custom data associated with the theme such as custom post types, taxonomies, menus ect go here
 *
 * @package __secureset
 */
function change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
	$submenu['edit.php'][16][0] = 'News Tags';
}

function change_post_object() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
	$labels->all_items = 'All News';
	$labels->menu_name = 'News';
	$labels->name_admin_bar = 'News';
}

add_action( 'admin_menu', 'change_post_label' );
add_action( 'init', 'change_post_object' );

/**
 * Filter the excerpt "read more" string.
 *
 * @link url https://developer.wordpress.org/reference/functions/the_excerpt/
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );


/**
 * Used to collapse field groups by default
 * 
 * @link https://support.advancedcustomfields.com/forums/topic/collapsed-field-groups-as-default/
 * @return void
 */
function my_acf_admin_head() {
	?>
	<script type="text/javascript">
		(function($){

			$(document).ready(function(){

				$('.layout').addClass('-collapsed');
				$('.acf-postbox').addClass('closed');

			});

		})(jQuery);
	</script>
	<?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');