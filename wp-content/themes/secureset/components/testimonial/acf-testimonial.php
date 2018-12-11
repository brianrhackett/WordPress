<?php

acf_add_local_component( 'testimonial', array(
	'key' => 'group_5a008c481cb61',
	'title' => 'Testimonial',
	'fields' => array(
		array(
			'key' => 'field_5a008cb681027',
			'label' => 'Testimonial Item',
			'name' => 'testimonial_item',
			'type' => 'repeater',
			'value' => NULL,
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 1,
			'max' => 3,
			'layout' => 'table',
			'button_label' => 'Add Testimonial',
			'sub_fields' => array(
				array(
					'key' => 'field_5a008c4f81026',
					'label' => 'Quote Text',
					'name' => 'quote_text',
					'type' => 'textarea',
					'value' => NULL,
					'instructions' => 'Enter the quote for the testimonial',
					'required' => 1,
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
					'key' => 'field_5a008d1181028',
					'label' => 'Subject Name',
					'name' => 'subject_name',
					'type' => 'text',
					'value' => NULL,
					'instructions' => 'Fill in the name of the person being quoted',
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
					'key' => 'field_5a008da581029',
					'label' => 'Subject Image',
					'name' => 'subject_image',
					'type' => 'image',
					'value' => NULL,
					'instructions' => 'Include image that is ideally square and over 100x100px',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'array',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
		),
		array(
			'key' => 'field_93jv829391kdi',
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
	'location' => array(),
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