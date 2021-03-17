/* JavaScript for the splash skin */

// Don't use Libertinus sans/biolinum for content on low-res windows (massive over-bolding)
$( function () {
	if ( navigator.appVersion.indexOf( 'Win' ) !== -1 && window.devicePixelRatio < 1.5 ) {
		$( 'body' ).addClass( 'windows-fonts' );
	}
} );

// Mobile popups
$( function () {
	var toggleTime = 200,
		mobileMediaQuery = window.matchMedia( 'screen and (max-width: 699px)' ),
		toggled = false,
		toggles = {
			// TODO: Lose the special toggle handles and just use the headers like on desktop
			'#global-menu-toggle': '#p-global-links',
			'#main-menu-toggle': '#mw-sidebar',
			'#toolbox-toggle': '#p-tb',
			'#personal-menu-toggle': '#p-personal',
			// TODO: Automatically just do all #page-tools-dropdowns items
			'#p-page-tools-label': '#p-page-tools .mw-portlet-body',
			'#p-lang-label': '#p-lang .mw-portlet-body',
			'#p-variants-label': '#p-variants .mw-portlet-body',
			'#p-coll-print_export-label': 'p-coll-print_export .mw-portlet-body'
		};

	// Special main page handling; no special toggles, whoo!
	if ( $( '.splash-mainpage' ).length ) {
		toggles = {
			'#p-personal-label': '#p-personal .mw-portlet-body',
			'#p-lang-label': '#p-lang .mw-portlet-body',
			'#mw-sidebar h2': '#sidebar-inner',
			'#mw-tools h2': '#tools-inner'
		};
	}

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

// Desktop click toggles
$( function () {
	// all possible toggle items
	var allDropdowns = '#p-personal, #p-lang, #mw-sidebar, #mw-tools, '
		+ '#mw-sidebar .mw-portlet, #p-tb, #page-tools-dropdowns .mw-portlet';

	$( allDropdowns ).click( function( e ) {
		var dropdowns= '', toggles = '';

		// Okay, what actually are our current dropdowns?
		if ( window.matchMedia( 'screen and (min-width: 700px)' ).matches ) {
			if ( $( '.splash-mainpage' ).length ) {
				dropdowns = '#p-personal, #p-lang, #mw-sidebar, #mw-tools';
				toggles = '#p-personal-label, #p-lang-label, h2';
			} else if ( window.matchMedia( 'screen and (min-width: 1001px)' ).matches ) {
				// all sidebar items separate dropdowns
				dropdowns = '#p-personal, #mw-sidebar .mw-portlet, #p-tb, #page-tools-dropdowns .mw-portlet';
				toggles = '#p-personal-label, #mw-sidebar .mw-portlet > h3, #p-tb-label, #page-tools-dropdowns .mw-portlet > h3';
			} else {
				// sidebar as single dropdown
				dropdowns = '#p-personal, #mw-sidebar, #p-tb, #page-tools-dropdowns .mw-portlet';
				toggles = '#p-personal-label, h2, #p-tb-label, #page-tools-dropdowns .mw-portlet > h3';
			}
		}

		// We got here from all possible dropdowns; make sure this is a current dropdown
		if ( $( dropdowns ).is( this ) ) { // or: Is this in dropdowns?
			// Check if it's already open so we don't open it again
			if ( $( this ).hasClass( 'dropdown-active' ) ) {
				if ( $( e.target ).closest( $( toggles ) ).length > 0 ) {
					// treat reclick on the header as a toggle
					closeOpen();
				}
				// Clicked inside an open menu; don't do anything
			} else {
				closeOpen();
				e.stopPropagation(); // stop hiding it!
				$( this ).addClass( 'dropdown-active' );
			}
		}
	} );

	$( document ).click( function ( e ) {
		if ( $( e.target ).closest( '.dropdown-active' ).length > 0 ) {
			// Clicked inside an open menu; don't close anything
		} else {
			closeOpen();
		}
	} );

	// Just close everything, nobody cares.
	function closeOpen() {
		$( allDropdowns ).removeClass( 'dropdown-active' );
	}
} );

// TABLE SCROLLING WHOOO YEAH BABY (funky shadows edition)
$( function () {
	$content = $( '#content' );

	// Gotta wrap them for this to work; maybe later the parser etc will do this for us?!
	$content.find( 'div > table:not( table table )' ).wrap( '<div class="content-table-wrapper"><div class="content-table"></div></div>' );
	$content.find( '.content-table-wrapper' ).prepend( '<div class="content-table-left"></div><div class="content-table-right"></div>' );

	/**
	 * Set up borders for experimental overflowing table scrolling
	 *
	 * I have no idea what I'm doing.
	 *
	 * @param {jQuery} $table
	 */
	function setScrollClass( $table ) {
		var $tableWrapper = $table.parent(),
			$wrapper = $tableWrapper.parent(),
			// wtf browser rtl implementations
			scroll = Math.abs( $tableWrapper.scrollLeft() );

		// 1 instead of 0 because of weird rtl rounding errors or something
		if ( scroll > 1 ) {
			$wrapper.addClass( 'scroll-left' );
		} else {
			$wrapper.removeClass( 'scroll-left' );
		}

		if ( $table.outerWidth() - $tableWrapper.innerWidth() - scroll > 1 ) {
			$wrapper.addClass( 'scroll-right' );
		} else {
			$wrapper.removeClass( 'scroll-right' );
		}
	}

	$content.find( '.content-table' ).on( 'scroll', function () {
		setScrollClass( $( this ).children( 'table' ).first() );

		if ( $content.attr( 'dir' ) === 'rtl' ) {
			$( this ).find( 'caption' ).css( 'margin-right', Math.abs( $( this ).scrollLeft() ) + 'px' );
		} else {
			$( this ).find( 'caption' ).css( 'margin-left', $( this ).scrollLeft() + 'px' );
		}
	} );

	/**
	 * Mark overflowed tables for scrolling
	 */
	function unOverflowTables() {
		$content.find( '.content-table > table' ).each( function () {
			var $table = $( this ),
				$wrapper = $table.parent().parent();
			if ( $table.outerWidth() > $wrapper.outerWidth() ) {
				$wrapper.addClass( 'overflowed' );
				setScrollClass( $table );
			} else {
				$wrapper.removeClass( 'overflowed scroll-left scroll-right fixed-scrollbar-container' );
			}
		} );

		// Set up sticky captions
		$content.find( '.content-table > table > caption' ).each( function () {
			var $container, $containerContainer, tableHeight, captionHeight,
				$table = $( this ).parent(),
				$wrapper = $table.parent().parent();

			$container = $( this ).parents( '.content-table-wrapper' );
			$containerContainer = $container.parents( '.content-table-wrapper-wrapper' );

			if ( $table.outerWidth() > $wrapper.outerWidth() ) {
				$( this ).width( $content.width() );
				captionHeight = $( this ).outerHeight();
				tableHeight = $container.innerHeight() - captionHeight;

				// minus extra 12px to not cover table top shadow (nice random number)
				$container.find( '.content-table-left, .content-table-right' ).height( tableHeight - '12' );

				// dumb hack to kill shadows around captions
				$containerContainer.addClass( 'overflowed' );
				$containerContainer.find( '.caption-wrapper-left, .caption-wrapper-left, .caption-wrapper-right' ).height( captionHeight );
				$containerContainer.find( '.caption-wrapper-top' ).width( $content.width() );
			} else {
				$containerContainer.removeClass( 'overflowed' );
			}
		} );
	}

	/**
	 * Sticky scrollbars maybe?! Also some more fucking caption stuff.
	 */
	$content.find( '.content-table' ).each( function () {
		var $table, $tableWrapper, $spoof, $scrollbar;

		$tableWrapper = $( this );
		$table = $tableWrapper.children( 'table' ).first();

		// Assemble our silly crap and add to page
		$scrollbar = $( '<div>' ).addClass( 'content-table-scrollbar inactive' ).width( $content.width() );
		$spoof = $( '<div>' ).addClass( 'content-table-spoof' ).width( $table.outerWidth() );
		$tableWrapper.parent().prepend( $scrollbar.prepend( $spoof ) );

		if ( $table.hasClass( 'wikitable' ) ) {
			// Add spoofs to remove border shadows from ions
			if ( $table.children( 'caption' ).length ) {
				$tableWrapper.parent().wrap( '<div class="content-table-wrapper-wrapper wikitable-wrapper"></div>' );
				$tableWrapper.parent().parent().prepend(
					'<div class="caption-wrapper-left"></div>' +
					'<div class="caption-wrapper-right"></div>' +
					'<div class="caption-wrapper-top"></div>'
				);
			} else {
				$tableWrapper.parent().addClass( 'wikitable-wrapper' );
			}
		}
	} );

	unOverflowTables();
	$( window ).on( 'resize', unOverflowTables );

	/**
	 * Scoll table when scrolling scrollbar and visa-versa lololol wut
	 */
	$content.find( '.content-table' ).on( 'scroll', function () {
		// Only do this here if we're not already mirroring the spoof
		var $mirror = $( this ).siblings( '.inactive' ).first();

		$mirror.scrollLeft( $( this ).scrollLeft() );
	} );
	$content.find( '.content-table-scrollbar' ).on( 'scroll', function () {
		var $mirror = $( this ).siblings( '.content-table' ).first();

		// Only do this here if we're not already mirroring the table
		// eslint-disable-next-line no-jquery/no-class-state
		if ( !$( this ).hasClass( 'inactive' ) ) {
			$mirror.scrollLeft( $( this ).scrollLeft() );
		}
	} );

	/**
	 * Set active when actually over the table it applies to...
	 */
	function determineActiveSpoofScrollbars() {
		$content.find( '.overflowed .content-table' ).each( function () {
			var $scrollbar = $( this ).siblings( '.content-table-scrollbar' ).first(),
				tableTop, tableBottom, viewBottom, captionHeight;

			// Skip caption
			captionHeight = $( this ).find( 'caption' ).outerHeight();

			if ( !captionHeight ) {
				captionHeight = 0;
			} else {
				// Pad slightly for reasons
				captionHeight += 8;
			}

			tableTop = $( this ).offset().top;
			tableBottom = tableTop + $( this ).outerHeight();
			viewBottom = window.scrollY + document.documentElement.clientHeight;

			if ( tableTop + captionHeight < viewBottom && tableBottom > viewBottom ) {
				$scrollbar.removeClass( 'inactive' );
			} else {
				$scrollbar.addClass( 'inactive' );
			}
		} );
	}

	determineActiveSpoofScrollbars();
	$( window ).on( 'scroll resize', determineActiveSpoofScrollbars );

	/**
	 * Make sure tablespoofs remain correctly-sized?
	 */
	$( window ).on( 'resize', function () {
		$content.find( '.content-table-scrollbar' ).each( function () {
			var width = $( this ).siblings().first().find( 'table' ).first().width();
			$( this ).find( '.content-table-spoof' ).first().width( width );
			$( this ).width( $content.width() );
		} );
	} );
} );
