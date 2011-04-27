<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  sr-tag.de 2011 
 * @author     Sven Rhinow 
 * @package    myContaoSearchPortal 
 * @license    LGPL 
 * @filesource
 */

#$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/fr24shop/html/fr24shop.js';

// $GLOBALS['BE_FFL']['fr24shopVarWizard'] = 'fr24shopVarWizard';
// $GLOBALS['BE_FFL']['fr24shopProdOptionWizard'] = 'fr24shopProdOptionWizard';
// $GLOBALS['BE_FFL']['fr24shopImageQualityWizard'] = 'fr24shopImageQualityWizard';
// $GLOBALS['BE_FFL']['fr24shopProdConfPicsWizard'] = 'fr24shopProdConfPicsWizard';
// $GLOBALS['BE_FFL']['fr24shopShippingWizard'] = 'fr24shopShippingWizard';
// $GLOBALS['BE_FFL']['fr24shopDiscountWizard'] = 'fr24shopDiscountWizard';
// $GLOBALS['BE_FFL']['fr24shopAddressWizard'] = 'fr24shopAddressWizard';
// $GLOBALS['BE_FFL']['fr24shopVariantWizard'] = 'fr24shopVariantWizard';
// 
// $GLOBALS['TL_FFL']['fr24shopAddressWizard'] = 'fr24shopAddressWizard';


/**
 * Add back end modules
 */
#$GLOBALS['BE_MOD']=array_merge(array_slice($GLOBALS['BE_MOD'],0,1),$fr24,array_slice($GLOBALS['BE_MOD'],1,count($GLOBALS['BE_MOD'])));
array_insert($GLOBALS['BE_MOD'], 0, array('mcsp' => array()));


$GLOBALS['BE_MOD']['mcsp']['mcsp_categories'] = array
(
	'tables' => array('tl_mcsp_categories'),
	'icon'   => 'system/modules/myContaoSearchPortal/html/icons/games_hint.png'
);
$GLOBALS['BE_MOD']['mcsp']['mcsp_types'] = array
(
	'tables' => array('tl_mcsp_types'),
	'icon'   => 'system/modules/myContaoSearchPortal/html/icons/chart_pie.png'
);
$GLOBALS['BE_MOD']['mcsp']['mcsp_states'] = array
(
	'tables' => array('tl_mcsp_states'),
	'icon'   => 'system/modules/myContaoSearchPortal/html/icons/tag_blue.png'
);
$GLOBALS['BE_MOD']['mcsp']['mcsp_smallads'] = array
(
	'tables' => array('tl_mcsp_smallads'),
	'icon'   => 'system/modules/myContaoSearchPortal/html/icons/16-file-page.png'
);
$GLOBALS['BE_MOD']['mcsp']['mcsp_settings'] = array
(
	'tables' => array('tl_mcsp_settings'),
	'icon'   => 'system/modules/myContaoSearchPortal/html/icons/process.png'
);
#print_r($GLOBALS['BE_MOD']);
/**
 * Front-end module
 */

$GLOBALS['FE_MOD']['mcsp'] = array
	(
		'mcsp_categoriesmenu' 	=> 'ModuleCategorieMenu',
		'mcsp_searchbarcategories'=> 'ModuleCategoryShortTeaser',
		'mcsp_breadcrumb'=> 'ModuleBreadCrumb',
		'mcsp_searchbar'=>'ModuleSearchBar',
		'mcsp_adlist'=> 'ModuleAdList',
		'mcsp_addetailsbig'=> 'ModuleAdDetailsBig',
		'mcsp_addetailssidebar'=> 'ModuleAdDetailsSidebar',
	);
	

/**
 * Register hooks
 */

// $GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('fr24Shop', 'fr24ShopHandler'); 
// $GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('fr24Shop', 'Cartsession'); 
// $GLOBALS['TL_HOOKS']['activateAccount'][] = array('fr24Shop', 'setDefaultgroups'); 
// $GLOBALS['TL_HOOKS']['getSearchablePages'][] = array('myHelper', 'getSearchablePages');
// $GLOBALS['TL_HOOKS']['createNewUser'][] = array('fr24Shop', 'createNewUser');

/**
* CronJobs
*
*/
//aktuellen Status der Gutscheine setzen
// $GLOBALS['TL_CRON']['daily'][] = array('myHelper','setVoucherStatus');
// $GLOBALS['TL_CRON']['daily'][] = array('myHelper','setContestStatus');
// $GLOBALS['TL_CRON']['daily'][] = array('myHelper','setPollStatus');
// $GLOBALS['TL_CRON']['daily'][] = array('createVoucherXML','createXMLstring');
?>