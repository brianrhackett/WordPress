<?php
function create_post_type() {
	$admins = get_role( 'administrator' );

	register_post_type( 'locations',
		array(
			'labels' => array(
				'name' => __( 'Locations', '__secureset' ),
				'singular_name' => __( 'Location', '__secureset' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-location',
			'capability_type' => 'location',
			'exclude_from_search' => true
		)
	);

	$admins->add_cap( 'edit_location' );
	$admins->add_cap( 'read_location' );
	$admins->add_cap( 'delete_location' );
	$admins->add_cap( 'edit_locations' );
	$admins->add_cap( 'edit_others_locations' );
	$admins->add_cap( 'publish_locations' );
	$admins->add_cap( 'read_private_locations' );
	$admins->add_cap( 'edit_locations' );

	register_post_type( 'team',
		array(
			'labels' => array(
				'name' => __( 'Team', '__secureset' ),
				'singular_name' => __( 'Team', '__secureset' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-users',
			'capability_type' => 'team',
			'exclude_from_search' => true
		)
	);

	$admins->add_cap( 'edit_team' );
	$admins->add_cap( 'read_team' );
	$admins->add_cap( 'delete_team' );
	$admins->add_cap( 'edit_teams' );
	$admins->add_cap( 'edit_others_teams' );
	$admins->add_cap( 'publish_teams' );
	$admins->add_cap( 'delete_teams' );
	$admins->add_cap( 'delete_private_teams' );
	$admins->add_cap( 'delete_published_teams' );
	$admins->add_cap( 'delete_others_teams' );
	$admins->add_cap( 'edit_private_teams' );
	$admins->add_cap( 'edit_published_teams' );
	$admins->add_cap( 'edit_teams' );
}

add_action( 'init', 'create_post_type' );
?>
