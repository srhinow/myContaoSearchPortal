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
 * @copyright  sr-tag 2011 
 * @author     Sven Rhinow <support@sr-tag.de>
 * @package    Controller
 */
class ModuleAdWishlist extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_adwishlist';


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

			$objTemplate->wildcard = '### ANZEIGEN-WISHLIST ###';

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
		
		$this->import('Session');
		$this->import('String');
		
		$myHelper = new myPortalHelper;
		$myHelper->portalSettings();
                $portalSettings = $myHelper->portalSettings;
                
		//Unterkategorie per Get
		if($this->Input->get('anzeige')) 
		{
		    //get adId from get-var
		    $adObj = $this->Database->prepare('SELECT * FROM `tl_mcsp_smallads` WHERE `alias`= ?')
					   ->limit(1)
					   ->execute($this->Input->get('anzeige'));
                    
		    //ist Session vorhanden und als Array umwandeln
		    if(!strlen($this->Session->get('wishlist')))
		    { 
			$wishlistArr=array();
		    }
		    else
		    {
			$wishlist = $this->Session->get('wishlist');
			$wishlistArr = unserialize($wishlist);
		    }
		    
		    //nur hinzufügen wenn es noch nicht auf der Merkliste existiert
		    if(!in_array($adObj->id,$wishlistArr))
		    {
			$this->Session->set( 'wishlist' , serialize(array_merge($wishlistArr,array($adObj->id))) );
		    }
                }                                         
                     
                //löschen eines Artikels von der Merkliste
                if($this->Input->get('del'))
                {
                     	$wishlist = $this->Session->get('wishlist');
			$wishlistArr = unserialize($wishlist);			
			foreach($wishlistArr As $k=>$v) if(strcmp($v,$this->Input->get('del'))==0) unset($wishlistArr[$k]);
			$this->Session->set( 'wishlist' , serialize($wishlistArr));
                }

                if(strlen($this->Session->get('wishlist')))
                {
		    $wishlist = $this->Session->get('wishlist');
		    $wishlistArr = unserialize($wishlist);
		    if(count($wishlistArr)>0)
		    {
			$wishlistStr = implode(',',$wishlistArr);

			$resultObj = $this->Database->prepare("SELECT `tl_mcsp_smallads`.*,
			`tl_mcsp_categories`.`name` AS `catname`,
			`tl_mcsp_categories`.`alias` AS `catalias`,
			`zip_coordinates`.`zc_zip` AS `plz`,
			`zip_coordinates`.`zc_location_name` AS `city`
			FROM `tl_mcsp_smallads`		 
			LEFT JOIN `tl_mcsp_states` ON `tl_mcsp_smallads`.`stateid` = `tl_mcsp_states`.`id`
			LEFT JOIN `tl_mcsp_categories` ON `tl_mcsp_smallads`.`categoryid` = `tl_mcsp_categories`.`id`
			LEFT JOIN `zip_coordinates` ON `tl_mcsp_smallads`.`zc_id` = `zip_coordinates`.`zc_id`
			WHERE `tl_mcsp_states`.`value`='1' AND `tl_mcsp_smallads`.`id` IN(".$wishlistStr.")")
					  ->execute();
					  		  
			//create empty item--Array
			$itemArr = array();
			
			//get image-size from modul-options
			$img_size = unserialize($this->mcsp_img_size);
			if($this->Input->cookie('plz_ort')) $cookie_zc_id = $myHelper->getZcId($this->Input->cookie('plz_ort'));
			
			while ($resultObj->next())
			{		
			
			      //get first picture
			      $firstPic = '';		      
			      if($resultObj->is_picture==1 && count($resultObj->pictures)>0)
			      {
				  $pics = unserialize($resultObj->pictures);
				  $firstPic =  $pics[0];			
			      }
			      
			      $distance = '';
			      if($cookie_zc_id) $distance = $myHelper->getDistance($cookie_zc_id,$resultObj->zc_id);
					      
			      $itemArr[] = array(
				'id' =>  $resultObj->id,
				'title' => $this->String->substr($resultObj->title , ($this->mcsp_title_maxlength-strlen($this->mcsp_more_str))).((strlen($resultObj->title) > $this->mcsp_title_maxlength) ? $this->mcsp_more_str : ''),
				'text' => $this->String->substr($resultObj->description , ($this->mcsp_text_maxlength-strlen($this->mcsp_more_str))).((strlen($resultObj->description) > $this->mcsp_text_maxlength) ? $this->mcsp_more_str : ''),
				'picture' => $this->getImage($this->urlEncode($firstPic), $img_size[0], $img_size[1],$img_size[2]),
				'detailurl' => $this->Environment->base.$this->urlEncode($myHelper->createURL('id',$this->mcsp_detail_jumpTo,'anzeige='.$resultObj->alias,'',true,false)),
				'caturl' =>  $this->Environment->base.$myHelper->createURL('id',$this->mcsp_categories_jumpTo,'Kategorie='.$resultObj->catalias,'',true,false),
				'category' => $resultObj->catname,
				'plz' => $resultObj->plz,
				'city' => $resultObj->city,
				'distance' => (!empty($distance) ? number_format($distance,2,',','.').'km':''),
				'price' => $myHelper->getPriceString($resultObj->price,$resultObj->basic_agreement),
				'humandate' => $myHelper->getHumandate($resultObj->createdate),
				'hightlightClass' => (($resultObj->is_hightlight == 1)? ' hightlight ' : ''),
				'delLink' => $this->addToUrl('del='.$resultObj->id)
			      );
			    
			}
			
		    }
		    $this->Template->items = $itemArr;
                }else $this->Template->items =array();				
		
		//set values for template
		$this->Template->id = $resultObj->id;
		$this->Template->moduleId = $this->id;				
		    
		//customer css-file forr this module 
		if(strlen($this->mcsp_css_file)>0) 
		{
		    $cssfiles = unserialize($this->mcsp_css_file);		    
		    foreach($cssfiles as $k => $v) $GLOBALS['TL_CSS'][] = $v; 
		}
      }
}

?>