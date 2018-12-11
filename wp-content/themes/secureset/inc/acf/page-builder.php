<?php

acf_add_local_field_group( array(
	'key' => 'group_5910b44a1431a',
	'title' => 'Page Builder',
	'fields' => array(
		array(
			'key' => 'field_5910b45f434c6',
			'label' => 'Page Builder',
			'name' => 'main_page_builder',
			'type' => 'flexible_content',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'button_label' => 'Add Component',
			'min' => '',
			'max' => '',
			'layouts' => array(
				make_component_layout( array( 'label' => 'Title', 'name' => 'title' ) ),
				make_component_layout( array( 'label' => 'Big Numbers', 'name' => 'big-numbers' ) ),
				make_component_layout( array( 'label' => 'Video Img Grid', 'name' => 'video-img-grid' ) ),
				make_component_layout( array( 'label' => 'Two Column Text', 'name' => 'two-column-text' ) ),
				make_component_layout( array( 'label' => 'Alternator', 'name' => 'alternator' ) ),
				make_component_layout( array( 'label' => 'CTA Stack', 'name' => 'cta-stack' ) ),
				make_component_layout( array( 'label' => 'Three Column Cards', 'name' => 'three-column-cards' ) ),
				make_component_layout( array( 'label' => 'Wysiwyg', 'name' => 'wysiwyg' ) ),
				make_component_layout( array( 'label' => 'Hero', 'name' => 'hero' ) ),
				make_component_layout( array( 'label' => 'Testimonial', 'name' => 'testimonial' ) ),
				make_component_layout( array( 'label' => 'Full Video', 'name' => 'full-vid' ) ),
				make_component_layout( array( 'label' => 'FAQ', 'name' => 'faq' ) ),
				make_component_layout( array( 'label' => 'CTA Grid', 'name' => 'cta-grid' ) ),
				make_component_layout( array( 'label' => 'Team', 'name' => 'team' ) ),
				make_component_layout( array( 'label' => 'Form Stack', 'name' => 'form-stack' ) ),
				make_component_layout( array( 'label' => 'Latest News', 'name' => 'latest-news' ) ),
				make_component_layout( array( 'label' => 'Latest Events', 'name' => 'latest-events' ) ),
				make_component_layout( array( 'label' => 'Short Newsletter Form', 'name' => 'short-newsletter-form' ) ),
				make_component_layout( array( 'label' => 'Location Details', 'name' => 'location-details') ),
				make_component_layout( array( 'label' => 'Latest Programs', 'name' => 'latest-programs' ) ),
				make_component_layout( array( 'label' => 'Workshop', 'name' => 'workshop' ) ),
				make_component_layout( array( 'label' => 'Upcoming Course', 'name' => 'upcoming-course' ) ),
				make_component_layout( array( 'label' => 'Featured Bundle', 'name' => 'bundle' ) ),
				make_component_layout( array( 'label' => 'Bundle Alternator', 'name' => 'bundle-alternator' ) ),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'templates/template-page-builder.php',
			),
		),
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'templates/template-program-landing.php',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'programs',
			),
		),
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'posts_page',
			),
		),
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
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		'the_content'
	),
	'active' => 1,
	'description' => '',
) );
