var mediaHelper = {
	init : function() {
		// Attach fancybox to the fancybox-media class
		$( '.fancybox-media' ).fancybox( {
			padding: 0,
			margin: 20,
			width: '100%',
			maxWidth: 1064,
			maxHeight: 800,
			animationEffect : 'fade',
			type: 'iframe',
			iframe: {
				scrolling: 'no',
				preload: false
			},
			fitToView: true,
			afterShow: function( instance, slide ) {
				var aspectRatio = $( this.element ).closest( '.media-helper' ).find('.aspect-ratio').data( 'aspect-ratio' );
				$( '.fancybox-type-iframe .fancybox-inner' ).css( 'padding-bottom', aspectRatio + '%' );
			},
			beforeShow: function( instance, slide ) {
				$('#page').addClass('blur');
		},
			beforeClose: function( instance, slide ) {
				$('#page').removeClass('blur');
			},
		} );
	},
}
mediaHelper.init();
