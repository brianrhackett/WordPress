<?php

acf_add_local_component( 'course-list', array(
	'key' => 'group_bc9041a0f5c32',
	'title' => 'Course List',
	'fields' => array(
		array(
			'key' => 'field_58ed668fe54fe',
			'label' => 'Type',
			'name' => 'type',
			'type' => 'select',
			'required' => 1,
			'choices' => array(
				'free' => 'Free',
				'previews' => 'Paid Previews'
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 0,
	'description' => '',
) );
