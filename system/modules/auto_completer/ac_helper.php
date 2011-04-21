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
 * Class ac_helper - Helper routines for use from all over the world. :)
 *
 * @copyright  leo@leo-unglaub.net, CyberSpectrum 2009 
 * @author     Leo Unglaub <leo@leo-unglaub.net>, Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    Controller
 */
class ac_helper extends Frontend
{
	/* 
	 * Experts parameters - when in experts mode.
	 */
	protected $lookupMap = array
		(
			'auto_completer_min_length' 		=> 'minLength',
			'auto_completer_max_choises' 		=> 'maxChoices',
			'auto_completer_mark_query' 		=> 'markQuery',
			'auto_completer_width' 				=> 'width',
			'auto_completer_inject_choice' 		=> 'injectChoice',
			'auto_completer_custom_choices' 	=> 'customChoices',
			'auto_completer_empty_choises' 		=> 'emptyChoices',
			'auto_completer_visible_choises' 	=> 'visibleChoices',
			'auto_completer_class_name' 		=> 'className',
			'auto_completer_z_index' 			=> 'zIndex',
			'auto_completer_delay' 				=> 'delay',
			'auto_completer_observer_options' 	=> 'observerOptions',
			'auto_completer_fx_options' 		=> 'fxOptions',
			'auto_completer_auto_submit' 		=> 'autoSubmit',
			'auto_completer_overflow' 			=> 'overflow',
			'auto_completer_overflow_margin' 	=> 'overflowMargin',
			'auto_completer_select_first' 		=> 'selectFirst',
			'auto_completer_filter' 			=> 'filter',
			'auto_completer_filter_case' 		=> 'filterCase',
			'auto_completer_filter_subset' 		=> 'filterSubset',
			'auto_completer_force_select' 		=> 'forceSelect',
			'auto_completer_select_mode' 		=> 'selectMode',
			'auto_completer_choices_match' 		=> 'choicesMatch',
			'auto_completer_multiple' 			=> 'multiple',
			'auto_completer_auto_trim' 			=> 'autoTrim',
			'auto_completer_allow_dupes' 		=> 'allowDupes',
			'auto_completer_cache' 				=> 'cache',
			'auto_completer_relative' 			=> 'relative',
		);
	/* 
	 * Basic parameters - not in experts mode.
	 */
	protected $lookupMapBasicMode = array
		(
			'auto_completer_min_length'			=> 'minLength',
			'auto_completer_max_choises'		=> 'maxChoices',
		);
		
	protected $scriptDefaults = array
				(
					'auto_completer_min_length' 		=> 1,
					'auto_completer_max_choises' 		=> 10,
					'auto_completer_mark_query' 		=> true,
					'auto_completer_width' 				=> 'inherit',
					'auto_completer_inject_choice' 		=> 'null',
					'auto_completer_custom_choices' 	=> 'null',
					'auto_completer_empty_choises' 		=> 'null',
					'auto_completer_visible_choises' 	=> true,
					'auto_completer_class_name' 		=> 'autocompleter-choices',
					'auto_completer_z_index' 			=> 42,
					'auto_completer_delay' 				=> 400,
					'auto_completer_observer_options' 	=> '{}',
					'auto_completer_fx_options' 		=> '{}',
					'auto_completer_auto_submit' 		=> false,
					'auto_completer_overflow' 			=> false,
					'auto_completer_overflow_margin' 	=> 25,
					'auto_completer_select_first' 		=> false,
					'auto_completer_filter' 			=> 'null',
					'auto_completer_filter_case' 		=> false,
					'auto_completer_filter_subset' 		=> false,
					'auto_completer_force_select' 		=> false,
					'auto_completer_select_mode' 		=> true,
					'auto_completer_choices_match' 		=> 'null',
					'auto_completer_multiple' 			=> false,
					'auto_completer_auto_trim' 			=> false,
					'auto_completer_allow_dupes' 		=> false,
					'auto_completer_cache' 				=> true,
					'auto_completer_relative' 			=> false,
				);
	/*
	 * Fetch the global settings for the autocompleter.
	 * @param boolean
	 * @return array
	 */	
	public function getDefaultConfig($expertsmode=false)
	{
		$data = array();

		if($GLOBALS['TL_CONFIG']['auto_completer_expert_settings'] || $expertsmode)
			$settingsList = $this->lookupMap;
		else
			$settingsList = $this->lookupMapBasicMode;
        
		foreach($settingsList as $setting => $alias)
			$data[$setting] = $GLOBALS['TL_CONFIG'][$setting];

		return $data;
	}
	
	public function applyGlobalConfig($config=false)
	{
		$default = $this->getDefaultConfig();
		if(!$config)
			return $default;

		if(!$config['auto_completer_override_global'])
		{
			// If not overriding global, restrict all values to global ones.
			foreach($this->lookupMap as $key=>$value)
				$config[$key] = $default[$key];
		} 
		else
		{
			if(!$config['auto_completer_expert_settings'])
			{
				// If not expert, override all expert settings in config.
				foreach($this->lookupMap as $key=>$value)
				{
					if(!array_key_exists($key, $this->lookupMapBasicMode))
						$config[$key] = $default[$key];
				}
			}
		}
		return $config;
	}

