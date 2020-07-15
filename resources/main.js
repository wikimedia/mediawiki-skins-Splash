/* JavaScript for the splash skin */

// Don't use Libertinus sans/biolinum for content on low-res windows (massive over-bolding)
$( function () {
	if ( navigator.appVersion.indexOf( 'Win' ) !== -1 && !window.devicePixelRatio < 1.5 ) {
		$( 'body' ).addClass( 'windows-fonts' );
	}
} );

// Mobile popups
$( function () {
	var toggleTime = 200,
		mobileMediaQuery = window.matchMedia( 'screen and (max-width: 699px)' ),
		toggled = false,
		toggles = {
			'#global-menu-toggle': '#p-global-links',
			'#main-menu-toggle': '#mw-sidebar',
			'#toolbox-toggle': '#p-tb',
			'#personal-menu-toggle': '#p-personal',
			'#p-page-tools-label': '#p-page-tools .mw-portlet-body',
			'#p-lang-label': '#p-lang .mw-portlet-body',
			'#p-variants-label': '#p-variants .mw-portlet-body',
			'#p-coll-print_export-label': 'p-coll-print_export .mw-portlet-body'
		};

	function setToggled() {
		if ( !toggled ) {
			// swap hide method from screen-reader-friendly .hidden to display:none,
			// as presumably people are actually poking a screen for this...
			$.each( toggles, function ( toggle, target ) {
				$( target ).hide();
				$( target ).addClass( 'toggled' );
			} );

			toggled = true;
		}
	}

	$.each( toggles, function ( toggle, target ) {
		$( toggle ).on( 'click', function () {
			if ( mobileMediaQuery.matches && $( toggle ).closest( '.emptyPortlet' ).length == 0 ) {
				setToggled();
				$( target ).fadeToggle( toggleTime );
				$( '#menus-cover' ).fadeToggle( toggleTime );
			}
		} );
	} );

	// Close menus on click outside
	$( document ).on( 'click touchstart', function ( e ) {
		if ( $( e.target ).closest( '#menus-cover' ).length > 0 ) {
			$( Object.values( toggles ).join( ', ' ) ).fadeOut( toggleTime );
			$( '#menus-cover' ).fadeOut( toggleTime );
		}
	} );
} );
