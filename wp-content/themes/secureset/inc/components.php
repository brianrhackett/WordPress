<?php
/**
 * @internal
 *
 * Internal method to safely include a component template with only the provided
 * variables accessible by the component.
 */
function __include_component( $component, $fields ) {
	include( get_template_directory() . '/components/' . $component . '/' . $component . '.php' );
}

/**
 * @internal
 *
 * Filter to inject have_rows compatible values, while maintaining normal ACF
 * functionality. have_rows considers a field as valid so long as the value is
 * an array with [0] defined. Since a clone field returns an array anyway, the
 * value can be tacked on to the existing clone value. This way, other values
 * are still available via the normal clone field value.
 */
function __clone_value( $value, $post_id, $field ) {
	// Non-Intrusive have_rows Compatible Injection
	if ( is_array( $value ) ) {
		$value[0] = $value;
	}
	return $value;
}
add_filter( "acf/load_value/type=clone", '__clone_value', 100, 3 );

/**
 * @internal
 * @todo Double check that these keys work in ALL instances
 *
 * Filter to allow get_sub_field to work underneath a clone field. Unlike ACF
 * however, the selector is also compared against _name which is the untransformed
 * name of each sub_field.
 */
function __clone_sub_field( $sub_field, $selector, $field ) {
	if( empty( $field['sub_fields'] ) ) return false;
	foreach ( $field['sub_fields'] as $sub_field ) {
		// Check against original values. Nothing else should ever get used.
		if( $sub_field['key'] == $selector || $sub_field['__key'] == $selector || $sub_field['__name'] == $selector ) {
			return $sub_field;
		}
	}
	return false;
}
add_filter( "acf/get_sub_field/type=clone", '__clone_sub_field', 10, 3 );

/**
 * @param $component 	name of the component
 * @param $fields 		fields for the component instance or the ACF clone field name
 *
 * Includes a component on a page using an array or ACF field name as context.
 * When $fields is a string, it is assumed to be an ACF field name. If the field
 * is found and it is verified to be a clone field, a new "row" is started, allowing
 * all the sub fields of the clone to be accessed via get_sub_field, the_sub_field, etc.
 * If $fields is not a string, no ACF field is loaded and the template is loaded.
 */
function get_component( $component, $fields = NULL ) {

	// Allow single argument inclusion
	if ( $fields === NULL ) $fields = $component;

	// Prepare context if $fields is a string ( ACF Field Name )
	if ( is_string( $fields ) && class_exists( 'acf' ) ) {
		// Retrieve field object
		$obj = get_sub_field_object( $fields );

		$obj = ( $obj === false ) ? get_field_object( $fields ) : $obj;
		if ( $obj !== false ) {

			// Validate object type
			if ( $obj['type'] !== 'clone' ) return; // Abort
			// Initiate Row Using Key ( Name Is Not Always Correct Here )
			if ( !have_rows( $obj['key'] ) ) return; // Abort
			the_row();
			// Refill $fields with data
			$fields = $obj['value'];
			unset( $fields[0] ); // Remove hacked data
		} else {
			unset( $obj );
		}
	}

	// Load the component template
	__include_component( $component, $fields );

	if ( isset( $obj ) ) {
		while( have_rows( $obj['key'] ) ) {
			the_row();
		}
	}
}

/**
 * @todo Maybe allow more components per layout?
 * @param $page_builder 	ACF flexible content field name
 *
 * Includes all components as dictated by the provided ACF flexible content field.
 */
function get_page_builder( $page_builder ) {

	if ( is_string( $page_builder ) && class_exists( 'acf' ) ) {
		// Retrieve field object
		$obj = get_sub_field_object( $page_builder );

		$obj = ( $obj === false ) ? get_field_object( $page_builder ) : $obj;

		if ( $obj['type'] !== 'flexible_content' ) return; // Abort

		// Print Page Components
		$count = 0;
		while ( have_rows( $page_builder ) ) {

			the_row();
			$fields = get_fields()[$page_builder][$count];
			get_component( get_row_layout(), $fields );
			$count++;
		}
	}
}

/**
 * @param $layout 	A standard ACF layout description where 'name' is the name of a component
 *                  array( 'label' => <Layout Label>, 'name' => <Component Name>, [ 'min' => <Number>, 'max' => <Number> ], ... ),
 *
 * Generates an ACF compatible layout to be included in the 'layouts' field of a
 * flexible-content field. Any components that are used must have been created
 * with the acf_add_local_component function.
 *
 */
function make_component_layout( $layout ) {

	global $acf_components;

	if ( is_array( $layout ) ) {
		if ( isset( $layout['name'] ) && isset( $acf_components[ $layout['name'] ] ) ) {

			$layout['key'] = md5( $layout['name'] );
			$layout['sub_fields'] = array(
				array (
					'key' => md5( $layout['name'] . '-clone' ),
					'name' => $layout['name'] . '-clone',
					'type' => 'clone',
					'clone' => array (
						0 => $acf_components[ $layout['name'] ],
					),
					'display' => 'seamless',
					'layout' => 'block',
				),
			);
			return $layout;
		}
	}
	return NULL;
}

/**
 * @param $component_name	The name of the component
 * @param $field_group 		A standard ACF field group declaration to transform into a component
 *
 * Near drop in replacement for acf_add_local_field_group that builds a componentized
 * field group instead of a normal one.
 */
function acf_add_local_component( $component_name, $field_group ) {
	global $acf_components;

	// Remove location if provided
	$location = null;
	if ( isset( $field_group['location'] ) ) {
		$location = $field_group['location'];
		unset( $field_group['location'] );
	}

	// Force the field group to be locationless.
	$field_group['active'] = false;

	// Create Field Group
	$acf_components[ $component_name ] = $field_group['key'];
	acf_add_local_field_group( $field_group );

	// Create clone fields for others locations
	if ( isset( $location ) ) {

		// Redefine to create clone field
		$field_group['fields'] = array (
			array (
				'clone' => array(
					0 => $field_group['key']
				),
				'prefix_name' => 1,
				'display' => 'seamless',
				'layout' => 'block',
				'key' => $field_group['key'] . '_clone',
				'name' => $component_name,
				'label' => $field_group['title'],
				'type' => 'clone',
				'required' => 0
			),
		);
		$field_group['key'] = 'c_' . $field_group['key'];
		$field_group['location'] = $location;
		unset( $field_group['active'] );
		acf_add_local_field_group( $field_group );
	}
}

add_action( 'init', 'include_component_functions' );
function include_component_functions() {
	$component_directory = get_template_directory() . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR;
	$folder_list = scandir( $component_directory );
	foreach ( $folder_list as $folder ) {
		if ( $folder == '..' || $folder == '.' ) {
			continue;
		}
		$component_functions_file = $component_directory . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'functions.php';
		if ( file_exists( $component_functions_file ) ) {
			include $component_functions_file;
		}
	}
}
