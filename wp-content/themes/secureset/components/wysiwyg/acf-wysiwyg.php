<?php

acf_add_local_component( 'wysiwyg', array(
	'key' => 'group_59f371c77f653',
	'title' => 'wysiwyg',
	'fields' => array(
		array(
			'key' => 'field_59f371d08ade3',
			'label' => 'Wysiwyg',
			'name' => 'wysiwyg',
			'type' => 'wysiwyg',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array (
			'key' => 'field_5a02447770d16',
			'label' => 'Mode',
			'name' => 'mode',
			'type' => 'radio',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'light' => 'Light',
				'dark' => 'Dark',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'light',
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