var debounce = require( 'lodash.debounce' );

var alternator = {
	init : function() {
		var self = this;
		$( window ).on( 'load', self.scroll );
		$( window ).on( 'scroll', self.scroll );
		$( window ).on( 'resize', self.scroll );
	},
	scroll : function() {
		var elements = [
			$( '.alternator__image-1' ),
			$( '.alternator__image-2' )
		];

		function parallax() {
			elements.forEach( function( element ) {
				element.each( function() {
					var $this = $( this ).eq(0);
					if ( $this.hasClass( 'alternator__image-2-even' ) ) {
						transformLimit = 40;
					} else {
						transformLimit = 120;
					}
					var top = this.getBoundingClientRect().top.toFixed( 1 );
					var speed = this.dataset.speed;
					var additional = this.dataset.additional;
					var calculated = ( ( top - 100 ) / speed + parseInt( additional ) );
					var transform = calculated.toFixed( 1 );
					if ( transform > transformLimit ) {
						transform = transformLimit;
					}
					this.style.transform = 'translate3d(0, ' + transform + 'px, 0)';
				} );
			} )
		}

		function parallaxReset() {
			elements.forEach( function( element ) {
				element.each( function() {
					this.style.transform = 'translateY(0px)';
				} );
			} )
		}
/*
		if( $( window ).width() > 1200 ) {
			window.requestAnimationFrame( parallax );
		} else {
			window.requestAnimationFrame( parallaxReset );
		}
*/
	}
}
module.exports = alternator.init();
