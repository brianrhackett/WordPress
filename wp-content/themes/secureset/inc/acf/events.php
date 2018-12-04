<?php

// Events landing page field group
acf_add_local_field_group( array(
	'key' => 'group_5a0a126285f84',
	'title' => 'Events Landing Page',
	'fields' => array(
		array(
			'key' => 'field_8495hfuei4n3j',
			'label' => 'Hero Title',
			'name' => 'events_hero',
			'type' => 'clone',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'clone' => array(
				0 => 'group_37ed53c2b9g4a',
			),
			'display' => 'group',
			'layout' => 'block',
			'prefix_label' => 0,
			'prefix_name' => 1,
		),
		array(
			'key' => 'field_9304jfueivnd7',
			'label' => 'Events Page Background',
			'name' => 'events_page_background',
			'type' => 'clone',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'clone' => array(
				0 => 'group_59f787e769993',
			),
			'display' => 'group',
			'layout' => 'block',
			'prefix_label' => 0,
			'prefix_name' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'event-general-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'active' => 1,
	'description' => '',
) );

// Single event field group
acf_add_local_field_group( array(
	'key' => 'group_5a1deaa490f77',
	'title' => 'Custom Event Data',
	'fields' => array(
		array(
			'key' => 'field_9304hfuribnfh',
			'label' => 'Hero Background Image',
			'name' => 'hero_background_image',
			'type' => 'image',
			'value' => NULL,
			'instructions' => 'Image that appears as the background on desktop and mobile if no mobile image is uploaded. For best results the image should be of landscape orientation at least 1800px wide, no more then 2400px wide and at least 400px tall.',
			'required' => 0,
			'wrapper' => array(
				'width' => '40',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '1800',
			'min_height' => '400',
			'min_size' => '',
			'max_width' => '2400',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_940vid83hgu172',
			'label' => 'Hero Mobile Background Image',
			'name' => 'hero_background_image_mobile',
			'type' => 'image',
			'value' => NULL,
			'instructions' => '(optional) Background image when on Mobile. For best results, the image should be portrait oriented and at least 640px wide, no more then 800px wide and at least 400px tall',
			'required' => 0,
			'wrapper' => array(
				'width' => '40',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '640',
			'min_height' => '400',
			'min_size' => '',
			'max_width' => '800',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_9304jfueivnd7',
			'label' => 'Page Background',
			'name' => 'events_details_page_background',
			'type' => 'clone',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'clone' => array(
				0 => 'group_59f787e769993',
			),
			'display' => 'group',
			'layout' => 'block',
			'prefix_label' => 0,
			'prefix_name' => 1,
		),
		array(
			'key' => 'field_d9ej38n3uhts7',
			'label' => 'Online',
			'name' => 'online',
			'type' => 'checkbox',
			'value' => NULL,
			'instructions' => 'Check this box if this is an online course',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'true' => 'Yes',
			),
			'allow_custom' => 0,
			'save_custom' => 0,
			'default_value' => array(),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
		),
		array(
			'key' => 'field_5a1deaa79db3c',
			'label' => 'Location',
			'name' => 'location',
			'type' => 'relationship',
			'value' => NULL,
			'instructions' => 'Select a single location for this event (required)',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'locations',
			),			
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_d9ej38n3uhts7',
						'operator' => '!=',
						'value' => 'true',
					),
				),
			),
			'taxonomy' => array(),
			'filters' => array(),
			'elements' => '',
			'min' => '1',
			'max' => '1',
			'return_format' => 'ID',
		),
		array(
			'key' => 'field_5a202abfb097d',
			'label' => 'Event Level',
			'name' => 'event_level',
			'type' => 'radio',
			'value' => NULL,
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'beginner' => 'Beginner Event',
				'expert' => 'Expert Event',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'beginner',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array(
			'key' => 'field_1029ieorp84n5',
			'label' => 'CTA',
			'name' => 'cta',
			'type' => 'clone',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'clone' => array(
				0 => 'group_2b5d52c1b8g21',
			),
			'display' => 'seamless',
			'layout' => 'block',
			'prefix_label' => 0,
			'prefix_name' => 0,
		),
		array(
			'key' => 'field_2901mdke783kj',
			'label' => 'Hubspot Event List',
			'name' => 'hs_event_list',
			'type' => 'select',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(),
			'default_value' => array(),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 1,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'tribe_events',
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

// Organizer Field Group
acf_add_local_field_group(array (
	'key' => 'group_5a27304d48f8c',
	'title' => 'Additional Fields',
	'fields' => array (
		array (
			'key' => 'field_5a273056782a7',
			'label' => 'Organizer Icon',
			'name' => 'organizer_icon',
			'type' => 'image',
			'value' => NULL,
			'instructions' => 'Must be at least 24px / 24px and at most 150px / 150px',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 24,
			'min_height' => 24,
			'min_size' => '',
			'max_width' => 150,
			'max_height' => 150,
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'tribe_organizer',
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
));

// Add events options page
acf_add_options_page( array(
	'page_title' 	=> 'Event Settings',
	'menu_title'	=> 'Event General Settings',
	'menu_slug' 	=> 'event-general-settings',
	'capability'	=> 'manage_options',
	'redirect'		=> false
) );
