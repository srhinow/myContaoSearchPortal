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
 * Class ac_auto_completer 
 *
 * @copyright  leo@leo-unglaub.net, CyberSpectrum 2009 
 * @author     Leo Unglaub <leo@leo-unglaub.net>, Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    Controller
 */
class ac_auto_completer extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_ac_search';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### AJAX SEARCH BOX ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}
 
	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->import('ac_helper');

		$this->Template->queryType = $this->queryType;
		$this->Template->search = specialchars($GLOBALS['TL_LANG']['MSC']['searchLabel']);
		$this->Template->matchAll = specialchars($GLOBALS['TL_LANG']['MSC']['matchAll']);
		$this->Template->matchAny = specialchars($GLOBALS['TL_LANG']['MSC']['matchAny']);
		$this->Template->id = ($GLOBALS['TL_CONFIG']['disableAlias'] && $this->Input->get('id')) ? $this->Input->get('id') : false;
		$this->Template->ac_scriptid = 'ac_keywords' . $this->id;

		$arrConfig = $this->arrData;
		$arrConfig['auto_completer_input_name'] = $this->Template->ac_scriptid;
		$arrConfig['auto_completer_hook'] = 'searchindex';
		$arrConfig['auto_completer_url_suffix'] = 'searchmodid=' . $arrConfig['id'];
		$this->ac_helper->generateJavaScriptFor($arrConfig);

		if($this->jumpTo)
		{
			$objNext = $this->Database->prepare('SELECT id, alias FROM tl_page WHERE id=?')->limit(1)->execute($this->jumpTo);
			if ($objNext->numRows)
				$href = $this->generateFrontendUrl($objNext->fetchAssoc());
		}
		
		$this->Template->action = isset($href) ? $href : ampersand($this->Environment->request);
	}
}

?>