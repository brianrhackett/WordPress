<?php

acf_add_local_component( 'full-vid', array (
	'key' => 'group_59fc9cf484ea7',
	'title' => 'Full Width Video',
	'fields' => array (
		array (
			'key' => 'field_59fc9d049a607',
			'label' => 'Full Width Video',
			'name' => 'full_width_video',
			'type' => 'oembed',
			'value' => NULL,
			'instructions' => 'Place in the video embed url',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'width' => '',
			'height' => '',
		),
		array(
			'key' => 'field_94nf847tyru32',
			'label' => 'Mobile Image (optional)',
			'name' => 'image_mobile',
			'type' => 'image',
			'value' => NULL,
			'instructions' => 'Image must be >=600px wide, <= 1200px wide and >= 200px tall.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '70',
				'class' => '',
				'id' => '',
			),
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => 600,
			'min_height' => 200,
			'min_size' => '',
			'max_width' => 1200,
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5a5fd6b3cbff9',
			'label' => 'Poster Image (optional',
			'name' => 'poster',
			'type' => 'image',
			'value' => NULL,
			'instructions' => 'If poster image is omitted, the video thumbnail will be used.<br />Image must be >=1200px wide, <= 2400px wide and >= 200px tall.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => 1200,
			'min_height' => 200,
			'min_size' => '',
			'max_width' => 2400,
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
) );

/**

array(
			'key' => 'field_58e36ssceiiii',
			'label' => 'Mobile Image (Optional)',
			'name' => 'image_mobile',
			'type' => 'image',
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '70',
			),
			'preview_size' => 'medium',
			'mime_types' => '',
		),
		array(
			'key' => 'field_58ed66j39fase',
			'label' => 'Poster Image',
			'name' => 'poster',
			'type' => 'image',
			'description' => 'If poster image is ommited, the video thumbnail will be used.',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'medium',
			'mime_types' => '',
			'min_width' => '1200px',
			'min_height' => '200px',
			'max_width' => '1600px'
		),

 *
 */
?>

