<?php

acf_add_local_component( 'media-helper', array(
	'key' => 'group_58ed63c939m69',
	'title' => 'Media Helper',
	'fields' => array(
		array(
			'key' => 'field_58ed668fe03ak',
			'label' => 'Media Type',
			'name' => 'type',
			'type' => 'select',
			'required' => 1,
			'choices' => array(
				'image' => 'Image',
				'video_link' => 'Video Link',
			),
			'default_value' => array(
				0 => 'image',
			),
		),
		array(
			'key' => 'field_58e36ssce02cb',
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58ed668fe03ak',
						'operator' => '==',
						'value' => 'image',
					),
				),
			),
			'wrapper' => array(
				'width' => '70',
			),
			'preview_size' => 'medium',
			'mime_types' => '',
		),
		array(
			'key' => 'field_58e36ssce02cc',
			'label' => 'Mobile Image (Optional)',
			'name' => 'image_mobile',
			'type' => 'image',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58ed668fe03ak',
						'operator' => '==',
						'value' => 'image',
					),
				),
			),
			'wrapper' => array(
				'width' => '70',
			),
			'preview_size' => 'medium',
			'mime_types' => '',
		),
		array(
			'key' => 'field_58ed66j394han',
			'label' => 'Poster Image',
			'name' => 'poster',
			'type' => 'image',
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
			'preview_size' => 'medium',
			'mime_types' => '',
		),
		array(
			'key' => 'field_58ed66f10fIn3',
			'label' => 'Video Link',
			'name' => 'oembed_video',
			'instruction' => 'Paste in the URL for the requested video from most major video platforms.',
			'type' => 'oembed',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58ed668fe03ak',
						'operator' => '==',
						'value' => 'video_link',
					),
				)
			)
		),
		array(
			'key' => 'field_58ed66f19fHi09',
			'label' => 'Video File: MP4 (.mp4)',
			'name' => 'mp4_video_file',
			'instruction' => 'Select an mp4 video file from the media library.',
			'type' => 'file',
			'mime_types' => '.mp4',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58ed668fe03ak',
						'operator' => '==',
						'value' => 'video_file',
					),
				)
			)
		),
		array(
			'key' => 'field_58ed66f100Inv3',
			'label' => 'Video File: WebM (.webm)',
			'name' => 'webm_video_file',
			'instruction' => 'Select a webm video as a fallback for MP4. (ie webm will be used if the browser does not support mp4)',
			'type' => 'file',
			'mime_types' => '.webm',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_58ed668fe03ak',
						'operator' => '==',
						'value' => 'video_file',
					),
				)
			)
		)
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 0,
	'description' => '',
));
