/**
 * Wrapper function to safely use $
 */
function wpdWrapper( $ ) {
	var wpd = {

		/**
		 * Main entry point
		 */
		init: function () {
			wpd.prefix      = 'wpd_';
			wpd.templateURL = $( '#template-url' ).val();
			wpd.ajaxPostURL = $( '#ajax-post-url' ).val();

			wpd.registerEventHandlers();
		},

		/**
		 * Registers event handlers
		 */
		registerEventHandlers: function () {
			$( '#example-container' ).children( 'a' ).click( wpd.exampleHandler );
		},

		/**
		 * Example event handler
		 *
		 * @param object event
		 */
		exampleHandler: function ( event ) {
			alert( $( this ).attr( 'href' ) );

			event.preventDefault();
		}
	}; // end wpd

	$( document ).ready( wpd.init );

} // end wpdWrapper()

wpdWrapper( jQuery );
