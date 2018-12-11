<?php
acf_add_local_component( 'bundle', array(
	'key' => 'group_59f76971ae756',
	'title' => 'Featured Bundle',
	'fields' => array(
		array(
			'key' => 'field_58ed668fe45ba',
			'label' => 'Bundle',
			'name' => 'bundle',
			'type' => 'select',
			'required' => 1,
			'choices' => get_bundles(),
		),
		array(
			'key' => 'field_59f76b4c5a6db',
			'label' => 'Mode',
			'name' => 'mode',
			'type' => 'radio',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'light' => 'Light',
				'dark' => 'Dark',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'dark',
			'layout' => 'vertical',
			'return_format' => 'value',
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

