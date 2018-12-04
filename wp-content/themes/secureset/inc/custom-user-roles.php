<?php
function add_custom_user_roles() {
	$cm_caps = 	array(

		// Normal news posts caps
		'edit_posts' => true,
		'delete_others_posts' => true,
		'delete_posts' => true,
		'delete_private_posts' => true,
		'delete_published_posts' => true,
		'edit_others_posts' => true,
		'edit_private_posts' => true,
		'edit_published_posts' => true,
		'read_private_posts' => true,
		'publish_posts' => true,

		// Tribe events caps
		'edit_tribe_events' => true,
		'delete_others_tribe_events' => true,
		'delete_tribe_events' => true,
		'delete_private_tribe_events' => true,
		'delete_published_tribe_events' => true,
		'edit_others_tribe_events' => true,
		'edit_private_tribe_events' => true,
		'edit_published_tribe_events' => true,
		'publish_events' => true,

		// Media library caps
		'upload_files' => true,
		'edit_attachments' => true,
		'read_others_attachments' => true,
		'edit_others_attachments' => true,

		// General caps
		'read' => true,
	);

	$result = add_role(
		'community_manager',
		__( 'Community Manager' ),
		$cm_caps
	);
	$cm_role = get_role( 'community_manager' );

	foreach ( $cm_caps as $cap_name => $value ) {
		$cm_role->add_cap( $cap_name );
	}

	$support_caps = array(

		// Normal news posts caps
		'edit_posts' => true,
		'delete_others_posts' => true,
		'delete_posts' => true,
		'delete_private_posts' => true,
		'delete_published_posts' => true,
		'edit_others_posts' => true,
		'edit_private_posts' => true,
		'edit_published_posts' => true,
		'read_private_posts' => true,
		'publish_posts' => false,

		// Tribe events caps
		'edit_tribe_events' => true,
		'delete_others_tribe_events' => true,
		'delete_tribe_events' => true,
		'delete_private_tribe_events' => true,
		'delete_published_tribe_events' => true,
		'edit_others_tribe_events' => true,
		'edit_private_tribe_events' => true,
		'edit_published_tribe_events' => true,
		'publish_events' => false,

		// Program caps
		'edit_program' => true,
		'edit_programs' => true,
		'edit_others_programs' => true,
		'edit_published_programs' => true,
		'publish_programs' => true,
		'read_program' => true,
		'read_private_programs' => true,
		'delete_program' => false,
		'publish_programs' => false,

		// Location caps
		'edit_location' => true,
		'edit_locations' => true,
		'edit_others_locations' => true,
		'edit_published_locations' => true,
		'read_location' => true,
		'edit_others_location' => true,
		'read_private_locations' => true,
		'delete_location' => false,
		'publish_locations' => false,

		// Team Caps
		'edit_team' => true,
		'edit_teams' => true,
		'edit_others_teams' => true,
		'edit_published_teams' => true,
		'read_team' => true,
		'read_private_teams' => true,
		'delete_team' => false,
		'publish_teams' => false,

		// General caps
		'read' => true,
	);
	$result = add_role(
		'support',
		__( 'Support' ),
		$support_caps
	);

	$support_role = get_role( 'support' );

	foreach ( $support_caps as $cap_name => $value ) {
		$support_role->add_cap( $cap_name );
	}
}
add_action( 'admin_init', 'add_custom_user_roles' ,10 );

/**
 * This is a little hacky, but with the edit_posts role, the user
 * is still able to access an empty tool page tab with nothing on the page
 * This function adds css to hide The tab from the WP menu
 */
function load_custom_wp_admin_style( $hook ) {
	$user = wp_get_current_user();

	if ( in_array( 'community_manager', $user->roles ) || in_array( 'support', $user->roles ) ) {
		echo '<style type="text/css">#menu-tools { display: none; }</style>';
	}
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


/**
 * This function rips out category 36 and 35 from the news archive page for the community manager role
 * Also it prevents access to any posts that are in category 35 and/or 36
 */
function restrict_community_manager_from_news_and_press( $query ) {
	global $post;
	$user = wp_get_current_user();
	if ( is_admin() && in_array( 'community_manager', $user->roles ) ) {
		$query->set( 'cat', '-36,-35' );
		if ( in_category( 36, $post->ID ) || in_category( 35, $post->ID ) ) {
			wp_die( 'Unauthorized access');
		}
	}
}
add_action( 'pre_get_posts', 'restrict_community_manager_from_news_and_press' );
