var vidHelper = {
	init: function() {
		$( '.js-full-vid-play-button' ).on( 'click', function (event) {
			var $section = $( this ).closest( '.js-full-vid' );
			var url = $section.find( '.full-video-iframe' ).attr( 'data' );
			$section.find( '.js-full-video-iframe' ).attr( 'src', url );
			$( '.js-full-video-iframe' ).load( function() {
				$(this).parent().addClass("active");
				$section.find( '.js-full-vid-play-button' ).hide();
			});
		});
	},
}
module.exports = vidHelper.init();
