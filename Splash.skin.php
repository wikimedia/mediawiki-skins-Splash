<?php
/**
 * SkinTemplate class for the Splash skin
 *
 * @ingroup Skins
 */
class SkinSplash extends SkinTemplate {
	public $skinname = 'splash', $stylename = 'splash',
		$template = 'SplashTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		global $wgFontCSSLocation;
		parent::setupSkinUserCss( $out );

		# Add css/js
		$out->addModuleStyles( array (
			'mediawiki.skinning.content.externallinks',
			'skins.splash'
		) );
		$out->addModuleScripts( 'skins.splash' );
	}
}
