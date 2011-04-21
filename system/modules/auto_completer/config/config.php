<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  LU-Hosting 2010, CyberSpectrum 2010
 * @author     Leo Unglaub <leo@leo-unglaub.net>, Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    auto_completer 
 * @license    GNU/GPL 
 * @filesource
 */

	array_insert($GLOBALS['FE_MOD']['miscellaneous'], 1, array ('auto_completer' => 'ac_auto_completer'));

	$GLOBALS['TL_HOOKS']['dispatchAjax'][] = array('ac_auto_completer_response', 'ac_response');
	$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = array('ac_auto_completer_searchform', 'hook_search');

	// as a little tribute to christian schiffler's tl_debug i will be a good boy and initialize all vars in the AC core ;)
	if(!isset($GLOBALS['TL_CONFIG']['auto_completer']))
        $GLOBALS['TL_CONFIG']['auto_completer'] = array();

    $GLOBALS['TL_CONFIG']['auto_completer']['searchindex'] = array
    (
    	'hooklookup' => array('ac_search_index', 'keywords'),
    	'hookconfig' => array('ac_search_index', 'config'),
    );

?>