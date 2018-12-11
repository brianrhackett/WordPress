<?php
acf_add_local_component( 'table-of-contents',  array(
	'key' => 'group_5a377be5253ea',
	'title' => 'Table of Contents',
	'fields' => array(
		array(
			'key' => 'field_59bdbdfdebf03',
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
		array(
			'key' => 'field_5a039bf6bd4d4',
			'label' => 'Course',
			'name' => 'course',
			'type' => 'number',
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
));
