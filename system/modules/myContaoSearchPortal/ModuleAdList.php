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
class ModuleAdList extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_adlist';


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

			$objTemplate->wildcard = '### ANZEIGEN-LISTE ###';

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
		    if($this->Input->get('Kategorie')) 
		    {
			$objCats = $this->Database->prepare("SELECT `id`,`pid` FROM `tl_mcsp_categories` WHERE `id`=? or `alias`=?")
						  ->limit(1)
						  ->execute($this->Input->get('Kategorie'),$this->Input->get('Kategorie'));
			
			$searchWhereArr[] = "`tl_mcsp_categories`.`id` = '".$objCats->id."'";
			#print_r($objCats);
		    }
		    else{
			
			//Hauptkategorie
			$actCategory="";
			if(strlen($this->Input->post('categories')))
			{
			    $actCategory = $this->Input->post('categories');
			}
			else{
			    $actCategory = $this->Input->cookie('categories');		
			}
				       
			if(strlen($actCategory)) $searchWhereArr[] = "`tl_mcsp_categories`.`pid` = '".$actCategory."'";
		    
		    }
		    if(count($searchWhereArr)>0) $searchWhereStr = " AND ".implode(' AND ',$searchWhereArr);
                }
                
                //Daten holen
		$resultObj = $this->Database->prepare("SELECT `tl_mcsp_smallads`.*,
							`tl_mcsp_categories`.`name` AS `catname`,
							`tl_mcsp_categories`.`alias` AS `catalias`,
							`zip_coordinates`.`zc_zip` AS `plz`,
							`zip_coordinates`.`zc_location_name` AS `city`
							FROM `tl_mcsp_smallads`		 
							LEFT JOIN `tl_mcsp_states` ON `tl_mcsp_smallads`.`stateid` = `tl_mcsp_states`.`id`
							LEFT JOIN `tl_mcsp_categories` ON `tl_mcsp_smallads`.`categoryid` = `tl_mcsp_categories`.`id`
							LEFT JOIN `zip_coordinates` ON `tl_mcsp_smallads`.`zc_id` = `zip_coordinates`.`zc_id`
							WHERE `tl_mcsp_states`.`value`='1'
							".$searchWhereStr."							
							ORDER BY `createdate` DESC ")
					    ->limit($this->mcsp_count)
					    ->execute();
		if ($resultObj->numRows < 1)
		{
			$this->Template->items = array();
			return;
			
		}
               
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
                        'humandate' => $myHelper->getHumandate($resultObj->createdate)
                        
		      );
		    
		}
                if(strlen($this->mcsp_css_file)>0) 
                {
		    $cssfiles = unserialize($this->mcsp_css_file);		    
		    foreach($cssfiles as $k => $v) $GLOBALS['TL_CSS'][] = $v; 
		}
		$this->Template->items = $itemArr;
	}

}

?>