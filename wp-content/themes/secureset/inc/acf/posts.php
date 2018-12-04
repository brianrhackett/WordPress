<?php

acf_add_local_field_group( array(
	'key' => 'group_d49vfu49302iv',
	'title' => __( 'Additional Data', '__secureset' ),
	'fields' => array(
		array(
			'key' => 'field_94857yruei3o2',
			'label' => 'Featured',
			'name' => 'featured',
			'type' => 'true_false',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
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

?>
