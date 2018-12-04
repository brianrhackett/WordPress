<?php

/**
 * Salesforce integration class
 * Highly customized for Secureset
 * Sends application data to salesforce
 *
 */
class SS_GFSalesforce_Integration {

	/**
	 * The following constants are based on the form
	 * fields and are subject to change
	 */
	private $application_form_id;
	const COHORT_FIELD_ID = 81;
	const CAMPUS_FIELD_ID = 18;
	const FILE_UPLOAD_FIELD_ID = 59;
	const DEFAULT_CAMPUS_OPTION_TEXT = 'Please select a Campus';
	const DEFAULT_COHORT_OPTION_TEXT = 'Please select a Cohort';

	public $salesforce_date_fields = array(
		'Date_of_Birth__c',
		'Seperation_Date__c',
		'Secret_Exp_Date__c',
		'TS_SCI_Exp_Date__c',
		'Clearance_Expiration_Date__c'
	);

	/**
	 * Api variable
	 */
	private static $_api;

	public static function get_api() {
		if( ! empty( self::$_api ) ) {
			return self::$_api;
		}
		self::$_api = GFSalesforce::get_api();
		return self::$_api;
	}

	public function __construct() {
		$this->application_form_id = (int)get_field( 'gf_sf_form_id', 'options' );

		// Add filters
		add_filter( 'gform_validation', array( $this, 'salesforce_date_validation' ) );
		add_filter( 'gform_field_content', array( $this, 'populate_cohort_and_campus' ), 10, 5 );
		add_filter( 'gf_salesforce_create_data', array( $this, 'format_multi_selects_before_send' ), 10, 1 );
		add_filter( 'gf_salesforce_create_data', array( $this, 'upsert_on_gravity_form_id' ), 11, 1 );
		add_filter( 'gf_salesforce_create_data', array( $this, 'format_salesforce_date' ), 12, 3 );

		// Add actions
		add_action( 'gform_after_submission', array( $this, 'gf_make_entry_global' ), 10, 2 );
		add_action( 'gform_after_submission', array( $this, 'expire_gfdp_cookie' ), 11, 2 );
		add_action( 'gravityforms_salesforce_object_added_updated', array( $this, 'upload_file_to_salesforce' ), 10, 3 );
		add_action( 'gform_post_paging', array( $this, 'sf_app_start' ), 10, 3 );
	}

	public function format_salesforce_date( $merge_vars, $form, $entry, $feed, $api ) {
		if ( (int)$form['id'] !== $this->application_form_id ) {
			return $merge_vars;
		}

		foreach ( $merge_vars as $key => &$merge_var ) {

			if ( ! in_array( $key, $this->salesforce_date_fields ) ) {
				continue;
			}

			$date_arr = explode( '/', $merge_var );

			// check if date and format it if so
			if ( count( $date_arr ) === 3 ) {
				$merge_var = date( 'Y-m-d', strtotime(  $merge_var ) );
			}
		}
		return $merge_vars;
	}

	/**
	 * Add additional date validation for salesforce dates
	 */
	public function salesforce_date_validation( $validation_result ) {
		$current_page = $validation_result['failed_validation_page'];
		$form = $validation_result['form'];
		$invalid_date_message = __( 'Invalid date format', '__secureset' );
		foreach ( $form['fields'] as &$field ) {

			// Check if the field has salesforce-date class and validate against salesforce date validation rules if so
			if (
				strpos( $field['cssClass'], 'salesforce-date' ) !== false &&
				@$field['is_field_hidden'] !== true &&
				(int)$field['pageNumber'] === (int)$current_page

			) {

				$field_value = rgpost( 'input_' . $field['id'] );

				$field_value_arr = explode( '/', $field_value );

				// If the field is empty and not required
				if ( $field_value === '' && $field['isRequired'] !== 1 ) {
					continue;
				}

				if ( count( $field_value_arr ) !== 3 ) {
					$validation_result['is_valid'] = false;
					$field->failed_validation = true;
					$field->validation_message = $invalid_date_message;
					continue;
				}

				if ( checkdate( $field_value_arr[0], $field_value_arr[1], $field_value_arr[2] ) !== true ) {
					$validation_result['is_valid'] = false;
					$field->failed_validation = true;
					$field->validation_message = $invalid_date_message;
					continue;
				}

				if ( $field_value_arr[2] < 1700 ) {
					$validation_result['is_valid'] = false;
					$field->failed_validation = true;
					$field->validation_message = $invalid_date_message;
					continue;
				}
			}
		}
		$validation_result['form'] = $form;
		return $validation_result;
	}

