<?php
/**
 * BaseTemplate class for the Splash skin
 *
 * @ingroup Skins
 */
class SplashTemplate extends BaseTemplate {

	/**
	 * Outputs the entire contents of the page
	 */
	function execute() {
		// Open <html>, body elements, etc.
		$html = $this->get( 'headelement' );

		$html .= Html::openElement( 'div', [ 'id' => 'globalWrapper' ] );
		$html .= Html::openElement( 'div', [ 'id' => 'container-top' ] );
		$html .= Html::openElement( 'div', [ 'id' => 'container-top-l1' ] );
		$html .= Html::openElement( 'div', [ 'id' => 'container-top-l2' ] );
		$html .= Html::openElement( 'div', [ 'id' => 'container-bottom' ] );

		$html .= Html::rawElement( 'div', [ 'id' => 'container-content' ],
			Html::rawElement(
				'div',
				[ 'id' => 'header', 'class' => [ 'noprint', $this->get( 'userlangattributes' ) ] ],
				$this->getGlobalLinks() .
				Html::rawElement(
					'div',
					[ 'id' => 'site-links' ],
					$this->getPersonalToolsBlock() .
					Html::rawElement( 'div', [ 'id' => 'site-navigation' ],
						$this->getMainNavigation()
					) .
					$this->getSearchBox() .
					Html::rawElement( 'div', [ 'id' => 'main-logo', 'role' => 'banner' ],
						Html::rawElement(
							'a',
							[ 'class' => [ 'mw-wiki-title' ], 'href' => htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ],
							Html::rawElement( 'div', [ 'id' => 'mainlogo-text' ],
								Html::rawElement( 'h1', [], $this->getMsg( 'site-banner' )->text() )
							)
						)
					)
				)
			) .
			Html::rawElement( 'div', [ 'id' => 'page-content' ],
				Html::rawElement( 'div', [ 'id' => 'content-container' ],
					Html::rawElement(
						'div',
						[ 'id' => 'content', 'class' => 'mw-body-primary', 'role' => 'main' ],
						Html::element( 'a', [ 'id' => 'top' ] ) .
						$this->getIndicators() .
						$this->getSiteNotices() .
						Html::rawElement(
							'h1',
							[
								'id' => 'firstHeading',
								'class' => 'firstHeading',
								'lang' => $this->get( 'pageLanguage' )
							],
							$this->getCactions() .
							$this->get( 'title' )
						) .
						$this->getSiteSubChrome() .
						Html::rawElement( 'div', [ 'id' => 'bodyContent', 'class' => 'mw-body' ],
							Html::rawElement(
								'div',
								[ 'id' => 'siteSub' ],
								$this->getMsg( 'tagline' )->parse()
							) .
							$this->get( 'bodytext' ) .
							$this->getClear() .
							$this->getCategoryBlock() .
							$this->getDataAfterContent()
						) .
						Html::rawElement( 'div', [ 'id' => 'content-footer' ],
							$this->getMsg( 'content-footer' )->parse()
						)
					)
				)
			) .
			Html::rawElement(
				'div',
				[ 'id' => 'footer' ],
				$this->getFooter()
			)
		);

		$html .= Html::closeElement( 'div' );
		$html .= Html::closeElement( 'div' );
		$html .= Html::closeElement( 'div' );
		$html .= Html::closeElement( 'div' );
		$html .= Html::closeElement( 'div' );

		$html .= $this->getTrail();
		$html .= Html::closeElement( 'body' );
		$html .= Html::closeElement( 'html' );

		// The unholy echo
		echo $html;
	}

	/**
	 * Menu for global navigation (for cross-wiki stuff or just whatever things)
	 *
	 * @return string HTML
	 */
	protected function getGlobalLinks() {
		$html = '';
		if ( $this->getMsg( 'global-links-menu' )->escaped() ) {
			$html = Html::rawElement(
				'div',
				[ 'id' => 'global-links', 'class' => 'mw-portlet', 'role' => 'navigation' ],
				$this->getNavigation( 'global-links-menu', 'global-links-menu-header' )
			);
		}

		return $html;
	}

