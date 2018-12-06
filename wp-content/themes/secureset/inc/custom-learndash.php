<?php
add_action('admin_menu', 'wdm_add_instructor_post_type');

function wdm_add_instructor_post_type(){
	$labels = array(
		'name'               => _x('Instructors', 'post type general name', 'your-plugin-textdomain'),
		'singular_name'      => _x('Instructor', 'post type singular name', 'your-plugin-textdomain'),
		'menu_name'          => _x('Instructors', 'admin menu', 'your-plugin-textdomain'),
		'name_admin_bar'     => _x('Instructor', 'add new on admin bar', 'your-plugin-textdomain'),
		'add_new'            => _x('Add New', 'instructor', 'your-plugin-textdomain'),
		'add_new_item'       => __('Add New Instructor', 'your-plugin-textdomain'),
		'new_item'           => __('New Instructor', 'your-plugin-textdomain'),
		'edit_item'          => __('Edit Instructor', 'your-plugin-textdomain'),
		'view_item'          => __('View Instructor', 'your-plugin-textdomain'),
		'all_items'          => __('All Instructors', 'your-plugin-textdomain'),
		'search_items'       => __('Search Instructors', 'your-plugin-textdomain'),
		'parent_item_colon'  => __('Parent Instructors:', 'your-plugin-textdomain'),
		'not_found'          => __('No instructors found.', 'your-plugin-textdomain'),
		'not_found_in_trash' => __('No instructors found in Trash.', 'your-plugin-textdomain'),
   );

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'section' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type('instructor', $args);
	add_submenu_page('learndash-lms', __('Instructor', 'your-plugin-textdomain'), 'Instructor', 'edit_courses', 'edit.php?post_type=instructor');
}

add_filter('learndash_submenu', 'wdm_add_submenu_lms', 10, 1);
function wdm_add_submenu_lms($addsubmenu){
	remove_menu_page('edit.php?post_type=instructor');
	return $addsubmenu;
}

add_filter('learndash_post_args', 'wdm_add_associate_instructor_field', 10, 1);
function wdm_add_associate_instructor_field($post_args){
	//Adding hierarchy in learndash
	
	$data = array();

	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'instructor',
		'post_status'      => 'publish'
	);

	$posts_array = get_posts($args);

	$data += ['0' => __('-- Select an Instructor --', 'your-plugin-textdomain')];

	foreach ($posts_array as $posts_array) {
	   $data += [$posts_array->ID => $posts_array->post_title];
	}

	$vcoursefield = array(
		'name'=>__('Associated Instructor', 'your-plugin-textdomain'),
		'type'=>'select',
		'initial_options' =>$data,
		'help_text'=>__('Select instructor to associate', 'your-plugin-textdomain'),
		'default' => '0'
	);
//die('<pre>'.print_r($post_args,1));
	array_unshift($post_args['sfwd-courses']['fields'], $vcoursefield);
//	array_unshift($post_args[1]['fields'], $vcoursefield);
//	array_unshift($post_args[3]['fields'], $vcoursefield);
//	array_unshift($post_args[2]['fields'], $vcoursefield);

	return $post_args;
}