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
 * Class ac_auto_completer_searchform - The frontend module for a search form.
 */
class ac_auto_completer_searchform extends Frontend
{
	/**
	 * Called from parseFrontendTemplate HOOK
	 * 
	 * @param string
	 * @param object
	 * @return string
	 */
	public function hook_search($strBuffer, $strTemplate)
	{
		if(count($GLOBALS['TL_CONFIG']['auto_completer']))
		{
			foreach($GLOBALS['TL_CONFIG']['auto_completer'] as $key => $data)
			{
				// only process if there is a config hook.
				// some search hooks don't have a config hook, if they are being generated from a module i.e.
				if(is_array($data['hookconfig']) && array_key_exists('hookconfig', $data))
				{
					$this->import($data['hookconfig'][0]);
					$this->$data['hookconfig'][0]->$data['hookconfig'][1]();
				}
			}
		}

		return $strBuffer;
	}
}

?>