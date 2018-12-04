var eventsLanding = {
	init: function() {
		$( document ).on( 'click', function( event ) {
			var $target = $( event.target );
			if ( !$target.hasClass( 'tribe-events-filters-group-heading' ) && !$target.hasClass( 'horizontal-drop-indicator' ) ) {
				$( '.tribe_events_filter_item' ).addClass( 'closed' );
			}
		});

		$( '.js-event-bar__month-input' ).on( 'focus', function( event ) {
			$( this ).blur();
			event.preventDefault();
		});

		$( document ).on( 'click', function( event ) {
			var $target = $( event.target ).closest( '.tribe_events_filter_item:not(.closed)' );
			if ( $target.length ) {
				$( '.tribe_events_filter_item' ).not( $target ).addClass( 'closed' );
			}
		});

		$( '.tribe-events-filter-group label' ).on( 'click', function( event ) {
			$( '.tribe_events_filter_item' ).addClass( 'closed' );
		});

		$( '#js-event-bar-month' ).on( 'click', function( event ) {
			event.preventDefault();
			if ( event.originalEvent !== undefined ) {
				$( this ).find( 'input' ).focus();
			}
		});

		$( '#js-custom-level-filter-trigger a' ).on( 'click', function( event ) {
			event.preventDefault();
			var $this = $( this );
			$( '#js-custom-level-filter-trigger a' ).removeClass( 'active' );

			if ( $this.hasClass( 'js-all' ) ) {
				$( '#js-custom-level-filter' ).find( 'input' ).prop( 'checked', false ).trigger( 'change' );
			} else {
				$this.addClass( 'active' );
				$( '#js-custom-level-filter' ).find( 'input[value="' + $this.attr( 'data-value' ) + '"]' ).prop( 'checked', true ).change().trigger( 'click' );
			}
		});
	}
};
module.exports = eventsLanding.init();
