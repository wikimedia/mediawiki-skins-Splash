<?php
/**
 * SkinTemplate class for the Splash skin
 *
 * @ingroup Skins
 */
class SkinSplash extends SkinTemplate {
	public $skinname = 'splash', $stylename = 'splash',
		$template = 'SplashTemplate';

	/**
	 * Set a necessary <meta> tag.
	 * This is also the place where we'd load JS if we had any custom JS, but we
	 * don't.
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );
	}

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		$out->addModuleStyles( [
			'mediawiki.skinning.content.externallinks',
			'skins.splash'
		] );
	}
}