	/**
	 * Personal tools dropdown information
	 *
	 * @return string HTML
	 */
	protected function getPersonalToolsBlock() {
		$user = $this->getSkin()->getUser();

		$personalToolsMsg = 'personaltools';
		$personalToolsClass = 'not-logged-in';
		if ( $user->isLoggedIn() ) {
			$personalToolsMsg = [ 'splash-personaltools', $user->getName() ];
			$personalToolsClass = 'logged-in';
		}

		return $this->getPortlet( 'personal', $this->getPersonalTools(), $personalToolsMsg, $personalToolsClass );
	}

	/**
	 * Categories
	 *
	 * @return string HTML
	 */
	protected function getCategoryBlock() {
		$html = '';
		if ( $this->data['catlinks'] ) {
			$html = $this->get( 'catlinks' );
		}

		return $html;
	}

	/**
	 * Site subtitle, undelete stuff, etc
	 *
	 * @return string HTML
	 */
	protected function getSiteSubChrome() {
		$html = '';
		if ( $this->data['subtitle'] || $this->data['undelete'] ) {
			$html .= Html::rawElement( 'div', [ 'id' => 'contentSub' ],
				$this->get( 'subtitle' )
			);
			if ( $this->data['undelete'] ) {
				$html .= Html::rawElement( 'div', [ 'id' => 'contentSub2' ],
					$this->get( 'undelete' )
				);
			}
		}

		return $html;
	}

	/**
	 * I'm not actually sure what this is, but all skins have it
	 *
	 * @return string HTML
	 */
	protected function getDataAfterContent() {
		$html = '';
		if ( $this->data['dataAfterContent'] ) {
			$html = $this->get( 'dataAfterContent' );
		}

		return $html;
	}

	/**
	 * Notices that may appear above the firstHeading
	 *
	 * @return string HTML
	 */
	protected function getSiteNotices() {
		$html = '';

		if ( $this->data['sitenotice'] ) {
			$html .= Html::rawElement( 'div', [ 'id' => 'siteNotice' ], $this->get( 'sitenotice' ) );
		}
		if ( $this->data['newtalk'] ) {
			$html .= Html::rawElement( 'div', [ 'class' => 'usermessage' ], $this->get( 'newtalk' ) );
		}

		return $html;
	}

	/**
	 * Print arbitrary block of navigation
	 * Message parsing is limited to first 10 lines only for this skin.
	 *
	 * @param string $linksMessage
	 * @param string $id
	 */
	protected function getNavigation( $linksMessage, $id ) {
		$message = trim( $this->getMsg( $linksMessage )->text() );
		$lines = array_slice( explode( "\n", $message ), 0, 10 );
		$links = [];
		foreach ( $lines as $line ) {
			// ignore empty lines
			if ( strlen( $line ) == 0 ) {
				continue;
			}
			$links[] = $this->parseItem( $line );
		}

		return $this->getPortlet( $id, $links );
	}

	/**
	 * Extract the link text and target (href) from a MediaWiki message
	 * and return them as an array.
	 * Follows general MediaWiki:Sidebar format: $1|$2|$3
	 * 	$1 - link target (full URL or internal page target, or MW
	 * 	     message containing either of these)
	 * 	$2 - display text (plain text or MW message)
	 * 	$3 - CSS class to apply to item
	 *
	 * @param string $line
	 *
	 * @return array $item
	 */
	protected function parseItem( $line ) {
		$item = [];

		$line_temp = explode( '|', trim( $line, '* ' ), 3 );
		if ( count( $line_temp ) > 1 ) {
			$line = $line_temp[1];
			$link = $this->getMsg( $line_temp[0] )->inContentLanguage()->text();

			// Pull out third item as a class
			if ( count( $line_temp ) == 3 ) {
				$item['class'] = Sanitizer::escapeClass( $line_temp[2] );
			}
		} else {
			$line = $line_temp[0];
			$link = $line_temp[0];
		}
		$item['id'] = Sanitizer::escapeIdForAttribute( $line );

		// Determine what to show as the human-readable link description
		if ( $line == 'zaori-link' ) {
			// Daji time
			$item['text'] = '';
		} elseif ( $this->getMsg( $line )->isDisabled() ) {
			// It's *not* the name of a MediaWiki message, so display it as-is
			$item['text'] = $line;
		} else {
			// Guess what -- it /is/ a MediaWiki message!
			$item['text'] = $this->getMsg( $line )->text();
		}

		if ( $link != null ) {
			if ( $this->getMsg( $line_temp[0] )->isDisabled() ) {
				$link = $line_temp[0];
			}
			if ( Skin::makeInternalOrExternalUrl( $link ) ) {
				$href = $link;
			} else {
				$title = Title::newFromText( $link );
				if ( $title ) {
					$title = $title->fixSpecialName();
					$href = $title->getLocalURL();
				}
			}
		}
		$item['href'] = $href ?? '#';

		return $item;
	}

