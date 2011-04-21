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
 * Class ac_auto_completer_response - returns the JSON reply to the FE on ajax requests.
 */
class ac_auto_completer_response extends Frontend
{
	/* 
	 * called from ajax hook - sets Content-Type header to application/json
	 * @return JSON-Array or false
	 */
	public function ac_response()
	{
		// check if ajax-request is from the auto completer
		if ($this->Input->get('req_script') == 'ac_auto_completer')
		{
			$reply = $this->ac_response_hooked_keywords();
			return json_encode($reply);
		}
		
		// Fix a strange behavior of the ajax.php
		// @see http://www.typolight-community.de/showthread.php?t=3668
		return false;
	}

	/* 
	 * called from ac_response() - calls the auto completer hook that is requested.
	 * @return array
	 */
	protected function ac_response_hooked_keywords()
	{
		$hook = $GLOBALS['TL_CONFIG']['auto_completer'][$this->Input->get('hook')]['hooklookup'];

		if(is_array($hook)) {
			$this->import($hook[0]);
			$reply = $this->$hook[0]->$hook[1]();
		} else {
			$reply = array('the hook must be an array');
		}
		
		if(!is_array($reply))
			$reply = array('reply must be an array');
		
		return $reply;
	}
}

?>