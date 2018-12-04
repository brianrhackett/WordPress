var latestEvents = {
	init: function() {
		$( document ).on( 'ssLocationCookieChange', function( event, locationId ) {
			latestEvents.updateEvents( locationId );
		} );
	},

	updateEvents: function( locationId ) {
		var $eventComponents = $( '.js-latest-events__container' );
		$eventComponents.each( function() {
			var $eventComponent = $( this );
			$eventComponent.addClass( 'loading' );
			var ajaxData = {
				'action' : 'get_upcoming_events',
				'location_id' : locationId,
				'event_categories' : $eventComponent.attr( 'data-event-categories')
			};
			$.ajax( {
				type: 'GET',
				dataType : 'json',
				url: scriptData.ajaxurl,
				action: 'get_upcoming_events',
				data: ajaxData,
				success: function( data ){
					var newCards = '';
					if ( data.length > 0 ) {

						for ( var i = 0; i < data.length; i++ ) {
							var singleEvent = data[ i ],
								cardHtml = '';

							cardHtml += '<div class="latest-events__item">\n';
							cardHtml += '\t<div class="latest-events__item-info">\n';
							cardHtml += '\t\t<h6 class="latest-events__item-title">' + singleEvent.card_title + '</h6>\n';
							cardHtml += '\t\t<div class="latest-events__item-date">' + singleEvent.card_date + '</div>\n';
							cardHtml += '\t</div>\n';
							cardHtml += '\t<a class="latest-events__item-button" href="' + singleEvent.card_link + '">Learn More</a>\n';
							cardHtml += '</div>\n\n';
							newCards += cardHtml;
						}
					} else {
						newCards += '<div class="latest-events__item">\n';
						newCards += '\t<div class="latest-events__item-info">\n';
						newCards += '\t\t<h6 class="latest-events__item-title">Sorry, no upcoming events for your location.</h6>';
						newCards += '\t</div>\n';
						newCards += '</div>\n\n';
					}

					$eventComponent.empty();
					$( newCards ).appendTo( $eventComponent );
					$eventComponent.removeClass( 'loading' );
				},

				error: function( errorThrown ) {

					var newCards = '';
					newCards += '<div class="latest-events__item">\n';
					newCards += '\t<div class="latest-events__item-info">\n';
					newCards += '\t\t<h6 class="latest-events__item-title">Sorry, no upcoming events for your location.</h6>';
					newCards += '\t</div>\n';
					newCards += '</div>\n\n';

					$eventComponent.each( function() {
						var $this = $( this );
						$this.html( '' );
						$( newCards ).appendTo( $this );
						$this.removeClass( 'loading' );
					} );
				}
			} );

		} );
	}
};
module.exports = latestEvents.init();
