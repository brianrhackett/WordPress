var cookie = require( 'js-cookie' );
var global = {

	init: function() {
		global.stickyMainNav();
		global.mobileHeaderNav();
		global.mobileFooterNav();
		global.footerCaptcha();
	},

	stickyMainNav: function() {
		var $stickyMainNav = $( '.site-header__wrap' ),
		    $stickyDiv = 'sticky',
			  $topBar = $( '.top-bar' ).height();

		$( window ).scroll( function() {
			if ( $( this ).scrollTop() > $topBar ) {
				$stickyMainNav.addClass( $stickyDiv );
			} else {
				$stickyMainNav.removeClass( $stickyDiv );
			}
		});
		$( window ).trigger( 'scroll' );
	},

	mobileHeaderNav: function() {
		$( '#js-hamburger-mobile' ).on( 'click', function() {
			$( this ).toggleClass( 'is-active' );
			$( '.mobile-nav' ).toggleClass( 'is-active' );
			$( 'body' ).toggleClass( 'mobile-menu-active' );
			$( '.mobile-menu-mask' ).toggleClass( 'is-active' );
		});
	},

	mobileFooterNav: function() {
		function toggleMobileFooter() {
			var $mFooterNav = $( '.js-footer__nav--mobile' );
			if ( $mFooterNav.hasClass( 'footer__nav--expanded' ) ) {
				$mFooterNav.removeClass( 'footer__nav--expanded' );
			} else {
				$mFooterNav.addClass( 'footer__nav--expanded' );
			}
		}

		$( '.js-footer__nav--toggle' ).on( 'click', function() {
			toggleMobileFooter();
		});
	},

	footerCaptcha: function() {
		$( '.footer__contact-form .ginput_container_email' ).on( 'click', function() {
			$( '.ginput_container.ginput_recaptcha' ).show();
			$( '.footer__contact-form' ).addClass( 'captcha-focus' );
			$( '.footer__social' ).addClass( 'captcha-focus-social' );
		});

		if ( $( '.gfield_description.validation_message' ).is( ':visible' ) ) {
			$( '.ginput_container.ginput_recaptcha' ).show();
			$( '.footer__contact-form' ).addClass( 'captcha-focus' );
			$( '.footer__social' ).addClass( 'captcha-focus-social-error' );
		}
	}
};

module.exports = global.init();
