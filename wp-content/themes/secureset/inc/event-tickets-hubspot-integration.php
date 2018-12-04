<?php
if ( class_exists( 'Tribe__Events__Main' ) ) {
	/**
	 * Hubspot Event Ticket RSVP integration
	 */
	class EventTicketsHubspotIntegration
	{

		// Hubspot API Key from tribe events
		private $api_key;

		// API base url
		private $api_url = 'https://api.hubapi.com';

		/**
		 * Constructor sets up WP hooks
		 */
		public function __construct() {
			$this->api_key = tribe_get_option( 'hubspot_api_key' );
			add_action( 'rsvp_checkin', array( $this, 'send_to_hubspot' ) );
			add_action( 'rsvp_uncheckin', array( $this, 'remove_from_hubspot' ) );
			add_filter( 'tribe_addons_tab_fields', array( $this, 'hubspot_api_key_field' ) );
		}

		/**
		 * Makes a call to hubspot api to create the RSVP property for contacts
		 */
		private function _hs_create_rsvp_property() {
			$create_property_url = $this->api_url . '/properties/v1/contacts/properties?hapikey=' . $this->api_key;
			$post_data = array(
				'name' => 'rsvp',
				'label' => 'RSVP',
				'groupName' => 'contactinformation',
				'type' => 'string',
				'fieldType' => 'textarea '
			);

			$post_data = json_encode( $post_data );

			$args = array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(
					'content-type' => 'application/json'
				),
				'body' => $post_data,
				'cookies' => array()
			);

			return wp_remote_post( $create_property_url, $args );
		}

		/**
		 * Get RSVP value for Hubspot contact
		 */
		private function _hs_get_rsvp_value( $attendee ) {
			$read_contact_url = $this->api_url . '/contacts/v1/contact/email/' . $attendee[0]['purchaser_email'] . '/profile?hapikey=' . $this->api_key;
			$response = wp_remote_get( $read_contact_url );
			$response_body = json_decode( $response['body'] );
			if ( isset( $response_body->properties->rsvp ) && !empty( $response_body->properties->rsvp->value ) ) {
				return $response_body->properties->rsvp->value;
			} else {
				return false;
			}
		}

		/**
		 * Updates the Hubspot contacts RSVP value
		 */
		private function _hs_update_rsvp_value( $attendee, $rsvp_value ) {

			// Trim and strip out excess whitespace
			$rsvp_value = trim( $rsvp_value );
			$update_contact_url = $this->api_url . '/contacts/v1/contact/email/' . $attendee[0]['purchaser_email'] . '/profile?hapikey=' . $this->api_key;
			$post_data = array(
				'properties' => array(
					array(
						'property' => 'rsvp',
						'value' => $rsvp_value
					)
				)
			);
			$post_data = json_encode( $post_data );

			$args = array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(
					'content-type' => 'application/json'
				),
				'body' => $post_data,
				'cookies' => array()
			);
			wp_remote_post( $update_contact_url, $args );
		}

		/**
		 * Builds out the event value to send to hubspot
		 *
		 * @param int|object $event event id or object
		 * @return string Event string to send to hubspot
		 */
		private function _build_event_string( $event ) {
			if ( is_int( $event ) ) {
				$event = get_post( $event );
			}

			if ( !is_a( $event, 'WP_post' ) ) {
				return false;
			}
			$location_id = get_field( 'location', $event )[0];
			$location = get_post( $location_id );
			return $event->post_title . ' - ' . $location->post_title . ' - ' . tribe_get_start_date( $event, true, 'n/d/y g:ia' );
		}

		/**
		 * Removes a specific event_id from the hubspot contact
		 */
		private function _hs_remove_event_id( $attendee, $event_string ) {
			$rsvp_value = $this->_hs_get_rsvp_value( $attendee );
			$rsvp_value = str_replace( '|' . $event_string . '|', '', $rsvp_value );
			$this->_hs_update_rsvp_value( $attendee, $rsvp_value );
		}

		/**
		 * Sends the event id to hubspot and update the contact based on email
		 */
		public function send_to_hubspot( $attendee_id ) {
			if ( !$this->api_key ) {
				return false;
			}

			// Create the RSVP property
			$this->_hs_create_rsvp_property();

			// Get attendee by ID
			$data_api = new Tribe__Tickets__Data_API;
			$attendee = $data_api->get_attendees_by_id( $attendee_id );

			// Build the RSVP value string
			$event_id = (int)$_POST['event_ID'];
			if ( ! $event_id ) {
				$event_id = (int)$_GET['event_id'];
			}

			if ( ! $event_id ) {
				return false;
			}
			$event_string = $this->_build_event_string( $event_id );

			$hs_rsvp_value = $this->_hs_get_rsvp_value( $attendee );

			if ( $hs_rsvp_value ) {

				// Only add the new event id if its not already part of the RSVP value
				if ( strpos( $hs_rsvp_value, $event_string ) === false ) {
					$hs_rsvp_value .= '|' . $event_string . '|';
				}
			} else {
				$hs_rsvp_value = '|' . $event_string . '|';
			}

			// Update this contact in HS with the new RSVP value
			$this->_hs_update_rsvp_value( $attendee, $hs_rsvp_value );
		}

		/**
		 * Remove the event_id from the hubspot contact on uncheckin
		 */
		public function remove_from_hubspot( $attendee_id ) {
			if ( !$this->api_key ) {
				return;
			}

			// Get attendee by ID
			$data_api = new Tribe__Tickets__Data_API;
			$attendee = $data_api->get_attendees_by_id( $attendee_id );

			// Remove this event ID from the hubspot contact
			$event_id = (int)$_POST['event_ID'];
			if ( ! $event_id ) {
				$event_id = (int)$_GET['event_id'];
			}

			$event_string = $this->_build_event_string( $event_id );

			$this->_hs_remove_event_id( $attendee, $event_string );
		}

		/**
		 * Add the hubspot api key field to the tribe events plugin
		 */
		public function hubspot_api_key_field( array $addon_fields ) {
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

	new EventTicketsHubspotIntegration();
}