	/* Prepare the output options based upon the given parameter array.
	 * @param array
	 * @return string
	 */
	protected function generateJSForModule($arr)
	{
		$this->import('ac_helper');
		require_once('dca/tl_module.php');

		$arrSettings = array();
		$defaults = $this->scriptDefaults;

		// give all for experts or only subset of settings for basic mode.
		if($arr['auto_completer_expert_settings'])
			$settingsList = $this->lookupMap;
		else
			$settingsList=$this->lookupMapBasicMode;

		$arr = $this->applyGlobalConfig($arr);

		foreach($settingsList as $setting => $alias)
		{
			$default = $defaults[$setting];
			
			// force boolean to be what they should be, booleans.
			if(isset($GLOBALS['TL_DCA']['tl_module']['fields'][$setting]['options']['true']))
				$arr[$setting] = in_array($arr[$setting], array(1, 'true', true));

			// correct incorrectly stored values to treat them as unchanged.
			if(($default == 'null' && ($arr[$setting] == '0' || $arr[$setting] == '')) || ($default == '{}' && $arr[$setting] == ''))
				$arr[$setting] = $default;

			if($arr[$setting] != $default)
			{
				$quote = (($GLOBALS['TL_DCA']['tl_module']['fields'][$setting]['inputType'] == 'text') && (!is_numeric($arr[$setting])));

				if($quote)
				{
					$arrSettings[] = $alias . ":'" . $arr[$setting] . "'";
				} 
				else 
				{
					if(is_bool($arr[$setting]))
						$arrSettings[] = $alias . ":" . ($arr[$setting] === true ? 'true' : 'false');
					else
						$arrSettings[] = $alias . ":" . $arr[$setting];
				}
			}
		}
		// join it together.
		return implode(',', $arrSettings);
	}
	
	/**
	 * Display a wildcard in the back end
	 * @param array
	 * @param string
	 */
	public function generateJavaScriptFor($arrOptions)
	{
		$jsOptions = $this->generateJSForModule($arrOptions);
		if($jsOptions)
			$jsOptions .=',';

		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/auto_completer/html/js/ac_compress.js';

		if($arrOptions['auto_completer_hook'])
			$url = "'ajax.php?req_script=ac_auto_completer&hook=" . $arrOptions['auto_completer_hook'];
		
		// append url suffix if needed.
		$url .= ($arrOptions['auto_completer_url_suffix'] ? '&' . $arrOptions['auto_completer_url_suffix'] : '') . "'";
		
		$GLOBALS['TL_HEAD'][] = 
		"<script type=\"text/javascript\">/* <![CDATA[ */ document.addEvent('domready',function(){" .
		"new Autocompleter.Request.JSON('" . $arrOptions['auto_completer_input_name'] . "'," . $url .
		",{".$jsOptions."indicatorClass:'autocompleter-loading'});}); " . 
		"/* ]]> */</script>";

		$GLOBALS['TL_CSS'][] = 'system/modules/auto_completer/html/css/auto_completer.css';
	}

	/**
	 * Callback: prepare ignore words to save into the DB
	 * 
	 * @param string
	 * @param object
	 * @return string
	 */
	public function save_ignore_words($varValue, DataContainer $dc)
	{
		// array_diff remove empty strings
		$arrBuffer = array_diff(array_unique(array_map(trim, explode(',', $varValue))), array(''));
		sort($arrBuffer);
		$strBuffer = implode(',', $arrBuffer);
		return strtolower($strBuffer);
	}

	/**
	 * Callback: make ignore words better readable
	 * 
	 * @param string
	 * @param object
	 * @return string
	 */
	public function load_ignore_words($varValue, DataContainer $dc)
	{
		return str_replace(',', ', ', $varValue);
	}
	
	/**
	 * onload_callback for missing default values
	 * 
	 * set the default value in the global-ac-conf when it's empty
	 * @param string
     * @param object
	 * @return string
	 */
	public function set_missing_default_values($strValue, DataContainer $objDC) 
	{
		if (empty($strValue))
			$strValue = $GLOBALS['TL_DCA']['tl_settings']['fields'][$objDC->field]['default'];

		return $strValue;
	}

	/**
	 * return all active page languages as array
	 * @return array
	 */
	public function getSiteLanguages()
	{
		$this->Import('Database');
		$this->loadLanguageFile('languages');
		$arrReturn = array();
		
		$objLang = $this->Database->prepare('SELECT DISTINCT language FROM tl_search_index')->execute();

		while($objLang->next())
			$arrReturn[$objLang->language] = $GLOBALS['TL_LANG']['LNG'][$objLang->language];
		
		return $arrReturn;
	}
}
?>