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
	'version' => '0.5.1',
	'author' => array( 'Calimonius the Estrange' ),
	'descriptionmsg' => 'splash-skin-desc',
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
$wgExtensionMessagesFiles['SkinSplash'] = $dir . 'Splash.i18n.php';
$wgResourceModules['skins.splash'] = array(
	'styles' => array(
		"skins/$skinID/main.less" => array( 'media' => 'screen' )
	),
	'scripts' => "skins/$skinID/main.js",
	'position' => 'top'
);

# Add fallback for no fonts (technically the default, but as a mediawiki
# developer I reserve the right to do ridiculous backwards things)
if ( !isset( $wgFontCSSLocation ) ) {
	$wgResourceModules['skins.splash']['styles'][] = "skins/$skinID/fallback.less";
}