	/**
	 *
	 * @return string HTML
	 */
	protected function getMainNavigation() {
		$sidebar = $this->getSidebar();
		$html = '';

		// Add toolbox and languages at end if not specified earlier
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					// Already hardcoded into header
					break;
				case 'TOOLBOX':
					$toolbox = $this->getToolbox();
					$title = $this->getSkin()->getTitle();

					// add purge
					$toolbox['purge'] = [
						'text' => $this->getMsg( 'splash-purge' )->text(),
						'href' => $title->getLocalURL( [ 'action' => 'purge' ] ),
						'rel' => 'nofollow',
						'id' => 't-purge'
					];

					$html .= $this->getPortlet( 'tb', $toolbox, 'toolbox' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] !== false ) {
						$html .= $this->getPortlet( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$html .= $this->getPortlet( $name, $content['content'] );
			}
		}

		return $html;
	}

	/**
	 * Generate the search form for the top of the page
	 *
	 * @return string HTML
	 */
	protected function getSearchBox() {
		$html = '';

		$html .= Html::openElement( 'div', [ 'id' => 'p-search', 'class' => 'mw-portlet', 'role' => 'search' ] );

		$html .= Html::rawElement(
			'h3',
			[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ],
			Html::rawElement( 'label', [ 'for' => 'searchInput' ], $this->getMsg( 'search' )->text() )
		);

		$html .= Html::rawElement( 'form', [ 'action' => $this->get( 'wgScript' ), 'id' => 'searchform' ],
			Html::rawElement( 'div', [ 'id' => 'simpleSearch' ],
				$this->makeSearchInput( [ 'id' => 'searchInput', 'type' => 'text' ] ) .
				Html::hidden( 'title', $this->get( 'searchtitle' ) ) .
				$this->makeSearchButton(
					'go',
					[ 'id' => 'searchGoButton', 'class' => 'searchButton' ]
				) .
				$this->makeSearchButton(
					'fulltext',
					[ 'id' => 'mw-searchButton', 'class' => [ 'searchButton', 'mw-fallbackSearchButton' ] ]
				)
			)
		);

		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Prints the cactions bar.
	 *
	 * @return string HTML
	 */
	protected function getCactions() {
		return $this->getPortlet( 'cactions', $this->data['content_actions'], 'actions' );
	}

	/**
	 * Generates a block of navigation links with a header
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 * @param null|string|array|bool $msg
	 * @class string $class CSS class to add
	 *
	 * @return string HTML
	 */
	protected function getPortlet( $name, $content, $msg = null, $class = '' ) {
		if ( $msg === null ) {
			$msg = $name;
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		}
		$msgObj = $this->getMsg( $msg );
		if ( $msgObj->exists() ) {
			if ( isset( $msgParams ) && !empty( $msgParams ) ) {
				$msgString = $this->getMsg( $msg, $msgParams )->parse();
			} else {
				$msgString = $msgObj->parse();
			}
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul' );
			foreach ( $content as $key => $item ) {
				$contentText .= $this->makeListItem(
					$key,
					$item,
					[ 'text-wrapper' => [ 'tag' => 'span' ] ]
				);
			}
			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		$html = Html::rawElement( 'div', [
				'role' => 'navigation',
				'class' => [ 'mw-portlet', $class ],
				'id' => Sanitizer::escapeIdForAttribute( 'p-' . $name ),
				'title' => Linker::titleAttrib( 'p-' . $name ),
				'aria-labelledby' => $labelId
			],
			Html::rawElement( 'h3', [
					'id' => $labelId,
					'lang' => $this->get( 'userlang' ),
					'dir' => $this->get( 'dir' )
				],
				$msgString
			) .
			Html::rawElement( 'div', [ 'class' => 'mw-portlet-body' ],
				$contentText .
				$this->getAfterPortlet( $name )
			)
		);

		return $html;
	}
}