	/**
	 * Send the attachment to salesforce after the salesforce record has been created
	 */
	public function upload_file_to_salesforce( $Account, $feed, $result_id ) {

		// Grab the global var from gf_make_entry_global
		global $sf_gf_entry;

		$form_id = (int)$_POST['gform_submit'];
		if ( (int)$form_id === $this->application_form_id && $sf_gf_entry[self::FILE_UPLOAD_FIELD_ID] ) {
			$sf_resume_url = gform_get_meta( $sf_gf_entry['id'], self::FILE_UPLOAD_FIELD_ID );
			if ( $sf_resume_url ) {
				$upload_path = GFFormsModel::get_upload_path( $form_id );
				$upload_url = GFFormsModel::get_upload_url( $form_id );
				$sf_resume_file_name = end( explode( '/', $sf_resume_url ) );
				$sf_resume_file_path = str_replace( $upload_url, $upload_path, $sf_resume_url );
				$handle = fopen( $sf_resume_file_path, 'rb' );
				$sf_file_content = fread( $handle, filesize( $sf_resume_file_path ) );
				fclose( $handle );
				$sf_file_encoded = chunk_split( base64_encode( $sf_file_content ) );
				$sf_cv_object = new stdclass();
				$sf_cv_object->type = 'ContentVersion';
				$sf_cv_object->fields = array();
				$sf_cv_object->fields['PathOnClient'] = $sf_resume_file_path;
				$sf_cv_object->fields['Title'] = $sf_resume_file_name;
				$sf_cv_object->fields['VersionData'] = $sf_file_encoded;
				$sf_cv_object->fields['Description'] = $sf_resume_url;
				$sf_cv_object->fields['FirstPublishLocationId'] = $result_id;
				$api_response = self::get_api()->create( array( $sf_cv_object ) );
			}
		}
	}

	/**
	 * Sets a global variable to pass into upload_file_to_salesforce
	 */
	public function gf_make_entry_global( $entry, $form ) {
		if ( (int)$form['id'] !== $this->application_form_id ) {
			return;
		}
		global $sf_gf_entry;
		$sf_gf_entry = $entry;
	}

	public function expire_gfdp_cookie( $entry, $form ) {
		if ( isset( $_COOKIE['gfdp'] ) ) {
			unset( $_COOKIE['gfdp'] );
			setcookie( 'gfdp', null, -1, COOKIEPATH, COOKIE_DOMAIN, false );
		}
	}

