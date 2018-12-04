var eventDetails = {
	init: function() {
		$( '.event-details' ).on( 'click', '#js-event-details-rsvp-expander', function( event ) {
			event.preventDefault();
			var $this = $( this );
			$this.hide();
			$this.closest( '.event-details__buttons' ).find( '.cta' ).hide();
			$( '.js-event-details-rsvp-form' ).addClass( 'expanded' );
		});

		if ( $.mask ) {
			$( '.js-phone-number-mask' ).mask( '(999) 999-9999' );
		}

		$( window ).load( function() {
			if ( window.location.search.includes( 'rsvp_error' ) ) {
				$( 'html, body' ).animate({ scrollTop: $( '#js-event-details-rsvp-expander' ).offset().top - 200 }, 2000, 'swing', function( ) {
					$( '#js-event-details-rsvp-expander' ).trigger( 'click' );
				});
			}
			if ( window.location.search.includes( 'rsvp_sent' ) ) {
				$( 'html, body' ).animate({ scrollTop: $( '#js-event-details-rsvp-expander' ).offset().top - 200 }, 2000 );
			}
		});
	}
};
module.exports = eventDetails.init();
