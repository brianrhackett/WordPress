var latestProg = {
	init: function() {
		$( document ).on( 'ssLocationCookieChange', function( event, locationId ) {
			latestProg.updatePrograms( locationId );
		} );
	},

	updatePrograms: function( locationId ) {
		var $programComponent = $( '.js-latest-programs__container' );
		var locationData = {
			"action": "get_upcoming_programs",
			"location_id": locationId,
		};

		$programComponent.each( function() {
			$( this ).addClass( 'loading' );
		} );

		$.ajax( {
			type: 'GET',
			dataType : 'json',
			url: scriptData.ajaxurl,
			action: 'get_upcoming_programs',
			data: locationData,
			success: function( data ){
				var newCards = '';

				if ( data.length > 0 ) {
					for ( var i = 0; i < data.length; i++ ) {
						var program = data[ i ],
							cardHtml = '';

						cardHtml += '<div class="latest-programs__item">\n';
						cardHtml += '\t<div class="latest-programs__item-info">\n';
						cardHtml += '\t\t<div class="latest-programs__item-icon" style="background-color:' + program.card_icon_color + '">\n';
						cardHtml += '\t\t\t<img src="' + program.card_icon_url + '" alt="' + program.card_title + '" />\n';
						cardHtml += '\t\t</div>\n';
						cardHtml += '\t\t<h6 class="latest-programs__item-title">' + program.card_title + '</h6>\n';
						cardHtml += '\t\t<p class="small latest-programs__item-location">' + program.card_location + '</p>\n';
						cardHtml += '\t\t<p class="latest-programs__item-dates">' + program.card_dates + '</p>\n';
						cardHtml += '\t</div>\n';
						cardHtml += '\t<a class="latest-programs__item-button" href="' + program.card_link + '">Learn More</a>\n';
						cardHtml += '</div>\n\n';

						newCards += cardHtml
					};
				} else {
					newCards += '<div class="latest-programs__item">\n';
					newCards += '\t<div class="latest-programs__item-info">\n';
					newCards += '\t\t<h6 class="latest-programs__item-title">Sorry, no upcoming programs for your location.</h6>';
					newCards += '\t</div>\n';
					newCards += '</div>\n\n';
				}

				$programComponent.each( function() {
					var $this = $( this );
					$this.empty();
					$( newCards ).appendTo( $this );
					$this.removeClass( 'loading' );
				} );
			},
			error: function( errorThrown ) {

				var newCards = '';
				newCards += '<div class="latest-programs__item">\n';
				newCards += '\t<div class="latest-programs__item-info">\n';
				newCards += '\t\t<h6 class="latest-programs__item-title">Sorry, no upcoming programs for your location.</h6>';
				newCards += '\t</div>\n';
				newCards += '</div>\n\n';

				$programComponent.each( function() {
					var $this = $( this );
					$this.html( '' );
					$( newCards ).appendTo( $this );
					$this.removeClass( 'loading' );
				} );
			}
		} );
	}
};
module.exports = latestProg.init();
