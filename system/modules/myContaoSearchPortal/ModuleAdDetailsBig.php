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
class ModuleAdDetailsBig extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_addetails';


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

			$objTemplate->wildcard = '### ANZEIGEN-Detail-Hauptansicht ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
                // Fallback template
		if (strlen($this->mcsp_template)) $this->strTemplate = $this->mcsp_template;

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$this->import('String');
		
		$myHelper = new myPortalHelper;
                $searchWhereStr  = '';

                //Suchanfragen berücksichtigen
                if(!$this->mcsp_ignore_filter)
                {
		    $searchWhereArr = array();
		    
		    
		//Unterkategorie per Get
		if(!$this->Input->get('anzeige')) 
		{
                   $this->Template->items = array();
                   return;
                }
                
                //Daten holen
		$resultObj = $this->Database->prepare("SELECT * FROM `tl_mcsp_smallads` WHERE `id`=? OR `alias`=?")
					    ->limit(1)
					    ->execute($this->Input->get('anzeige'),$this->Input->get('anzeige'));
		if ($resultObj->numRows < 1)
		{
			$this->Template->items = array();
			return;
			
		}
               

		
		//get image-size from modul-options
		$img_size = unserialize($this->mcsp_img_size);
		$thumb_size = unserialize($this->mcsp_thumb_size);
		
		if($this->Input->cookie('plz_ort')) $cookie_zc_id = $myHelper->getZcId($this->Input->cookie('plz_ort'));		
		
		//get first picture
		$firstPic = '';		      
		if($resultObj->is_picture==1 && count($resultObj->pictures)>0)
		{
		  $pics = unserialize($resultObj->pictures);
		  $firstPic =  $pics[0];			
		}		  	  

		$this->Template->id = $resultObj->id;
		$this->Template->title = $resultObj->title;
		$this->Template->text = nl2br($resultObj->description);
		$this->Template->adid = $resultObj->adid;
		$this->Template->bicpic = $this->getImage($this->urlEncode($firstPic), $img_size[0], $img_size[1],$img_size[2]);
		$this->Template->thumbpic = $this->getImage($this->urlEncode($firstPic), $thumb_size[0], $thumb_size[1],$thumb_size[2]);
		$this->Template->category = $resultObj->catname;
		$this->Template->price = $myHelper->getPriceString($resultObj->price,$resultObj->basic_agreement);
		$this->Template->humandate = $myHelper->getHumandate($resultObj->createdate);
		$this->Template->backlink = $this->getReferer();
		    

                if(strlen($this->mcsp_css_file)>0) 
                {
		    $cssfiles = unserialize($this->mcsp_css_file);		    
		    foreach($cssfiles as $k => $v) $GLOBALS['TL_CSS'][] = $v; 
		}
	}
      }
}

?>