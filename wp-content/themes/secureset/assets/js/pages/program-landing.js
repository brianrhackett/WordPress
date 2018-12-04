var cookie = require( 'js-cookie' );

var programLanding = {
	init: function() {
		var self = this;

		// check for program data on page load
		$( document ).ready( function() {
			self.checkData();

			ga( 'send', 'pageview',
				window.location.protocol + '//' +
				window.location.hostname +
				window.location.pathname +
				window.location.hash
			);

			// check for program data on hashchange
			$( window ).on( 'hashchange', function() {
				self.checkData();

				ga( 'send', 'pageview',
					window.location.protocol + '//' +
					window.location.hostname +
					window.location.pathname +
					window.location.hash
				);

				var color = $( '#hero-search__dropdown-pane--interest option[selected="selected"]' ).attr( 'data-color' );
				self.colorize( color );
				self.replaceHeroHeadline( $( '#hero-search__dropdown-pane--interest option[selected="selected"]' ).attr( 'data-interest' ) );
			});

			// check for program data on hashchange
			$( document ).on( 'ssLocationCookieChange', function() {
				self.checkData();
			});
		});
	},
	colorize: function( color )  {
		var self = this;
		var $ele = $( '#js-program-type-style-block' );
		if ( $ele.length > 0 ) {
			var styles = $ele.html();
			var currentColor = $ele.attr( 'data-color' );
			$ele.attr( 'data-color', color );
			var regx = new RegExp( currentColor, 'g' );
			var rep = styles.replace( regx, color );
			rep = rep.replace( '#008aff', color + '; opacity: 0.8;' );
			$ele.html( rep );
		}
	},
	checkData: function() {

		// if the JSON data is available, parse and send to filter & dropdown setup
		var programLandingData = document.getElementById( 'js-program-landing-data' );
		if ( programLandingData ) {
			var programsJSON = JSON.parse( programLandingData.innerHTML );
			this.filterLocation( programsJSON );
			this.locationDropdownSetup( programsJSON );
		}
	},
	replaceHeroHeadline: function( headline ) {
		$( '#programs-landing-hero .hero__headline span' ).html( headline );
	},
	filterLocation: function( data ) {

		// empty the programs on the current page to refilter
		$( '#js-programs-landing' ).empty();

		// filter based on location cookie
		var filteredLocations = data.filter( function( program ) {
			return program.location.ID === parseInt( cookie.get( 'secureset_location' ) );
		});

		// send filtered data to be filtered by hash
		this.filterHash( filteredLocations );
	},
	filterHash: function( data ) {

		// filter by hash
		var hashedLocations = data.filter( function( program ) {
			return program.program_hash === window.location.hash;
		});

		$( '#js-program-landing-container' ).show();

		// if hash doesn't match, send unhashed data -- otherwise send hashed data
		if ( window.location.hash === '' ) {

			// Show all program types if there is no hash
			this.groupPrograms( data );
		} else if ( hashedLocations.length === 0 ) {

			// Show the no matches html
			this.showNoMatchesHtml();
		} else {
			this.colorize( $( '#hero-search__dropdown-pane--interest option[value="' + window.location.hash + '"]' ).attr( 'data-color' ) );
			this.replaceHeroHeadline( $( '#hero-search__dropdown-pane--interest option[value="' + window.location.hash + '"]' ).attr( 'data-interest' ) );

			// Show the program type based on the hash
			this.groupPrograms( hashedLocations );
		}
	},
	groupPrograms: function( data ) {

		// group programs by type
		var programsByType = {};
		data.forEach( function( program ) {
			if ( !programsByType[program.program_type]) {
				programsByType[program.program_type] = [];
			}
			programsByType[program.program_type].push( program );
		});

		this.groupTypes( programsByType );
	},
	groupTypes: function( data ) {
		var self = this;

		// Sort alphabetically and group types to be sent to structure data for templating
		Object.keys( data ).sort().forEach( function( key ) {
			self.structureTemplate( data[key]);
		});
	},
	structureTemplate: function( data ) {

		// create template meta data for each program
		var program = data[0];
		var section = {
			image: program.program_image,
			icon: program.program_icon,
			color: program.program_color,
			colorDark: this.colorLuminance( program.program_color, -0.45 ),
			city: program.location.post_title,
			nearestProgram: program.permalink,
			description: program.program_description,
			type: program.program_type,
			included: program.program_included,
			courses: program.program_courses,
			cohorts: data.map( function( x ) {
				return {
					cohort: x.cohort.season + ' ' + x.cohort.year,
					permalink: x.permalink,
					startDate: x.timestamp
				};
			})
		};

		// send formatted data with cohorts to be templated
		this.buildTemplate( section );
	},
	showNoMatchesHtml: function() {

		// Clear out the template
		this.renderTemplate( '<p class="text-center text-warning big">No courses found for this program type</p>' );
	},
	colorLuminance: function( hex, lum ) {

		// create a color darkener for hex code "theme" on each program
		// validate hex string
		hex = String( hex ).replace( /[^0-9a-f]/gi, '' );
		if ( hex.length < 6 ) {
			hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
		}
		lum = lum || 0;

		// convert to decimal and change luminosity
		var rgb = '#',
			c, i;
		for ( i = 0; i < 3; i++ ) {
			c = parseInt( hex.substr( i * 2, 2 ), 16 );
			c = Math.round( Math.min( Math.max( 0, c + ( c * lum ) ), 255 ) ).toString( 16 );
			rgb += ( '00' + c ).substr( c.length );
		}

		return rgb;
	},
	buildTemplate: function( section ) {

		// build html template and send template to be rendered
		var template = '<div class="programs-landing__program"><div class="programs-landing__top"><div class="programs-landing__img-section-container"><div class="programs-landing__img-section"><div class="programs-landing__img-bg" style="background-color: ' + section.colorDark + '"></div><div class="programs-landing__img" style="background-image: url(' + section.image.url + ')"></div></div></div><div class="programs-landing__info-section-container"><div class="programs-landing__info-section"><div class="programs-landing__info-bg" style="background-color: ' + section.color + '"></div><div class="programs-landing__info"><a href="' + section.nearestProgram + '" class="programs-landing__icon-container" style="background-color: ' + section.color + '"><div class="programs-landing__icon" style="background-image: url(' + section.icon.url + ')"></div></a><a href="' + section.nearestProgram + '"><h3 class="programs-landing__title" style="color: ' + section.color + '">' + section.type + '</h3></a><h2 class="programs-landing__location">(' + section.city + ')</h2><p class="programs-landing__description">' + section.description + '</p><h4 class="programs-landing__available-label">Available Dates:</h4>' + this.renderCohorts( section.cohorts, section.color ) + '</div></div></div></div><div class="programs-landing__bottom"><h4 class="programs-landing__courses-label">Modules:</h4><div class="programs-landing__courses">' + this.renderCourses( section.courses, section.color ) + '</div><div class="programs-landing__included"><h5 class="programs-landing__included-label">Included in this program:</h5><ul style="color:' + section.color + ';">' + this.renderIncluded( section.included ) + '</ul></div></div></div>';
		this.renderTemplate( template );
	},
	renderCohorts: function( cohorts, color ) {

		// sort by start date
		cohorts.sort( function( a, b ) {
			return a.startDate - b.startDate;
		});

		// render each cohort based on a given program type, and deeplink to detail cohort page
		return cohorts.map( function( cohort ) {
			return '<a href="' + cohort.permalink + '" class="programs-landing__date" style="color: ' + color + '">' + cohort.cohort + ' </a>';
		}).join( '' );
	},
	renderCourses: function( courses, color ) {
		var self = this;

		// render courses associated with each program type
		return courses.map( function( course ) {
			return '<span style="color:' + color + '" class="programs-landing__course-icon icon-' + course.icon + '"><span style="background-color:' + color + ';" class="programs-landing__course-title"><span class="programs-landing__course-title-caret" style="border-bottom: 15px solid ' + color + ';" ></span><p>' + course.name + ' </p></span></span>';
		}).join( '' );
	},
	renderIncluded: function( included ) {

		// render repeater field of included bullet points
		return included.map( function( item ) {
			return '<li class="programs-landing__included-item"><p>' + item.item + '</p></li>';
		}).join( '' );
	},
	renderTemplate: function( template ) {

		// append each programs template to the program landing page
		$( '#js-programs-landing' ).append( template );
	},
	locationDropdownSetup: function( programs ) {

		// set up location dropdown
		var $selected = $( '#program-selected' );
		var $list = $( '#program-select-list' );
		var $select = $( '#program-select' );
		var $cookie = parseInt( cookie.get( 'secureset_location' ) );
		var uniqueCities = [];

		var programCities = programs.map( function( program ) {
			return {
				ID: program.location.ID,
				city: program.location.post_title
			};
		});

		$list.empty();
		$select.empty();

		programCities.filter( function( city ) {
		  var i = uniqueCities.findIndex( function( uniqueCity ) {
				return uniqueCity.ID == city.ID;
			});
		  if ( i <= -1 ) {
				uniqueCities.push({
					ID: city.ID,
					city: city.city
				});
			}
		});

		if ( $cookie ) {
			$list.append( uniqueCities.map( function( city ) {
				return '<li class="js-programs-select-list-item programs-select-list-item" data-value="' + city.ID + '"><a>' + city.city + '</a></li>';
			}).join( '' ) );

			$select.append( uniqueCities.map( function( city ) {
				return '<option value="' + city.ID + '"' + ( city.ID === $cookie ? 'selected' : '' ) + '>' + city.city + '</option>';
			}).join( '' ) );

			$selected.text( uniqueCities.filter( function( city ) {
				return city.ID === $cookie;
			})[0].city );

			$( '.js-programs-select-list-item' ).each( function() {
				$( this ).click( function() {
					$( '.js-program-select' ).val( $( this ).data( 'value' ) ).trigger( 'change' );
				});
			});
		}
	}
};

module.exports = programLanding.init();
