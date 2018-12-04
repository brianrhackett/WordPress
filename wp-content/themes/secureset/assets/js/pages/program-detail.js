var cookie = require( 'js-cookie' );

var programDetail = {
	init: function() {
		var self = this;

		programDetail.otherProgramsDropdown();
		programDetail.programDetailsJump();

		$( '[data-value="full"]' ).click( function() {
			$( '.js-program-schedule' ).removeClass( 'active' );
			$( '.program-detail__schedule-section-schedule-container' ).removeClass( 'current-schedule' );
			$( '.js-program-schedule[data-schedule-type="full"]' ).addClass( 'active' );
			$( '#js-program-schedule-full' ).addClass( 'current-schedule' );
		});

		$( '[data-value="evening"]' ).click( function() {
			$( '.js-program-schedule' ).removeClass( 'active' );
			$( '.program-detail__schedule-section-schedule-container' ).removeClass( 'current-schedule' );
			$( '.js-program-schedule[data-schedule-type="evening"]' ).addClass( 'active' );
			$( '#js-program-schedule-evening' ).addClass( 'current-schedule' );
		});

		$( '.js-program-schedule' ).click( function() {
			$( '.js-program-schedule' ).removeClass( 'active' );
			$( '.program-detail__schedule-section-schedule-container' ).removeClass( 'current-schedule' );
			var selected = $( this ).data( 'schedule-type' );
			$( '#schedule-dropdown-label' ).text( selected === 'full' ? 'Full Time Schedule' : 'Evening Schedule' );
			$( this ).addClass( 'active' );
			$( '#js-program-schedule-' + selected ).addClass( 'current-schedule' );
		});
	},

	otherProgramsDropdown: function() {
		var $programDropdown = $( '#program-detail__op-dropdown' ),
			$dropdown = $programDropdown.find( '.program-detail__op-list' ),
			$button = $programDropdown.closest( '.program-detail__op-wrapper' ).find( 'a.btn' );

		$dropdown.on( 'click', 'a', function() {
			$button.attr( 'href', $( this ).attr( 'data-value' ) );
		});
	},

	programDetailsJump: function() {
		$( '#js-sidebar-info-link' ).on( 'click', function( event ) {
			event.preventDefault();
			var $scheduleTitle = $( '#js-schedule-title' );
			var headerStickyWrapHeight = $( '#js-header-sticky-wrap' ).outerHeight( true );
			$( 'html, body' ).animate({ scrollTop: ( $scheduleTitle.offset().top - headerStickyWrapHeight ) }, '50' );
		});
	}
};

module.exports = programDetail.init();
