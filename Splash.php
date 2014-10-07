<?php
/**
 * Splash skin - created from the bones of monobook and nimbus
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Skins
 * @author Calimonius the Estrange
 * @authors Whoever wrote monobook
 * @date 2014
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

# Skin credits that will show up on Special:Version

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'Splash skin',
	'version' => '0.6',
	'author' => array( 'Calimonius the Estrange' ),
	'descriptionmsg' => 'splash-skin-desc',
	'url' => 'https://www.mediawiki.org/wiki/Skin:Splash',
);

$skinID = basename( dirname( __FILE__ ) );
$dir = dirname( __FILE__ ) . '/';

# Autoload the skin class, make it a valid skin, set up i18n

# The first instance must be strtolower()ed so that useskin=nimbus works and
# so that it does *not* force an initial capital (i.e. we do NOT want
# useskin=Splash) and the second instance is used to determine the name of
# *this* file.
$wgValidSkinNames[strtolower( $skinID )] = 'Splash';

$wgAutoloadClasses['SkinSplash'] = $dir . 'Splash.skin.php';
$wgMessagesDirs['SkinSplash'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SkinSplash'] = $dir . 'Splash.i18n.php';
$wgResourceModules['skins.splash'] = array(
	'styles' => array(
		"skins/$skinID/resources/normalise.css" => array( 'media' => 'screen' ),
		"skins/$skinID/resources/externallinks.css" => array( 'media' => 'screen' ),
		"skins/$skinID/resources/fonts.css" => array( 'media' => 'screen' ),
		"skins/$skinID/resources/main.less" => array( 'media' => 'screen' )
	),
	'scripts' => "skins/$skinID/resources/main.js",
	'position' => 'top'
);
