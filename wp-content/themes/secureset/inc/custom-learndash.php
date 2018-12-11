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

	$data += [0 => __('-- Select an Instructor --', 'your-plugin-textdomain')];

	foreach ($posts_array as $posts_array) {
	   $data += [$posts_array->ID => $posts_array->post_title];
	}

	$vcoursefield = array(
		'name'=>__('Associated Instructor', 'your-plugin-textdomain'),
		'type'=>'select',
		'initial_options' => $data,
		'help_text'=>__('Select instructor to associate', 'your-plugin-textdomain'),
		'default' => '0'
	);

	$post_args['sfwd-courses']['fields'] = array('course_instructor' => $vcoursefield) + $post_args['sfwd-courses']['fields'];
	return $post_args;
}



register_taxonomy("Instructor Video", array("instructor"));
add_action('admin_init', 'instructor_video');
function instructor_video(){
	add_meta_box("instructor_video", "Instructor Video", "populate_video", "instructor");
	add_meta_box("instructor", "Assign Instructor", "populate_instructors", "product");
}

function populate_instructors(){
	global $post;
	$custom = get_post_custom($post->ID);
	$instructor = $custom["instructor"][0];
	$instructors = get_posts(array(
		'post_type' => 'instructor',
		'post_count' => -1
	));
	echo '<select name="instructor">
			<option>-- Select an Instructor --';
	foreach($instructors as $person){
		echo '<option '.($instructor == $person->ID ? 'selected' : '').' value="'.$person->ID.'">'.$person->post_title.'</option>';
	}
	echo '</select>';
}

function populate_video(){
	global $post;
	$custom = get_post_custom($post->ID);
	$video = $custom["instructor_video"][0];
	echo '<div><label>Paste video embed code here:</label></div>
		<div><input style="font-size:1.25em;line-height:2em;width:100%;" type="text" name="instructor_video" value="'.$video.'" /></div>';
}
add_action('save_post', 'save_video');
function save_video(){
	global $post;
	if(array_key_exists('instructor_video', $_POST))
		update_post_meta($post->ID, "instructor_video", $_POST["instructor_video"]);
}

add_action( 'save_post', 'wc_instructor' );
function wc_instructor($post_id){
    $post_type = get_post_type($post_id);
    if($post_type == 'product'  && array_key_exists('instructor', $_POST)) {
        update_post_meta($post_id,'instructor',$_POST["instructor"]);
    }
}