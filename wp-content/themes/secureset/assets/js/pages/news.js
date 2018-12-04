var news = {

	// Initialization Method
	init: function() {

		if ( $( '.js-news__post-wrap' ).find( '#js-no-posts-message' ).length === 0 ) {

			$( '.js-news__post-wrap' ).isotope({
				layoutMode: 'fitRows',
				itemSelector: '.news__post',
				percentPosition: true,
				fitRows: { gutter: '.news__masonry-gutter' },
				transitionDuration: 0
			});

			$( '.js-news__post-wrap' ).imagesLoaded( function() {

				$( '.js-news__post-wrap' ).isotope( 'layout' );

				// Ajax pagination
				$( document ).on( 'click', '#js-load-more-news', function( event ) {
					var link = $( '#js-next-posts-link a' ).attr( 'href' );
					$.ajax({
						url: link,
						beforeSend: function( xhr ) {
							$( '#js-load-more-news' ).hide();
							$( '#js-ajax-loader' ).removeClass( 'hidden' );
						},
						success: function( response ) {
							$( '#js-ajax-loader' ).addClass( 'hidden' );
							$( '#js-load-more-news' ).show();
							var $response = $( response ),
								$items = $response.find( '.js-news__post-wrap' ).children(),
								$nextPageAnchor = $response.find( '#js-next-posts-link a' );

							// Remove link and button if next page didn't one
							if ( typeof $nextPageAnchor.attr( 'href' ) == 'undefined' ) {
								$( '#js-load-more-news' ).remove();
							} else {
								$( '#js-next-posts-link a' ).attr( 'href', $nextPageAnchor.attr( 'href' ) );
							}

							$( '.js-news__post-wrap' ).isotope( 'insert', $items );
							$( '.js-news__post-wrap' ).imagesLoaded( function() {
								$( '.js-news__post-wrap' ).isotope( 'layout' );
							});
						}
					});
					event.preventDefault();
				});
			});
		}
	}
};
module.exports = news.init();
