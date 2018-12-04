<?php
function register_programs() {

	// Register programs CPT
	register_post_type( 'programs',
		array(
			'labels' => array(
				'name' => __( 'Programs', '__secureset' ),
				'singular_name' => __( 'Program', '__secureset' )
			),
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-welcome-learn-more',
			'capability_type' => 'program',
			'exclude_from_search' => true
		)
	);

	// Register program_types taxonomy
	register_taxonomy(
		'program_types',
		'programs',
		array(
			'label' => __( 'Program Types' ),
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		)
	);

	// Register courses taxonomy
	register_taxonomy(
		'courses',
		'programs',
		array(
			'label' => __( 'Courses' ),
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		)
	);

	// Register cohorts taxonomy
	register_taxonomy(
		'cohorts',
		'programs',
		array(
			'label' => __( 'Cohorts' ),
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		)
	);

	$admins = get_role( 'administrator' );
	$admins->add_cap( 'edit_program' );
	$admins->add_cap( 'edit_programs' );
	$admins->add_cap( 'edit_others_programs' );
	$admins->add_cap( 'edit_published_programs' );
	$admins->add_cap( 'publish_programs' );
	$admins->add_cap( 'read_program' );
	$admins->add_cap( 'read_private_programs' );
	$admins->add_cap( 'delete_program' );
}
add_action( 'init', 'register_programs' );

/**
 * Removes/hides taxonomy boxes from the programs edit page *
 */
function __secureset_remove_meta_boxes() {
	remove_meta_box( 'tagsdiv-program_types', 'programs', 'normal' );
	remove_meta_box( 'tagsdiv-courses', 'programs', 'normal' );
	remove_meta_box( 'tagsdiv-cohorts', 'programs', 'normal' );
}
add_action( 'admin_menu', '__secureset_remove_meta_boxes' );

// Update the columns for programs
function remove_program_columns( $columns ) {
	unset(
		$columns['taxonomy-program_types'],
		$columns['taxonomy-courses'],
		$columns['taxonomy-cohorts']
	);
	$columns['program_type'] = 'Program Type';
	$columns['cohort'] = 'Cohort';
	$columns['location'] = 'Location';
	return $columns;
}

add_filter( 'manage_programs_posts_columns', 'remove_program_columns' );

// Add new columns to the programs post type
function add_program_column( $column, $post_id ) {

	switch ( $column ) {
		case 'program_type':
			echo get_term( get_field( 'program_type', $post_id ) )->name;
			break;

		case 'cohort':
			echo get_term( get_field( 'cohort', $post_id ) )->name;
			break;

		case 'location':
			echo get_field( 'location', $post_id )->post_title;
			break;
	}

}
add_action( 'manage_programs_posts_custom_column', 'add_program_column', 10, 2  );

// Make the custom columns sortable
function make_program_columns_sortable( $columns ) {
	$columns['program_type'] = 'program_type';
	$columns['cohort'] = 'cohort';
	$columns['location'] = 'location';
	return $columns;
}
add_filter( 'manage_edit-programs_sortable_columns', 'make_program_columns_sortable' );

function programs_custom_orderby( $query ) {
	if ( !is_admin() ) {
		return;
	}

	$orderby = $query->get( 'orderby');
	switch ( $orderby ) {
		case 'program_type':
			$query->set( 'meta_key', 'program_type' );
			$query->set( 'orderby', 'meta_value_num' );
			break;

		case 'cohort':
			$query->set( 'meta_key', 'cohort' );
			$query->set( 'orderby', 'meta_value_num' );
			break;

		case 'location':
			$query->set( 'meta_key', 'location' );
			$query->set( 'orderby', 'meta_value_num' );
			break;
	}
}
add_action( 'pre_get_posts', 'programs_custom_orderby' );


// Adjust GA for just the program landing page to work with the hash URLs
add_action( 'wp_head', 'ck_page_tmpl', 1 );
function ck_page_tmpl() {
	global $GA_Google_Analytics;

	if ( ! is_page_template( 'templates/template-program-landing.php' ) || $GA_Google_Analytics === NULL ) {
		return;
	}

	$options = get_option('gap_options', $GA_Google_Analytics->default_options());

	$tracking_id = (isset($options['gap_id']) && !empty($options['gap_id'])) ? $options['gap_id'] : '';

	if ( has_action( 'wp_head', 'ga_google_analytics_tracking_code' ) ) {
		remove_action('wp_head', 'ga_google_analytics_tracking_code' );
	}

	if ( has_action( 'wp_footer', 'ga_google_analytics_tracking_code' ) ) {
		remove_action('wp_footer', 'ga_google_analytics_tracking_code' );
	}

	?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $tracking_id; ?>', 'auto');
		</script>

	<?php
}
