var selects = {
	init: function() {
		$( '.dropdown-pane:not( .desktop-nav-more-pane ) a' ).on( 'click', function() {
			var $this = $( this ),
				$dropdownPane = $this.closest( '.dropdown-pane' ),
				$select = $dropdownPane.find( 'select' );
			$dropdownPane.foundation( 'close' );
			$dropdownPane.siblings( '.dropdown-trigger' ).html( $this.html() );
			if ( $select.length ) {
				$select.find( 'option[selected="selected"]' ).removeAttr( 'selected' );
				$select.find( 'option[value="' + $this.attr( 'data-value' ) + '"]' ).attr( 'selected', 'selected' );
				$select.trigger( 'change' );
			}
		});

		// Re-order/alphabetize dropdown pane items
		$( '.dropdown-pane:not( .desktop-nav-more-pane ) ul' ).each( function( x ) {
			var $dropdown = $( this );

			$dropdown.children().detach().sort( function( a, b ) {
				return $( a ).text().localeCompare( $( b ).text() );
			}).appendTo( $dropdown );
		});
	}
};
selects.init();
module.exports = selects;
