<?php

if ( class_exists( 'Tribe__Events__Main' ) ) {

	/**
	 * Hubspot Event Ticket RSVP integration
	 */
	class Tribe_Event_Tickets_Hubspot_Integration
	{

		// Hubspot API Key from tribe events populated via __construct()
		private $api_key;

		// API base url
		private $api_url = 'https://api.hubapi.com';

		// Error message
		private $error_message = 'Please fill out all fields';

		// Hubspot list filter, will only be able to select from lists that "contain" this string
		private $hubspot_list_filter = '(WP)';

		// Args used in wp_remote_post
		private $post_args = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(
				'content-type' => 'application/json'
			),
			'cookies' => array()
		);

		// Event count group data
		private $event_count_group = array(
			'group_name' => 'rsvp',
			'group_display_name' => 'RSVP Counts'
		);

		// Expert event property data
		private $expert_event_property = array(
			'name' 		=> 'expert_event_count',
			'label' 	=> 'Expert Event Count',
			'groupName' => 'rsvp',
			'type' 		=> 'number',
			'fieldType' => 'number'
		);

		// Beginner event property data
		private $beginner_event_property = array(
			'name' 		=> 'beginner_event_count',
			'label' 	=> 'Beginner Event Count',
			'groupName' => 'rsvp',
			'type' 		=> 'number',
			'fieldType' => 'number'
		);

		// Total events property data
		private $total_event_property = array(
			'name' 		=> 'total_event_count',
			'label' 	=> 'Total Event Count',
			'groupName' => 'rsvp',
			'type' 		=> 'number',
			'fieldType' => 'number'
		);

		/**
		 * Constructor sets up WP hooks
		 */
		public function __construct() {
			$this->api_key = tribe_get_option( 'hubspot_api_key' );

			// Actions
			add_action( 'tribe_tickets_rsvp_before_attendee_ticket_creation', array( $this, 'check_required_fields' ), 10, 3 );
			add_action( 'event_tickets_rsvp_attendee_created', array( $this, 'process_attendee' ), 10, 3 );
			add_action( 'rsvp_checkin', array( $this, 'checkin_attendee' ), 10, 2 );
			add_action( 'rsvp_uncheckin', array( $this, 'uncheckin_attendee' ), 10, 2 );

			// Filters
			add_filter( 'acf/load_field/name=hs_event_list', array( $this, 'populate_event_list_acf' ) );
			add_filter( 'tribe_addons_tab_fields', array( $this, 'hs_api_key_field' ) );
			add_filter( 'tribe_rsvp_submission_message', array( $this, 'modify_error_message' ), 10, 2 );
		}

		/** 
		 * Public WP hook method kicks of several private methods
		 * 
		 * @param  int 	$attendee_id 	The ID of the attendee
		 * @param  int 	$post_id     	The ID of the event post for the attendee
		 * @param  int 	$order_id    	The ID of the order
		 */
		public function process_attendee( $attendee_id, $post_id, $order_id ) {
			$this->_RSVP_additional_fields( $attendee_id, $post_id );
			$this->_hs_create_contact( $attendee_id );
			$event_list_id = get_field( 'hs_event_list', $post_id );
			$email = get_post_meta( $attendee_id, '_tribe_rsvp_email' )[0];
			if ( $event_list_id && $email ) {
				print_r( $this->_hs_add_contact_to_event_list( $event_list_id, $email ) );
			}
		}

		/**
		 * WP hook when an attendee checks into an event via QR code in email
		 *
		 * @param int       $attendee_id
		 * @param bool|null $qr
		 */
		public function checkin_attendee( $attendee_id, $qr ) {
			$event_id = get_field( '_tribe_rsvp_event', $attendee_id );
			$this->_hs_create_event_count_properties_and_group();
			$this->_hs_increment_contact_event_count_properties( $attendee_id, $event_id );
		}

		/**
		 * WP hook when an attendee checks into an event via QR code in email
		 *
		 * @param int       $attendee_id
		 * @param bool|null $qr
		 */
		public function uncheckin_attendee( $attendee_id, $qr ) {
			$event_id = get_field( '_tribe_rsvp_event', $attendee_id );
			$this->_hs_create_event_count_properties_and_group();
			$this->_hs_decrement_contact_event_count_properties( $attendee_id, $event_id );
		}

		/**
		 * WP hook to populate the hs_event_list acf select field
		 *
		 * @param array $field ACF field array
		 */
		public function populate_event_list_acf( $field ) {
			$field['choices'] = array();
			$hs_lists = $this->_hs_get_event_lists();
			if ( $hs_lists ) {
				$field['choices'][false] = '';
				foreach ( $hs_lists as $list ) {
					$field['choices'][$list['internal_id']] = $list['name']; 
				}
			} else {
				$field['choices'] = array( 'Hubspot API error' );	
			}
			return $field;
		}

		/**
		 * WP Hook to modify the error message from Tribe Event Tickets
		 *
		 * @param string $message error message
		 * @param string $type type of error message
		 */
		public function modify_error_message( $message, $type ) {
			if ( $type == 'error' ) {
				$message = $this->error_message;
			}
			return $message;
		}

		/**
		 * Check for required fields and display an error if any fields are missing
		 */
		public function check_required_fields( $post_id, $ticket_type, $post ) {
			$post = $this->_sanitize_input( $post );
			if (
				! $post['phone'] ||
				! $post['first_name'] ||
				! $post['last_name'] ||
				! $post['interest']
			) {
				$url = get_permalink();
				$url = add_query_arg( 'rsvp_error', 1, $url );
				wp_redirect( esc_url_raw( $url ) );
				tribe_exit();
			}
		}

		/**
		 * Sanitizes the custom $_POST fields
		 * 
		 * @param 	array 	$post The post fields
		 * @return 	array 	array of sanitized fields
		 */
		private function _sanitize_input( $post ) {
			$sanitized_fields = array();
			$sanitized_fields['phone'] = empty( $_POST['attendee']['phone'] ) ? null : sanitize_text_field( $_POST['attendee']['phone'] );
			$sanitized_fields['first_name'] = empty( $_POST['attendee']['first_name'] ) ? null : sanitize_text_field( $_POST['attendee']['first_name'] );
			$sanitized_fields['last_name'] = empty( $_POST['attendee']['last_name'] ) ? null : sanitize_text_field( $_POST['attendee']['last_name'] );
			$sanitized_fields['interest'] = empty( $_POST['attendee']['interest'] ) ? null : sanitize_text_field( $_POST['attendee']['interest'] );
			return $sanitized_fields;
		}

		/**
		 * Handles the additional fields on the RSVP form
		 * 
		 * @param  int $attendee_id 	The ID of the attendee
		 * @param  int $post_id 		The ID of the event
		 */
		private function _RSVP_additional_fields( $attendee_id, $post_id ) {
			$post = $this->_sanitize_input( $_POST );
			$event_start_date = strtotime( tribe_get_start_date( $post_id, true, 'm/d/y h:i:s' ) );
			$location = get_post( get_field( 'location', $post_id )[0] );
			$event_type = get_field( 'event_type', $post_id );
			$event = get_post( $post_id );
			add_post_meta( $attendee_id, '_phone_number', $post['phone'] );
			add_post_meta( $attendee_id, '_first_name', $post['first_name'] );
			add_post_meta( $attendee_id, '_last_name', $post['last_name'] );
			add_post_meta( $attendee_id, '_interest', $post['interest'] );
			add_post_meta( $attendee_id, '_start_date', $event_start_date );
			add_post_meta( $attendee_id, '_event_title', $event->post_title );
			if ( $event_type ) {
				add_post_meta( $attendee_id, '_event_type', $event_type );
			}
			if ( $location ) {
				add_post_meta( $attendee_id, '_location', $location->post_title );
			}
		}

		/**
		 * Creates the hubspot contact if they don't already exist
		 * 
		 * @param  int $attendee_id 	The ID of the event attendee
		 */
		private function _hs_create_contact( $attendee_id ) {
			$create_contact_url = $this->api_url . '/contacts/v1/contact?hapikey=' . $this->api_key;
			$email = get_post_meta( $attendee_id, '_tribe_rsvp_email' )[0];
			$first_name = get_post_meta( $attendee_id, '_first_name' )[0];
			$last_name = get_post_meta( $attendee_id, '_last_name' )[0];
			$phone = get_post_meta( $attendee_id, '_phone_number')[0];

			$post_data = array(
				'properties' => array(
					array(
						'property' => 'email',
						'value' => $email
					),
					array(
						'property' => 'firstname',
						'value' => $first_name
					),
					array(
						'property' => 'lastname',
						'value' => $last_name
					),
					array(
						'property' => 'phone',
						'value' => $phone
					)
				)
			);

			$post_data = json_encode( $post_data );
			$args = $this->post_args;
			$args['body'] = $post_data;
			wp_remote_post( $create_contact_url, $args );
		}

		/**
		 * Returns an array of ALL Hubspot list names and internal IDs
		 * Filters based on $hubspot_list_filter
		 * 
		 * @return 	array 	lists from hubspot
		 */
		private function _hs_get_event_lists() {
			$hs_lists = array();
			$has_more = true;
			$has_more_key = 'has-more';
			$offset = 0;
			while ( $has_more ) {
				$request_url = $this->api_url . '/contacts/v1/lists?count=250&offset=' . $offset . '&hapikey=' . $this->api_key;	
				$response = wp_remote_get( $request_url );

				if ( $response['response']['code'] != 200 ) {
					return false;
				}
				$body = json_decode( $response['body'] );
				foreach ( $body->lists as $list ) {
					if ( strpos( $list->name, $this->hubspot_list_filter ) !== false ) {
						$hs_lists[] = array(
							'name' => $list->name,
							'internal_id' => $list->listId
						);
					}
				}
				$has_more = (bool)$body->$has_more_key;
				$offset = $body->offset;
			}
			return $hs_lists;
		}

		/**
		 * Creates a property in hubspot
		 */
		private function _hs_create_property( $property_name, $property_label, $group_name, $type, $field_type ) {
			$create_property_url = $this->api_url . '/properties/v1/contacts/properties?hapikey=' . $this->api_key;
			$post_data = array(
				'name' 		=> $property_name,
				'label' 	=> $property_label,
				'groupName' => $group_name,
				'type' 		=> $type,
				'fieldType' => $field_type
			);
			$post_data = json_encode( $post_data );
			$args = $this->post_args;
			$args['body'] = $post_data;

			// Make the API call
			return wp_remote_post( $create_property_url, $args );
		}

		/**
		 * Creates a contact property group in hubspot
		 */
		private function _hs_create_property_group( $group_name, $group_label ) {
			$create_property_group_url = $this->api_url . '/properties/v1/contacts/groups?hapikey=' . $this->api_key;
			$post_data = array(
				'name' 		=> $group_name,
				'displayName' => $group_label
			);
			$post_data = json_encode( $post_data );
			$args = $this->post_args;
			$args['body'] = $post_data;

			// Make the API call
			return wp_remote_post( $create_property_group_url, $args );
		}

		/**
		 * Gets a contacts property
		 */
		private function _hs_get_contact_property( $email, $property_key ) {
			$read_contact_url = $this->api_url . '/contacts/v1/contact/email/' . $email . '/profile?hapikey=' . $this->api_key;
			$response = wp_remote_get( $read_contact_url );
			$response_body = json_decode( $response['body'] );
			if ( isset( $response_body->properties->$property_key ) ) {
				return $response_body->properties->$property_key->value;
			} else {
				return false;
			}
		}

		/**
		 * Upserts a contact property
		 */
		private function _hs_upsert_contact_property( $email, $property_key, $value ) {
			$update_contact_url = $this->api_url . '/contacts/v1/contact/email/' . $email . '/profile?hapikey=' . $this->api_key;
			$value = trim( $value );
			$post_data = array(
				'properties' => array(
					array(
						'property' => $property_key,
						'value' => $value
					)
				)
			);
			$post_data = json_encode( $post_data );
			$args = $this->post_args;
			$args['body'] = $post_data;
			return wp_remote_post( $update_contact_url, $args );
		}

		/**
		 * Add a hubspot contact to the list associated with the event
		 *
		 * @param int $list_id Hubspot list id
		 * @param string $email Email of the contact
		 */
		private function _hs_add_contact_to_event_list( $list_id, $email ) {
			$request_url = $this->api_url . '/contacts/v1/lists/' . $list_id . '/add?hapikey=' . $this->api_key;
			$post_data = array(
				'emails' => array(
					$email
				)
			);
			$post_data = json_encode( $post_data );
			$args = $this->post_args;
			$args['body'] = $post_data;
			return wp_remote_post( $request_url, $args );
		}

		/**
		 * Makes a call to hubspot api to create the RSVP property for contacts
		 */
		private function _hs_create_event_count_properties_and_group() {
			$this->_hs_create_property_group(
				$this->event_count_group['group_name'],
				$this->event_count_group['group_display_name']
			);
			
			$this->_hs_create_property(
				$this->expert_event_property['name'],
				$this->expert_event_property['label'],
				$this->expert_event_property['groupName'],
				$this->expert_event_property['type'],
				$this->expert_event_property['fieldType']
			);

			$this->_hs_create_property(
				$this->beginner_event_property['name'],
				$this->beginner_event_property['label'],
				$this->beginner_event_property['groupName'],
				$this->beginner_event_property['type'],
				$this->beginner_event_property['fieldType']
			);

			$this->_hs_create_property(
				$this->total_event_property['name'],
				$this->total_event_property['label'],
				$this->total_event_property['groupName'],
				$this->total_event_property['type'],
				$this->total_event_property['fieldType']
			);
		}

		/**
		 * Increment approprate event count hubspot contact property field
		 */
		private function _hs_increment_contact_event_count_properties( $attendee_id, $post_id ) {
			$email = get_post_meta( $attendee_id, '_tribe_rsvp_email' );
			if ( $email ) {
				$email = $email[0];
				$event_level = get_field( 'event_level', $post_id );

				// Get event level and update the proper event count contact property
				switch ( $event_level ) {
					case 'beginner':
						$beginner_event_count = (int)$this->_hs_get_contact_property( $email, 'beginner_event_count' );
						if ( $beginner_event_count ) {
							$beginner_event_count++;	
						} else {
							$beginner_event_count = 1;
						}
						$this->_hs_upsert_contact_property( $email, 'beginner_event_count', $beginner_event_count );
						break;

					case 'expert':
						$expert_event_count = (int)$this->_hs_get_contact_property( $email, 'expert_event_count' );
						if ( $expert_event_count ) {
							$expert_event_count++;
						} else {
							$expert_event_count = 1;
						}
						$this->_hs_upsert_contact_property( $email, 'expert_event_count', $expert_event_count );
						break;
				}

				// Update total event count property
				$total_event_count = (int)$this->_hs_get_contact_property( $email, 'total_event_count' );
				if ( $total_event_count ) {
					$total_event_count++;
				} else {
					$total_event_count = 1;
				}

				$this->_hs_upsert_contact_property( $email, 'total_event_count', $total_event_count );
			}
		}

		/**
		 * Decrement approprate event count hubspot contact property field
		 * 
		 */
		private function _hs_decrement_contact_event_count_properties( $attendee_id, $post_id ) {
			$email = get_post_meta( $attendee_id, '_tribe_rsvp_email' );
			if ( $email ) {
				$email = $email[0];
				$event_level = get_field( 'event_level', $post_id );

				// Get event level and update the proper event count contact property
				switch ( $event_level ) {
					case 'beginner':
						$beginner_event_count = (int)$this->_hs_get_contact_property( $email, 'beginner_event_count' );
						if ( $beginner_event_count ) {
							$beginner_event_count--;	
						} else {
							$beginner_event_count = 0;
						}
						$this->_hs_upsert_contact_property( $email, 'beginner_event_count', $beginner_event_count );
						break;

					case 'expert':
						$expert_event_count = (int)$this->_hs_get_contact_property( $email, 'expert_event_count' );
						if ( $expert_event_count ) {
							$expert_event_count--;
						} else {
							$expert_event_count = 0;
						}
						$this->_hs_upsert_contact_property( $email, 'expert_event_count', $expert_event_count );
						break;
				}

				// Update total event count property
				$total_event_count = (int)$this->_hs_get_contact_property( $email, 'total_event_count' );
				if ( $total_event_count ) {
					$total_event_count--;
				} else {
					$total_event_count = 0;
				}
				$this->_hs_upsert_contact_property( $email, 'total_event_count', $total_event_count );
			}
		}

		/**
		 * Add the hubspot api key field to the tribe events plugin
		 */
		public function hs_api_key_field( array $addon_fields ) {
			$hubspot_api_field = array(
				'hubspot-api-start' => array(
					'type' => 'html',
					'html' => '<h3>Hubspot API Key</h3>',
				),

				'hubspot-api-info-box' => array(
					'type' => 'html',
					'html' => '<p>Please supply a hubspot API key.</p>',
				),

				'hubspot_api_key' => array(
					'type'            => 'text',
					'label'           => 'Hubspot API Key',
					'tooltip'         => '<a href="https://app.hubspot.com/integrations-beta/4216189/your-integrations/api-key" target="_blank">Click Here</a> to create your Hubspot API key',
					'size'            => 'medium',
					'validation_type' => 'alpha_numeric_with_dashes_and_underscores',
					'can_be_empty'    => true,
					'parent_option'   => Tribe__Events__Main::OPTIONNAME,
				),
			);
			return array_merge( (array) $addon_fields, $hubspot_api_field );
		}
	}
	new Tribe_Event_Tickets_Hubspot_Integration();
} // End Tribe Events class check
