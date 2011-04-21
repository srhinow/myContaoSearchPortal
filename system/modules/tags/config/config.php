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
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */


/**
 * Form fields
 */
$GLOBALS['BE_FFL']['tag'] = 'TagField';

/**
 * Front end modules
 */
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 3, array
(
	'tagcloud'    => 'ModuleTagCloud'
));
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 3, array
(
	'tagscope'    => 'ModuleTagScope'
));
array_insert($GLOBALS['FE_MOD']['application'], 3, array
(
	'globalArticleList'    => 'ModuleGlobalArticlelist'
));
array_insert($GLOBALS['FE_MOD']['application'], 3, array
(
	'tagcontentlist'    => 'ModuleTagContentList'
));

$GLOBALS['FE_MOD']['news']['newslist'] = 'ModuleNewsListTags';
$GLOBALS['FE_MOD']['news']['newsarchive'] = 'ModuleNewsArchiveTags';
$GLOBALS['FE_MOD']['news']['newsreader'] = 'ModuleNewsReaderTags';
$GLOBALS['FE_MOD']['events']['eventlist'] = 'ModuleEventlistTags';

if (array_key_exists('last_events', $GLOBALS['FE_MOD']['events']))
{
	// add support for last_events extension
	$GLOBALS['FE_MOD']['events']['last_events'] = 'ModuleLastEventsTags';
}

/**
 * Content elements
	*/
$GLOBALS['TL_CTE']['texts']['headline'] = 'ContentHeadlineTags';
	
	
if (TL_MODE == 'BE')
{
	/**
	 * CSS files
	 */

	if (is_array($GLOBALS['TL_CSS']))
	{
		array_insert($GLOBALS['TL_CSS'], 1, 'system/modules/tags/html/css/tag.css');
	}
	else
	{
		$GLOBALS['TL_CSS'] = array('system/modules/tags/html/css/tag.css');
	}

	/**
	 * JavaScript files
	 */
	if (is_array($GLOBALS['TL_JAVASCRIPT']))
	{
		array_insert($GLOBALS['TL_JAVASCRIPT'], 1, 'system/modules/tags/html/js/tag.js');
	}
	else
	{
		$GLOBALS['TL_JAVASCRIPT'] = array('system/modules/tags/html/js/tag.js');
	}
}

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['reviseTable'][] = array('TagHelper', 'deleteIncompleteRecords');
$GLOBALS['TL_HOOKS']['reviseTable'][] = array('TagHelper', 'deleteUnusedTagsForTable');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('TagHelper', 'replaceTagInsertTags');
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('TagHelper', 'parseArticlesHook');

/**
* source tables that have tags enabled
*/
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_article';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_calendar_events';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_content';
$GLOBALS['tags_extension']['sourcetable'][] = 'tl_news';

/**
* Add 'tag' to the URL keywords to prevent problems with URL manipulating modules like folderurl
*/
$GLOBALS['TL_CONFIG']['urlKeywords'] .= (strlen(trim($GLOBALS['TL_CONFIG']['urlKeywords'])) ? ',' : '') . 'tag';
$GLOBALS['tags']['tags_used'] = '(%s)';

?>