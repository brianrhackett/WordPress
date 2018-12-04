var cookie = require( 'js-cookie' );

var locationDetails = {
	maps: [],
	mapMarkerIcon: null,
	markers: [],
	locationData: null,
	getLocationById: function( locationId ) {
		for ( var i in locationDetails.locationData ) {
			if ( locationDetails.locationData[i].ID == locationId ) {
				return locationDetails.locationData[i];
			}
		}
		return false;
	},
	init: function() {
		var locationCookie = cookie.get( 'secureset_location' );
		var defaultLat = $( '#js-location-modal .js-location-select' ).eq(0).attr( 'data-default-location-lat' ),
			defaultLong = $( '#js-location-modal .js-location-select' ).eq(0).attr( 'data-default-location-long' ),
			initialCoords = { lat: parseFloat( defaultLat ), lng: parseFloat( defaultLong ) };
		$jsonEle = $( '.js-location-details-data' );
		if ( $jsonEle.length > 0 ) {

			locationDetails.locationData = JSON.parse( $jsonEle.eq(0).html() );
		} else {

			// Kill script if there is no location data
			return false;
		}


		$( document ).on( 'ssLocationCookieChange', function( event, locationId ) {
			var newLocation = locationDetails.getLocationById( locationId );
			$( '.js-location-details-title h3' ).html( newLocation.post_title );
			$( '.js-location-details-address p' ).html( newLocation.full_address );
			$( '.js-location-details-address a' )
				.attr( 'href', 'https://www.google.com/maps/search/?api=1&query=SecureSet+' + newLocation.city );
			$( '.js-location-details-phone' ).html( newLocation.phone ).attr( 'href', 'tel:' + newLocation.phone );
			$( '.js-location-details-email' ).html( newLocation.email ).attr( 'href', 'email:' + newLocation.email );
		} );

		// Set the map custom map marker icon to n object property
		locationDetails.mapMarkerIcon = {
			url: scriptData.stylesheetDirURI + '/assets/img/map_pin.svg',
			scaledSize: new google.maps.Size( 23, 36 ),
			origin: new google.maps.Point( 0, 0 ),
			anchor: new google.maps.Point( 0, 0 )
		};

		$( '.js-location-details-map' ).each( function() {
			var $this = $( this );

			var map = new google.maps.Map( $this[0], {
				zoom: 14,
				center: initialCoords,
				disableDefaultUI: true,
				draggable: false,
				styles: [{"stylers":[{"saturation":-100}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#25323b"}]},{"featureType":"administrative","elementType":"labels.icon","stylers":[{"color":"#22313d"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#22313d"}]},{"featureType":"landscape","elementType":"labels.text.fill","stylers":[{"color":"#27343a"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#e4e8e9"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#dee5eb"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"geometry.stroke","stylers":[{"color":"#6a8096"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#27323c"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#f8f9fa"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#25323b"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#637e94"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#becee1"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#92aeca"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#25323a"}]},{"featureType":"road.highway.controlled_access","elementType":"labels.text.fill","stylers":[{"color":"#698197"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#70828e"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#bfd2e6"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]
			});

			// Push this map into the maps array
			locationDetails.maps.push( map );

			var marker = new google.maps.Marker({
				position: initialCoords,
				map: map,
				icon: locationDetails.mapMarkerIcon
			});

			// Push this marker into the markers array
			locationDetails.markers.push( marker );

			// Display this marker on the map
			marker.setMap( map );
		} );

		$( document ).on( 'ssLocationCookieChange', function() {

			// Clear out the markers
			for (var i = 0; i < locationDetails.markers.length; i++) {
				locationDetails.markers[i].setMap( null );
			}

			// Make a new marker
			var newLat = $( '#js-location-modal .js-location-select' ).eq(0).find( 'option:selected' ).attr( 'data-lat' ),
				newLong = $( '#js-location-modal .js-location-select' ).eq(0).find( 'option:selected' ).attr( 'data-long' ),
				newCoords = { lat: parseFloat( newLat ), lng: parseFloat( newLong ) };

			// Loop through all maps on the page and put the markers on them
			for (var i = 0; i < locationDetails.maps.length; i++) {
				var thisMap = locationDetails.maps[i];
				var marker = new google.maps.Marker({
					position: newCoords,
					map: thisMap,
					icon: locationDetails.mapMarkerIcon
				});

				// Display marker on the map
				marker.setMap( thisMap );

				// Push this marker back into the array of markers for deletion later on
				locationDetails.markers.push( marker );

				// pan that map
				thisMap.panTo( newCoords );
			}
		});
	}
}
module.exports = locationDetails.init();
