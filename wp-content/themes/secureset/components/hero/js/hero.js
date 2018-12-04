var cookie = require( 'js-cookie' );

var hero = {
	init: function() {
		var self = this;

		// Hero Search Form Submit
		$( '#js-hero-search-form' ).submit( function( event ) {
			event.preventDefault();
			var $hash = $( this ).serializeArray().filter( function( field ) {
				return field.name === 'interest';
			})[0].value;
			self.formSubmit( $hash );
		});

		// Interest dropdown change
		$( '#js-hero-interest-select' ).change(function() {
			self.setHash();
		});

		// On cookie change event
		$( document ).on( 'ssLocationCookieChange', function( event, locationId ) {
			self.resetLocationLabel( locationId );
		});

		// Initial dropdown setup
		$( document ).ready( function() {
			self.initialInterestLabel();
		});
	},
	formSubmit: function(hash) {

		// Send to deep link
		$newUrl = scriptData.programLandingPagePath + hash;
		window.location = $newUrl;
	},
	setHash: function() {

		// Set hash if on programs landing page to filter on change
		if ( window.location.pathname === scriptData.programLandingPagePath ) {
			var selectedInterest = $( '#js-hero-interest-select option[selected="selected"]' ).val();
			window.location.hash = selectedInterest;
		}
	},
	resetLocationLabel: function( locationId ) {

		// Change location dropdown selected label to correct location on cookie change
		$( '#js-hero-location-select option[value="' + locationId + '"]' ).attr( 'selected', 'selected' );
		var $selectedLocationLabel = $( '#js-hero-location-selected' );
		var selectedCity = $( '#js-hero-location-select option[value="' + locationId + '"]' ).data( 'city' );
		$selectedLocationLabel.text( selectedCity );
	},
	initialInterestLabel: function() {

		// Initialize the selected label for interests on page load
		if ( window.location.hash ) {
			$( '#js-hero-interest-select option[value="' + window.location.hash + '"]' ).attr( 'selected', 'selected' );
			var $selectedInterestLabel = $( '#js-hero-interest-selected' );
			var selectedInterest = $( '#js-hero-interest-select option[value="' + window.location.hash + '"]' ).data( 'interest' );
			$selectedInterestLabel.text( selectedInterest );
		};
	}
};
exports = hero.init();
