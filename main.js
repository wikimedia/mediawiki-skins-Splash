/**
 * JavaScript functions for Splash skin
 *
 */

/* Half-baked click-toggling for menus */
$( function() {
	$( '#site-navigation h3' ).click( function( event ) {
		if( ! $( this ).parent().hasClass( 'active' ) ) {
			// Remove all others first
			$( '#site-navigation .portlet' ).removeClass( 'active' );
		}
		// Show/hide dropdwon
		$( this ).parent().toggleClass( 'active' );
	} );

	$( document ).click( function( event ) {
		// Check if click is in a menu and hide any other menus if not
		if( $( event.target ).parents().index( $( '#site-navigation' ) ) == -1 ) {
			if( $( '#site-navigation .portlet' ).hasClass( 'active' ) ) {
				$( '#site-navigation .portlet' ).removeClass( 'active' );
			}
		}
	} );
} );
