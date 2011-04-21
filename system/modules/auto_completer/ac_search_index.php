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

/**
 * Class ac_search_index - applies search to the tl_search_index table.
 */
class ac_search_index extends Frontend
{
	/* 
	 * called from ac_auto_completer_response::ac_response() - applies search on tl_search_index.
	 * @return array
	 */
	public function keywords() {
		$this->import('Database');	
		//TODO: maybe better solved by backend parameter
		$ac_search = strtolower($this->Input->post('value'));
		$ac_search_module = $this->Input->get('searchmodid');
		
		$sql = 'SELECT DISTINCT word FROM tl_search_index WHERE word LIKE ?';

		// Check if there is a module id passed, if so, we want to collect the badwords from there.
		if($ac_search_module)
		{
			$ac_global_ignore_list = '';
			$strLangQuery = '';
			$objBlacklist = $this->Database->prepare('SELECT auto_complete_ignore_words,auto_completer_language FROM tl_module WHERE id=?')->limit(1)->execute($ac_search_module);
			
			// add a language filter to the query
			if (version_compare('2.8.0', VERSION.'.'.BUILD, '<='))
			{
				$arrLanguage = deserialize($objBlacklist->auto_completer_language);
				if (is_array($arrLanguage))
				{
					foreach ($arrLanguage as $k=>$v)
					{
						($k == '0') ? $sql .= ' AND ( language = \'' . $v . '\'' : $sql .= ' OR language = \'' . $v . '\'';
						((count($arrLanguage) - 1) == $k) ? $sql .= ' OR language = \'' . $v . '\' ) ' : 'AND language = \'' . $v . '\'';
					}
				}
			}

			// if we got a list, add it to the sql.
			if($objBlacklist->numRows)
			{
				if (!empty($GLOBALS['TL_CONFIG']['auto_completer_global_ignore_words'])) {
					$ac_global_ignore_list = $GLOBALS['TL_CONFIG']['auto_completer_global_ignore_words'] . (strlen($objBlacklist->auto_complete_ignore_words) ? ',' : '');
				} else {
					$ac_global_ignore_list = '';
				}
				$sql .= ' AND NOT FIND_IN_SET(word, "'.$ac_global_ignore_list . $objBlacklist->auto_complete_ignore_words . '")';
			}
		}
		
		$sql .= ' ORDER BY relevance DESC';
		
		// the auto completer creates so much querys and it make no sense to cache the values. The .js will cachend if enabled in options
		if (version_compare('2.8.0', VERSION . '.' . BUILD, '<='))
			$ac_values = $this->Database->prepare($sql)->executeUncached("$ac_search%");
		else
			$ac_values = $this->Database->prepare($sql)->execute("$ac_search%");
		
		return $ac_values->fetchEach('word');
	}

	public function config()
	{
		if(!defined('use_auto_completer_hook_search_flag'))
		{
			$this->import('Database');
			global $objPage;
					
			$objLayout = $this->Database->prepare('SELECT id,modules FROM tl_layout WHERE id=?')
										->limit(1)
										->execute($objPage->layout);
			// Fallback layout
			if ($objLayout->numRows < 1)
			{
				$objLayout = $this->Database->prepare('SELECT id, modules FROM tl_layout WHERE fallback=?')
											->limit(1)
											->execute(1);
			}
		
			// check if there is a layout and fetch modules if so.
			($objLayout->numRows) ? $arrModules = deserialize($objLayout->modules) : $arrModules = array();

			// fetch all content element modules from this page.
			$objContent = $this->Database->prepare('SELECT module FROM tl_content WHERE pid IN (SELECT id FROM tl_article WHERE pid=?)')->execute($objPage->id);
			
			while($objContent->next())
				$arrModules[] = array('mod' => $objContent->module);

			if (count($arrModules))
			{
				// now check each module if it is a search module and if wants to use the ajax functionality.
				$ids = array();
				foreach ($arrModules as $arrModule)
					$ids[] = $arrModule['mod'];

				$objModules = $this->Database->prepare('SELECT * FROM tl_module WHERE id IN (' . implode(', ', $ids) . ') AND type=\'search\' AND use_auto_completer=1')->execute();
				define('use_auto_completer_hook_search_flag', true);
				$this->import('ac_helper');
				
				while($objModules->next())
				{
					$arrConfig = $objModules->row();
					
					// default typolight search boxes always have the id "keywords" but not in TL 2.8 :(
					if (version_compare('2.8.0', VERSION . '.' . BUILD, '<='))
						$arrConfig['auto_completer_input_name'] = 'ctrl_keywords';
					else
						$arrConfig['auto_completer_input_name'] = 'keywords';

					$arrConfig['auto_completer_hook'] = 'searchindex';
					$arrConfig['auto_completer_url_suffix'] = 'searchmodid=' . $arrConfig['id'];
					$this->ac_helper->generateJavaScriptFor($arrConfig);
				}
			}
		}
	}
}

?>