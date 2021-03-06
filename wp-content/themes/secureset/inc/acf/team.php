<?php

acf_add_local_field_group( array(
	'key' => 'group_5a00b7bc3b046',
	'title' => 'Team',
	'fields' => array(
		array(
			'key' => 'field_5a00b7c094737',
			'label' => 'Name',
			'name' => 'name',
			'type' => 'text',
			'value' => NULL,
			'instructions' => 'Name of team member',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a00b7e194738',
			'label' => 'Role',
			'name' => 'role',
			'type' => 'text',
			'value' => NULL,
			'instructions' => 'Role of the team member',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a00b80694739',
			'label' => 'Bio',
			'name' => 'bio',
			'type' => 'textarea',
			'value' => NULL,
			'instructions' => 'Team member biography',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5a00b83a9473a',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'value' => NULL,
			'instructions' => 'Team member profile image.

MUST be EXACTLY 360px Width / 360px Height',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 360,
			'min_height' => 360,
			'min_size' => '',
			'max_width' => 360,
			'max_height' => 360,
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5a00b9409d890',
			'label' => 'Linked In URL',
			'name' => 'linked_in_url',
			'type' => 'url',
			'value' => NULL,
			'instructions' => 'Team members Linked In URL',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5a00b95f9d891',
			'label' => 'Facebook URL',
			'name' => 'facebook_url',
			'type' => 'url',
			'value' => NULL,
			'instructions' => 'Team members Facebook URL',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		)
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'team',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'custom_fields',
		4 => 'discussion',
		5 => 'comments',
		6 => 'revisions',
		7 => 'slug',
		8 => 'author',
		9 => 'format',
		10 => 'page_attributes',
		11 => 'featured_image',
		12 => 'categories',
		13 => 'tags',
		14 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

?>
