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
 * Class ModuleCategorieMenu
 *
 * @copyright  sr-tag 2011
 * @author     Sven Rhinow <support@sr-tag.de>
 * @package    Controller
 */
class ModuleCategorieMenu extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_categoriemenu';


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

			$objTemplate->wildcard = '### CATEGORIES MENU ###';

			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'typolight/main.php?do=modules&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
                // Fallback template
		if (!strlen($this->mcsp_template))
			$this->mcsp_template = $this->strTemplate;

		$this->strTemplate = $this->mcsp_template;

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		$myHelper = new myPortalHelper;
		$cookieLifeTime = time()+3600*24*7;
		
		//Hauptkategorie
		if($this->Input->post('categories'))
		{
		    $actCategory = $this->Input->post('categories');
		}
		else{
		    $actCategory = $this->Input->cookie('categories');		
		}		
		
		//Subkategorie
		if($this->Input->get('Kategorie'))
		{
		    $subcat=$this->Input->get('Kategorie');		    
		    $this->setCookie('subcategories',$this->Input->get('Kategorie'),$cookieLifeTime);		    
		    
		    //wenn andere unterkategorie gesetzt wird die dazugehörige Hauptkategorie holen
		    $objCats = $this->Database->prepare("SELECT `pid` FROM `tl_mcsp_categories` 
							WHERE `id`=? or `alias`=?")
					    ->limit(1)
					    ->execute($this->Input->get('Kategorie'),$this->Input->get('Kategorie'));
		
		   $this->setCookie('categories', $objCats->pid, $cookieLifeTime); 
		   $actCategory = $objCats->pid;
		}else $subcat = $this->Input->cookie('subcategories');
		
		// wenn eine andere Hauptkategorie gesucht wurde die alte Unterkategorie loeschen
		$postSubCat = $this->Input->post('categories');
		if(strcmp($postSubCat,$this->Input->cookie('categories')) && !empty($postSubCat)) 
		{
		    $this->setCookie('subcategories','',-$cookieLifeTime);
		    $subcat = '';		    		    
		}
		$objCats = $this->Database->prepare("SELECT * FROM `tl_mcsp_categories` 
							WHERE `active`='1' AND `pid`=0 ORDER BY `sorting`")
					    ->execute();
	    
		if ($objCats->numRows < 1)
		{
			$this->Template->entries = array();
			return;			
		}
               
		// Add Categories
		$arrCats = array();
		$indexer = -1;
		$JSOptionShowActive = -1;
		
		while ($objCats->next())
		{		
		      $indexer++;
		      $subdata = $this->getSubMenuData($objCats->id,$subcat);
		      $arrCats[] = array(
		        'id' =>  $objCats->id,
		        'name' => $objCats->name,	
		        'linktitle'=>$objCats->name,
		        'subdata'=>$subdata,	        
		        'detailurl' => $this->urlEncode($myHelper->createURL('id',$this->mcsp_categories_jumpTo,'Kategorie='.$objCats->alias,'',true,false)),
			'class'=> strcmp($subcat,$objCats->alias)==0?'active':'normal'
		      );
		      if($subdata['subactive']) $JSOptionShowActive = $indexer; 
                      if(strcmp($objCats->id,$actCategory)==0) $JSOptionShowActive = $indexer; 
		}
				
                $this->Template->headline = $this->headline;
		$this->Template->entries = $arrCats;
                $this->Template->JSOptionShowActive = $JSOptionShowActive;
	}
	
	protected function getSubMenuData($pid=0,$curcat='')
	{
		$myHelper = new myPortalHelper;
		
		$objCats = $this->Database->prepare("SELECT * FROM `tl_mcsp_categories` 
							WHERE `active`='1' AND `pid`=? ORDER BY `sorting`")
					    ->execute($pid);
		// Add Categories
		$arrCats = array();
		$active = false;
		while ($objCats->next())
		{				      
		      $arrCats[] = array(
		        'id' =>  $objCats->id,
		        'name' => $objCats->name,	
		        'linktitle'=>$objCats->name,	        
		        'detailurl' => $this->urlEncode($myHelper->createURL('id',$this->mcsp_categories_jumpTo,'Kategorie='.$objCats->alias,'',true,false)),
			'class'=> strcmp($curcat,$objCats->alias)==0?'active':'normal'
		      );	
		      if(strcmp($curcat,$objCats->alias)==0) $active= true;	     
		}
		$arrCats['subactive'] = $active;
		return $arrCats;	
	}

}

?>