	/**
	 * Query salesforce to get values for the Cohort field
	 */
	public function populate_cohort_and_campus( $field_content, $field, $value, $lead_id, $form_id ) {
		if ( (int)$form_id !== $this->application_form_id ) {
			return $field_content;
		}
		$api = self::get_api();
		if ( ! $api ) {
			return $field_content;
		}
		$current_page = rgpost( 'gform_source_page_number_' . $form_id ) ? rgpost( 'gform_source_page_number_' . $form_id ) : 1;

		// Only run this function is this form is the application form
		if ( (int)$form_id !== $this->application_form_id ) {
			return $field_content;
		}

		// Rip out all <option> tags from both campus and cohort dropdowns
		if ( $field->id === self::CAMPUS_FIELD_ID || $field->id === self::COHORT_FIELD_ID ) {
			$field_content = preg_replace( '/<option.*<\/option>/Uis', '', $field_content );
		}

		// Check for the campus field
		if ( $field->id === self::CAMPUS_FIELD_ID ) {
			$options = null;
			$campus_list = $api->query( "SELECT Id, Name, City__c, Active_Campus__c FROM Campus__c" );

			$selected_campus_value = rgpost( 'input_' . self::CAMPUS_FIELD_ID );
			$has_selected = false;

			foreach ( $campus_list->records as $campus ) {
				if ( ! preg_match( '/<sf\:city__c>(.*)<\/sf\:city__c>/Uis', $campus->any, $campus_city ) ) {
					continue;
				}

				if ( ! preg_match( '/<sf\:active_campus__c>(.*)<\/sf\:active_campus__c>/Uis', $campus->any, $campus_active ) ) {
					continue;
				}

				if ( $campus_active[1] === 'false' ) {
					continue;
				}

				$campus_city = $campus_city[1];
				$campus_id = $campus->Id[1];
				if ( $selected_campus_value === $campus_id ) {
					$has_selected = true;
					$options .= '<option selected="selected" value="' . $campus_id . '">' . $campus_city . '</option>' . "\r\n";
				} else {
					$options .= '<option value="' . $campus_id . '">' . $campus_city . '</option>' . "\r\n";
				}
			}

			if ( $has_selected ) {
				$placeholder_option = '<option value="">' . self::DEFAULT_CAMPUS_OPTION_TEXT . '</option>';
			} else {
				$placeholder_option = '<option value="" selected="selected">' . self::DEFAULT_CAMPUS_OPTION_TEXT . '</option>';
			}

			$field_content = str_replace( '</select>', $placeholder_option . $options . '</select>', $field_content );
			return $field_content;
		}

		// Check for the cohort field
		if ( $field->id === self::COHORT_FIELD_ID ) {

			$options = null;
			$json_array = array();
			$cohorts = $api->query( "SELECT Id, Campus__c, Name, Program_Type__c, Start_Date__c, SS_Form_Label__c FROM Cohort__c" );

			$selected_cohort_value = rgpost( 'input_' . self::COHORT_FIELD_ID );
			$has_selected = false;

			foreach ( $cohorts->records as $cohort ) {

				if ( ! preg_match( '/<sf\:ss_form_label__c>(.*)<\/sf\:ss_form_label__c>/Uis', $cohort->any, $cohort_label ) ) {
					continue;
				}

				if ( ! preg_match( '/<sf\:start_date__c>(.*)<\/sf\:start_date__c>/Uis', $cohort->any, $cohort_start_date ) ) {
					continue;
				}

				if ( ! preg_match( '/<sf\:program_type__c>(.*)<\/sf\:program_type__c>/Uis', $cohort->any, $cohort_program ) ) {
					continue;
				}

				if ( ! preg_match( '/<sf\:name>(.*)<\/sf\:name>/Uis', $cohort->any, $cohort_name ) ) {
					continue;
				}

				if ( ! preg_match( '/<sf\:campus__c>(.*)<\/sf\:campus__c>/Uis', $cohort->any, $campus_id ) ) {
					continue;
				}

				$cohort = array(
					'program_name' => $cohort_program[1],
					'id' => $cohort->Id[0],
					'name' => $cohort_name[1],
					'campus_id' => $campus_id[1],
					'start_date' => $cohort_start_date[1],
					'label' => $cohort_label[1]
				);

				if ( $selected_cohort_value === $cohort['id'] ) {
					$has_selected = true;
					$options .= '<option selected="selected" value="' . $cohort['id'] . '">' . $cohort['label'] . '</option>' . "\r\n";
				} else {
					$options .= '<option value="' . $cohort['id'] . '">' . $cohort['label'] . '</option>' . "\r\n";
				}

				$json_array[] = $cohort;
			}

			if ( $has_selected ) {
				$placeholder_option = '<option value="">' . self::DEFAULT_COHORT_OPTION_TEXT . '</option>';
			} else {
				$placeholder_option = '<option value="" selected="selected">' . self::DEFAULT_COHORT_OPTION_TEXT . '</option>';
			}

			$field_content = str_replace( '<select', '<select data-default-option-text="' . self::DEFAULT_COHORT_OPTION_TEXT . '"', $field_content );
			$field_content = str_replace( '</select>', $placeholder_option . $options . '</select>', $field_content );
			return $field_content . "\r\n" . '<script id="js-ans-cohort-data" type="application/json">' . json_encode( $json_array ) . '</script>';
		}
		return $field_content;
	}

