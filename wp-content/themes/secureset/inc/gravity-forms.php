<?php

/**
 * Filter the Gravity Forms button type
 *
 */
add_filter( 'gform_submit_button', '__secureset_gravityforms_submit_btn', 10, 2 );
function __secureset_gravityforms_submit_btn( $button, $form ) {
	$btn_text = ( isset( $form['button']['text'] ) && !empty( $form['button']['text'] ) ) ? $form['button']['text'] : 'Submit';
	return '<button type="submit" class="gform_button button btn btn--blue btn--submit" id="' . esc_attr( 'gform_submit_button_' . $form['id'] ) . '"><span class="btn__text">' . esc_attr( $btn_text ) . '</span><span class="icon-right"></span></button>';
}

add_filter( 'gform_confirmation_anchor', '__return_false' );

add_filter( 'gform_confirmation', 'add_wysiwyg_class_to_confirmation_message_wrap', 10, 4 );
function add_wysiwyg_class_to_confirmation_message_wrap( $confirmation, $form, $entry, $ajax ) {
	$confirmation = preg_replace( '/(gform_confirmation_message_[0-9]+)\sgform_confirmation_message/Uis', '$1 gform_confirmation_message wysiwyg', $confirmation);
	return $confirmation;
}

/**
 * Filter Gravity Forms select field display to wrap optgroups where defined
 * USE:
 * set the value of the select option to `optgroup` within the form editor. The
 * filter will then automagically wrap the options following until the start of
 * the next option group
 */
add_filter( 'gform_field_content', 'filter_gf_select_optgroup', 10, 2 );
function filter_gf_select_optgroup( $input, $field ) {
	if ( $field->type == 'select' ) {
		$opt_placeholder_regex = strpos($input,'gf_placeholder') === false ? '' : "<\s*?option.*?class='gf_placeholder'>[^<>]+<\/option\b[^>]*>";
		$opt_regex = "/<\s*?select\b[^>]*>" . $opt_placeholder_regex . "(.*?)<\/select\b[^>]*>/i";
		$opt_group_regex = "/<\s*?option\s*?value='optgroup\b[^>]*>([^<>]+)<\/option\b[^>]*>/i";

		preg_match($opt_regex, $input, $opt_values);
		$split_options = preg_split($opt_group_regex, $opt_values[1]);
		$optgroup_found = count($split_options) > 1;

		// sometimes first item in the split is blank
		if( strlen($split_options[0]) < 1 ){
			unset($split_options[0]);
			$split_options = array_values( $split_options );
		}

		if( $optgroup_found ){
			$fixed_options = '';
			preg_match_all($opt_group_regex, $opt_values[1], $opt_group_match);
			if( count($opt_group_match) > 1 ){
				foreach( $split_options as $index => $option ){
					$fixed_options .= "<optgroup label='" . $opt_group_match[1][$index] . "'>" . $option . '</optgroup>';
				}
			}
			$input = str_replace($opt_values[1], $fixed_options, $input);
		}
	}

	return $input;
}


/**
 * Update progress bar percentage markup
 */
add_filter( 'gform_progress_bar', 'custom_progress_bar', 10, 3 );
function custom_progress_bar( $progress_bar, $form, $confirmation_message ) {
	$progress_bar = preg_replace( '/(<div\sclass\=\'gf_progressbar_percentage.*>)(<span>.*<\/span>)(<\/div>)/Uis', '$1$3$2', $progress_bar );
	return $progress_bar;
}


/**
 * Allow protocol free for website field types
 * @url https://www.itsupportguides.com/knowledge-base/gravity-forms/gravity-forms-how-to-automatically-add-http-to-submitted-website-field-values-before-validation/
 */
add_filter( 'gform_pre_render', 'itsg_check_website_field_value' );
add_filter( 'gform_pre_validation', 'itsg_check_website_field_value' );
function itsg_check_website_field_value( $form ) {
	foreach ( $form['fields'] as &$field ) {  // for all form fields
		if ( 'website' == $field['type'] || ( isset( $field['inputType'] ) && 'website' == $field['inputType']) ) {  // select the fields that are 'website' type
			$value = RGFormsModel::get_field_value($field);  // get the value of the field
			if (! empty($value) ) { // if value not empty
				$field_id = $field['id'];  // get the field id
				if (! preg_match("~^(?:f|ht)tps?://~i", $value) ) {  // if value does not start with ftp:// http:// or https://
					$value = "http://" . $value;  // add http:// to start of value
				}

				$_POST['input_' . $field_id] = $value; // update post with new value
			}
		}
	}
	return $form;
}

add_filter( 'gform_field_content', 'add_html5_extension_validation', 10, 5 );
function add_html5_extension_validation( $content, $field, $value, $lead_id, $form_id ) {
	if ( $field['type'] === 'fileupload' ) {
		$allowed_extensions = explode( ',', $field['allowedExtensions'] );
		if ( $allowed_extensions ) {
			$allowed_ext_attr = '';
			foreach ( $allowed_extensions as $key => $ext ) {
				$ext = trim( $ext );
				if ( $key === 0 ) {
					$allowed_ext_attr .= '.' . $ext;
				} else {
					$allowed_ext_attr .= ', .' . $ext;
				}
				
			}
			$content = str_replace( 'type=\'file\'', 'type=\'file\' accept="' . $allowed_ext_attr . '"', $content );
		}
	}
	return $content;
}
