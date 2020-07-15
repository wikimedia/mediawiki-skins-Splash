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
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		$out->addMeta( 'viewport',
			'width=device-width, initial-scale=1.0, ' .
			'user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		// Add JS
		$out->addModules( 'skins.splash.js' );
	}
}
