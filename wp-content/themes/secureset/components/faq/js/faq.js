var faq = {
	init : function() {
		var self = this;
		$( '.faq__tab' ).on( 'click', self.tabChange );
		$( '#faq-select' ).on( 'change', self.selectChange );
		$( document ).ready( self.initialTab );
	},
	tabChange : function( e ) {
		$( '.faq__list-item-checkbox' ).prop( 'checked', false );
		$( '.current-faq-tab' ).removeClass( 'current-faq-tab' );
		$( '.current-faq-list' ).removeClass( 'current-faq-list' );

		$( '#faq-selected' ).val( e.target.dataset.faqTab );
		$( '#faq-selected span' ).text( $( e.target ).text() );

		$( e.target ).addClass( 'current-faq-tab' );
		$( '#faq-list-' + e.target.dataset.faqTab ).addClass( 'current-faq-list' );
	},
	selectChange : function( e ) {
		$( '.faq__list-item-checkbox' ).prop( 'checked', false );
		$( '.current-faq-tab' ).removeClass( 'current-faq-tab' );
		$( '.current-faq-list' ).removeClass( 'current-faq-list' );

		$( '#faq-selected' ).val( e.target.value );
		$( '#faq-selected span' ).text( $( e.target ).find( "option:selected" ).text() );

		$( '.faq__tab:eq('+ e.target.value +')' ).addClass( 'current-faq-tab' );
		$( '#faq-list-' + e.target.value ).addClass( 'current-faq-list' );
	},
	initialTab : function() {
		$( '.faq__tab' ).first().addClass( 'current-faq-tab' ).trigger( 'click' );
		$( '#faq-list-0' ).addClass( 'current-faq-list' );
	}
}
module.exports = faq.init();
