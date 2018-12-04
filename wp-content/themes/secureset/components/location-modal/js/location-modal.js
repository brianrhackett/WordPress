var cookie = require( 'js-cookie' );

var locationModal = {
	markers : [],
	map: null,
	mapMarkerIcon: null,
	init: function() {
		var locationCookie = cookie.get( 'secureset_location' );
		$( '#js-location-modal' ).find( '.js-location-select select' ).trigger( 'change' );
		// If no cookie, fire the popup
		if ( typeof locationCookie === 'undefined' ) {

			// Set up some vars for init
			var	defaultLat = $( '#js-location-modal .js-location-select' ).eq(0).attr( 'data-default-location-lat' ),
				defaultLong = $( '#js-location-modal .js-location-select' ).eq(0).attr( 'data-default-location-long' ),
				initialCoords = { lat: parseFloat( defaultLat ), lng: parseFloat( defaultLong ) };

			// Set the map object as an object property
			locationModal.map = new google.maps.Map( $( '#js-location-modal-map' )[0], {
				zoom: 5,
				center: initialCoords,
				disableDefaultUI: true,
				zoomControl: true,
				draggable: false,
				styles: [{"stylers":[{"saturation":-100}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#25323b"}]},{"featureType":"administrative","elementType":"labels.icon","stylers":[{"color":"#22313d"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#22313d"}]},{"featureType":"landscape","elementType":"labels.text.fill","stylers":[{"color":"#27343a"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#e4e8e9"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#dee5eb"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"geometry.stroke","stylers":[{"color":"#6a8096"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#27323c"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#f8f9fa"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#25323b"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#637e94"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#becee1"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#92aeca"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#25323a"}]},{"featureType":"road.highway.controlled_access","elementType":"labels.text.fill","stylers":[{"color":"#698197"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#70828e"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#bfd2e6"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]
			});

			// Set the map custom map marker icon to n object property
			locationModal.mapMarkerIcon = {
				url: scriptData.stylesheetDirURI + '/assets/img/map_pin.svg',
				scaledSize: new google.maps.Size(23, 36),
				origin: new google.maps.Point(0,0),
				anchor: new google.maps.Point(0, 0)
			};
			locationModal.addMarker( initialCoords );
			locationModal.setMapOnAll( locationModal.map );

			// Fancybox stuff
			var $locationHtml = $( '#js-location-modal' );
			$.fancybox.open( $locationHtml, {
				baseClass: 'location-modal-fancybox',
				beforeClose: function() {
					$( '#js-location-modal' ).find( '.js-location-select select' ).trigger( 'change' );
				}
			});

			// Modal button logic
			$( '.js-location-modal-button' ).on( 'click', function() {
				$( '#js-location-modal' ).find( '.js-location-select select' ).trigger( 'change' );
				$.fancybox.close( true );
			});

			// Small hack to accomodate dropdown panes that are nowhere near the dropdown trigger
			$( '.js-location-select-menu-pane a' ).on( 'click', function() {
				$( '.js-location-select__trigger[data-toggle="' + $( this ).closest( '.js-location-select-menu-pane' ).attr( 'id' ) + '"]' ).html( $( this ).html() );
			});

			// Pan map when a location is selected from the location dropdown and delete markers
			$( '#js-location-modal .js-location-select select' ).on( 'change', function() {
				var newLat = $( this ).find( ':selected' ).attr( 'data-lat' ),
					newLong  = $( this ).find( ':selected' ).attr( 'data-long' ),
					newCoords = { lat: parseFloat( newLat ), lng: parseFloat( newLong ) };

				locationModal.deleteMarkers();
				locationModal.addMarker( newCoords );
				locationModal.setMapOnAll( locationModal.map );
				locationModal.panTo( newCoords );
			});
		}

	},

	// Loops through the markers and sets them to the map
	setMapOnAll: function( map ) {
		for (var i = 0; i < locationModal.markers.length; i++) {
			locationModal.markers[i].setMap( map );
		}
	},

	// Adds a marker to the marker array
	addMarker: function( location ) {
		var marker = new google.maps.Marker({
			position: location,
			map: locationModal.map,
			icon: locationModal.mapMarkerIcon
		});
		locationModal.markers.push( marker );
	},

	// Removes all markers from the map
	deleteMarkers: function() {
		locationModal.setMapOnAll( null );
		locationModal.markers = [];
	},

	// Pans to a map location
	panTo: function( location ) {
		locationModal.map.panTo( location );
	}
}
module.exports = locationModal.init();
