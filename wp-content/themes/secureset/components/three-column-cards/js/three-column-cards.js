var threeColumnCards = {
	init : function() {
		var self = this;
		$( '.no-click' ).on( 'click', self.disableClick );
	},
	disableClick : function( e ) {
		e.preventDefault();
	}
}

module.exports = threeColumnCards.init();
