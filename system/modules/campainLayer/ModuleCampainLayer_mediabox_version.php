<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
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
 */


/**
 * Class ModuleVouchersLatest
 *
 * @copyright  sr-tag 2010 
 * @author     Sven Rhinow <support@sr-tag.de>
 * @package    Controller
 */
class ModuleKampagnenLayer extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_scripte';


	/**
	 * Target pages
	 * @var array
	 */
	protected $arrTargets = array();


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### KAMPAGNEN-LAYER ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
                // Fallback template
		#if (strlen($this->cnt_template)) $this->strTemplate = $this->cnt_template;

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
           //sucht in URL nach Anker und uebergibt den Namen als Layer-URL
           
           $pos = false;
           
           if(count($_GET)>0) 
	   {
	       
	       foreach($_GET AS $k => $v) 
               {		  
		   $k = strip_tags(trim($k));
		   $pos = strpos($k,'ssv-');
		   		  
               }
           }
           if($pos !== false)
           {
		$layerName = str_replace('ssv-','layer-',$k);
		
		$GLOBALS['TL_MOOTOOLS'][] = '<script type="text/javascript">
	    <!--//--><![cdata[//><!--
	    window.addEvent("domready", function() {
	   // if (!cookie.read("view_startlayer")) {
					
		//	cookie.write("view_startlayer", "1");
			Mediabox.open("'.$this->Environment->url.'/'.$layerName.'.html", "", "879 539");
	  //  }
	      });
	    //--><!]]>
	    </script>';    		
	   }
	}

}

?>