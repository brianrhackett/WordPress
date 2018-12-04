var formStack = {
	init : function() {
		const self = this;
		self.setupUpload();

		$( document ).bind( 'gform_post_render', function( event, form_id, current_page ) {
			self.setupUpload();

			$( 'html, body' ).animate( {
				scrollTop: $( '#gform_wrapper_' + form_id ).closest( '.form-stack' ).offset().top - $( '.site-header__wrap' ).height()
			}, 500 );

			// hide all spinners
			$( '.custom_gravity_forms_spinner' ).addClass( 'hidden' );

			// show the forms
			$( '.form-stack form' ).removeClass( 'overlay' );
		});

		$( document ).on( 'submit', '.gform_wrapper form', function() {
			var $this = $( this );
			$this.closest( '.form-stack' ).find( 'form' ).addClass( 'overlay' );
			// Show the spinner
			$this.closest( '.form-stack' ).find( '.custom_gravity_forms_spinner' ).removeClass( 'hidden' );
		});

		// Rework form so that only one Program dropdown actually exists within the form tag at a time
		$( document ).on( 'ready', function() {
			var $form = $( '#gform_12' );

			// Only active if form "Apply Now v3" exists
			if ( $form.length > 0 ) {
				var $placeholder = $( '<li class="vtg-gform-placeholder"></li>' ),
					$dump = $( '<div class="vtg-gform-dump"></div>' ).hide(),
					$location = $( 'select#input_12_9' );

				function changeInput( location ) {
					$placeholder.nextAll().remove();

					switch( location ) {
						case 'Denver':
							$placeholder.after( $dump.find( 'li#field_12_3' ).clone().show() );
							break;

						case 'Colorado Springs':
							$placeholder.after( $dump.find( 'li#field_12_11' ).clone().show() );
							break;

						case 'Tampa':
							$placeholder.after( $dump.find( 'li#field_12_10' ).clone().show() );
							break;
					}
				}

				// Create placeholders
				$( 'li#field_12_9' ).after( $placeholder );
				$form.after( $dump );

				// Move elements from form to dump
				$( 'li#field_12_3, li#field_12_11, li#field_12_10' ).detach().appendTo( $dump );
				changeInput( $location.val() );

				// On location change, replace the selected menu
				$location.on( 'change', function() {
					changeInput( $( this ).val() );
				});
			}
		});
	},

	/**
	 * Simple hash function
	 * 
	 */
	hash: function( s ) {
		
		var a = 1, 
			c = 0,
			h, 
			o;

		if ( s ) {
			a = 0;
			for ( h = s.length - 1; h >= 0; h-- ) {
				o = s.charCodeAt( h );
				a = ( a<<6&268435455 ) + o + ( o<<14 );
				c = a & 266338304;
				a = c!==0?a^c>>21:a;
			}
		}
		return String(a);
	},
	setupUpload: function() {

		// initialize selectboxit
		$( '.form-stack.light .gfield:not(".no-selectboxit") select' ).selectBoxIt({ downArrowIcon: 'down-arrow' });

		// initialize upload input
		$( '.form-stack input[type="file"]' ).change( function() {
			var $this = $( this ),
				$fileUploadStyleTag = $( '#js-file-upload-style');
			if ( ! $this[0].files.length ) {
				return false;
			}
			var filename = $this[0].files[0].name;
			var modified = $this[0].files[0].lastModified;
			var hash = formStack.hash( filename + modified );
			$this.closest( '.ginput_container_fileupload' ).addClass( 'js-' + hash );
			var styleContent = '.js-' + hash + '::after{ content: "' + filename + '" !important }';
			if ( $fileUploadStyleTag.length ) {
				$fileUploadStyleTag.html( styleContent );
			} else {
				$fileUploadStyleTag = $( '<style>' ).attr( 'id', 'js-file-upload-style' ).html( styleContent );
				$fileUploadStyleTag.appendTo( $( 'head' ) );
			}
		} );
	},
}

module.exports  = formStack.init();
