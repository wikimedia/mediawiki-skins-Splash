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
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );

		# Add css/js
		$out->addModuleStyles( [
			'mediawiki.skinning.content.externallinks',
			'skins.splash'
		] );
		$out->addModuleScripts( 'skins.splash' );
	}

	/**
	 * Add CSS via ResourceLoader
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}
}
