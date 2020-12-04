<?php
/**
 * SkinTemplate class for the Splash skin
 *
 * @ingroup Skins
 */
class SkinSplash extends SkinTemplate {
	public $stylename = 'splash',
		$template = 'SplashTemplate';

	/**
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		// Add JS (mobile, etc)
		$out->addModules( 'skins.splash.js' );

		// Special mainpage styles
		$config = $this->getConfig();
		$title = $this->getTitle();
		$action = $this->getRequest()->getVal( 'action', 'view' );
		if ( $title->isMainPage() && $action == 'view' && $config->get( 'SplashUseNewMainPage' ) ) {
			$out->addModuleStyles( 'skins.splash.mainpage' );
		}
	}

	/**
	 * Handler for ResourceLoaderRegisterModules hook
	 *
	 * @param ResourceLoader $resourceLoader
	 */
	public static function registerCustomMainPageStyles( ResourceLoader $resourceLoader ) {
		$config = $resourceLoader->getConfig();

		if ( $config->get( 'SplashUseNewMainPage' ) ) {
			$resourceLoader->register( 'skins.splash.mainpage', [
				'localBasePath' => __DIR__ . '/..',
				'remoteSkinPath' => 'Splash',
				'targets' => [ 'desktop', 'mobile' ],
				'styles' => [ 'resources/mainpage.less' ]
			] );
		}
	}
}