	/**
	 * Collect all data from the first page and send to sales force as an app start
	 * Also populates the gravity_forms_id from concatconated email_campus_program_cohort
	 */
	public function sf_app_start( $form, $source_page_number, $current_page_number ) {

		if ( (int)$form['id'] !== (int)$this->application_form_id ) {
			return $field_content;
		}
		$api = self::get_api();
		if ( ! $api ) {
			return false;
		}

		$gfdp = $_COOKIE['gfdp'];
		if ( ! $gfdp ) {
			return false;
		}

		// Only send an app start if its the correct form and the user is coming
		// from page 1 ( don't do this if they are coming back from page 3 )
		if (
			(int)$form['id'] !== $this->application_form_id ||
			(int)$current_page_number !== 2 ||
			(int)$source_page_number != 1
		) {
			return;
		}

		$gf_fields = $form['fields'];
		$post_fields = array();

		// Filter out all fields not on page 1
		foreach ( $_POST as $pf_key => $post_field ) {
			$pf_key_int = str_replace( 'input_', '', $pf_key );
			foreach ( $gf_fields as $gf_field ) {
				if ( $gf_field->id == $pf_key_int ) {
					if ( $gf_field->pageNumber === 1 ) {
						$post_fields[$pf_key_int] = $post_field;
					}
					break;
				}
			}
		}

		// Map the fields to salesforce
		$sf_field_map = GFSalesforceData::get_feed_by_form( $form['id'] );
		$sf_field_map = @$sf_field_map[0]['meta']['field_map'];
		if ( $sf_field_map ) {
			$merge_fields = array();
			foreach ( $sf_field_map as $sf_field_key => $sf_field_value ) {
				$field_value = @$post_fields[ $sf_field_value ];
				if ( ! $field_value ) {
					continue;
				}
				$merge_fields[ $sf_field_key ] = $field_value;
			}
		}


		$merge_fields['Gravity_Form_Id__c'] = $gfdp;
		$merge_fields = $this->format_salesforce_date( $merge_fields );

		// Send merge fields to Salesforce
		$app_start = new stdClass();
		$app_start->type = 'Application__c';
		$app_start->fields = $merge_fields;
		$api_response = $api->upsert( 'Gravity_Form_Id__c', array( $app_start ) );
	}

	/**
	 * This hook modifies the multi selects before we send to salesforce
	 * The GF Salesforce plugin has a bug where these multi select fields are formatted incorrectly
	 */
	public function format_multi_selects_before_send( $merge_vars ) {
		foreach( $merge_vars as $key => &$merge_var ) {

			// Attempt to parse the string as json
			$format_json = str_replace( '";"', '","', $merge_var );

			// If this string is a JSON string, we need to parse and format it properly
			$json_array = json_decode( $format_json );
			if ( is_array( $json_array ) ) {
				$merge_var = '';
				foreach ( $json_array as $key => $value ) {
					if ( $key === 0 ) {
						$merge_var .= '' . $value;
					} else {
						$merge_var .= ';' . $value;
					}
				}
			}
		}
		return $merge_vars;
	}

	/**
	 * This function is used to populate the gravity_form_id field so the
	 * salesforce gravity form plugin will perform an upsert instead of an insert
	 */
	public function upsert_on_gravity_form_id( $merge_vars ) {
		$gfdp = $_COOKIE['gfdp'];
		if ( ! $gfdp ) {
			return false;
		}

		// Populate the security clearance questions
		$merge_vars['Gravity_Form_Id__c'] = $gfdp;
		return $merge_vars;
	}
}

new SS_GFSalesforce_Integration();
