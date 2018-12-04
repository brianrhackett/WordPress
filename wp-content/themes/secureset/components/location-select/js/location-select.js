var cookie = require( 'js-cookie' );
var location = {
	init: function() {
		$( document ).on( 'change', '.js-location-select select', function() {
			var $this = $( this ),
			 	$selected = $this.find( ':selected' ),
				$otherSelects = $( '.js-location-select select' ).not( $this ),
				customPageLocation =  $this.closest( '.js-location-select' ).attr( 'data-custom-page-location' );

			$otherSelects.each( function() {
				var $this = $( this );
				if ( $this.hasClass( 'js-header-location-dropdown' ) && customPageLocation === 'true' ) {
					return true;
				}

				$this.find( ':selected' ).removeAttr( 'selected' );
				$this.find( 'option[value="' + $selected.val() + '"]').attr( 'selected', 'selected' );
				var $trigger = $this.closest( '.js-location-select' ).find( '.js-location-select__trigger' );
				if ( $trigger.length ) {
					$trigger.html( $selected.html() );
				}
			});

			// Don't update the global cookie if we're on a custom location page or the use the header location dropdown
			if ( customPageLocation != 'true' || $this.hasClass( 'js-header-location-dropdown' ) ) {
				cookie.set( 'secureset_location', $selected.val(), { expires: 365 } );
			}
			$( document ).trigger( 'ssLocationCookieChange', [ $selected.val(), false ] );
		});

		$( document ).ready( function() {
			var defaultLocation = cookie.get( 'secureset_location' );
			$( '.js-location-select select option[value=' + defaultLocation + ']' ).attr( 'selected', 'selected' );
		});
	}
};
module.exports = location.init();
