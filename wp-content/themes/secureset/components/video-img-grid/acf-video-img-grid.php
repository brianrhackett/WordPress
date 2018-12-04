<?php
acf_add_local_component( 'video-img-grid', array(
	'key' => 'group_59f8987a87f3a',
	'title' => 'Video Image Grid',
	'fields' => array(
		array(
			'key' => 'field_839f8dney212j',
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
			'key' => 'field_59f8a354bf6bc',
			'label' => 'Video Image Row',
			'name' => 'video-img-row',
			'type' => 'repeater',
			'value' => NULL,
			'instructions' => 'Add a row of images or videos',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_59f89968bf6af',
					'label' => 'Video Image Cell',
					'name' => 'video-img-cell',
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
					'layout' => 'row',
					'button_label' => 'Add Cell',
					'sub_fields' => array(
						array(
							'key' => 'field_59f8a9e19a9c5',
							'label' => 'Video Img Cell Media',
							'name' => 'video-img-cell-media',
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
								0 => 'group_58ed63c939m69',
							),
							'display' => 'seamless',
							'layout' => 'block',
							'prefix_label' => 0,
							'prefix_name' => 0,
						),
						array(
							'key' => 'field_59f8a286bf6b9',
							'label' => 'Video Cell Title',
							'name' => 'video-cell-title',
							'type' => 'text',
							'value' => NULL,
							'instructions' => 'Title of image or video',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_58ed668fe03ak',
										'operator' => '==',
										'value' => 'video_link',
									)
								),
								array(
									array(
										'field' => 'field_58ed668fe03ak',
										'operator' => '==',
										'value' => 'video_file',
									),
								)
							),
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
							'key' => 'field_59f8a9c19a9c4',
							'label' => 'Video Cell Description',
							'name' => 'video-cell-description',
							'type' => 'text',
							'value' => NULL,
							'instructions' => 'Description of Image',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_58ed668fe03ak',
										'operator' => '==',
										'value' => 'video_link',
									)
								),
								array(
									array(
										'field' => 'field_58ed668fe03ak',
										'operator' => '==',
										'value' => 'video_file',
									),
								)
							),
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
					),
				),
			),
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
