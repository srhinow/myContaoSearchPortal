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
 * @copyright  sr-tag 2010
 * @author     Sven Rhinow <support@sr-tag.de>
 * @package    Controller
 */
class ModuleSearchBar extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_searchbar';


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

			$objTemplate->wildcard = '### SEARCH BAR ###';

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
		$cookieDelTime = time()-3600*24*7;
		
		//wenn gesetzt Categorie-Cookies löschen
		if($this->mcsp_del_cookie)
		{
		    $this->setCookie('categories','',$cookieDelTime);
		    $this->setCookie('subcategories','',$cookieDelTime);
		}
		
		if($this->Input->post('FORM_SUBMIT')=='bigSearchForm')
		{
		   # $this->generateAjax();
		    $this->setCookie('keyword',$this->Input->post('keyword'),$cookieLifeTime);
		    $this->setCookie('plz_ort',$this->Input->post('plz_ort'),$cookieLifeTime);
		    $this->setCookie('radius',$this->Input->post('radius'),$cookieLifeTime);
		    $this->setCookie('categories',$this->Input->post('categories'),$cookieLifeTime);
		    if(strcmp($this->Input->post('categories'),$this->Input->cookie('categories'))) $this->setCookie('subcategories','',-$cookieLifeTime);
		    
		    $keywordValue =  $this->Input->post('keyword');
		    $plz_ortValue =  $this->Input->post('plz_ort');
		    $radiusValue =  $this->Input->post('radius');
		    $categoriesValue =  $this->Input->post('categories');
		}
		else{				
		    $keywordValue = $this->Input->cookie('keyword');		
		    $plz_ortValue = $this->Input->cookie('plz_ort');
		    $radiusValue = $this->Input->cookie('radius');
		    
		    if($this->Input->get('Kategorie'))
		    {		    
			
			//wenn andere unterkategorie gesetzt wird die dazugehörige Hauptkategorie holen
			$objCats = $this->Database->prepare("SELECT `pid` FROM `tl_mcsp_categories` 
							    WHERE `id`=? or `alias`=?")
						->limit(1)
						->execute($this->Input->get('Kategorie'),$this->Input->get('Kategorie'));
		    
		       $categoriesValue =  $objCats->pid; 
		    
		    }
		    else{
			$categoriesValue = $this->Input->cookie('categories');				
		    }
		}
		//wenn die Kategorie ignoriert werden soll (Modul-Einstellung)
		if($this->mcsp_ignore_filter)  $categoriesValue ='';
		
                //create Formfields
                $inputKeyword = new FormTextField();
		$inputKeyword->id = 'searchkeyword';
		$inputKeyword->name = 'keyword';
		$inputKeyword->label = 'Begriff';
		$inputKeyword->mandatory = false;
		$inputKeyword->rgxp = 'extnd';
 		$inputKeyword->maxlength = 65;
		$inputKeyword->class = 'text';
		$inputKeyword->value = $keywordValue;

                $inputWhere = new FormTextField();
		$inputWhere->id = 'searchwhere';
		$inputWhere->name = 'plz_ort';
		$inputWhere->label = 'PLZ, Ort';
		$inputWhere->mandatory = false;
		$inputWhere->rgxp = 'extnd';
 		$inputWhere->maxlength = 65;
		$inputWhere->class = 'text';
		$inputWhere->value = $plz_ortValue;
		
		$inputRadius = new FormSelectMenu();
		$inputRadius->id = 'searchradius';
		$inputRadius->name = 'radius';
		$inputRadius->label = 'Umkreis';
		$inputRadius->class = 'select';
		$inputRadius->value = $radiusValue;
		$inputRadius->options = array( 
		    array('value'=>'', 'label'=>'+ 0km'),
		    array('value'=>'10','label'=>'+ 10km'),
		    array('value'=>'20','label'=>'+ 20km'),
		    array('value'=>'50','label'=>'+ 50km'),
		    array('value'=>'100','label'=>'+ 100km'),
		    array('value'=>'150','label'=>'+ 150km'),
		    array('value'=>'200','label'=>'+ 200km'),
		    array('value'=>'250','label'=>'+ 250km'),
		    array('value'=>'300','label'=>'+ 300km'),
		    array('value'=>'400','label'=>'+ 400km'),
		);
				
		$inputCategories = new FormSelectMenu();
		$inputCategories->id = 'searchcategories';
		$inputCategories->name = 'categories';
		$inputCategories->label = 'in';
		$inputCategories->class = 'select';
		$inputCategories->value = $categoriesValue;
		$inputCategories->options = $this->getCategoriesForSelect();
							
							
                //Werte an Template übergeben
		$this->Template->inputKeyword = $inputKeyword;
		$this->Template->inputWhere = $inputWhere;
		$this->Template->inputRadius = $inputRadius;
		$this->Template->inputCategories = $inputCategories;
		$this->Template->formurl = $this->urlEncode($myHelper->createURL('id',$this->mcsp_detail_jumpTo,'','',true,false));		
                $this->Template->headline = $this->headline;
                
                $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/myContaoSearchPortal/html/autocompleter/js/ac_compress.js';
                
                $GLOBALS['TL_HEAD'][] = "<script type='text/javascript'>/* <![CDATA[ */ window.addEvent('domready', function() { new Autocompleter.Request.JSON('ctrl_searchwhere', 'ajax.php?action=fmd&id=".$this->id."', {'postVar': 'plz_ort',indicatorClass:'autocompleter-loading',zIndex:1000,minLength:".$this->mcsp_sb_min_characters."});}); /* ]]> */</script>";
                
                $GLOBALS['TL_CSS'][] = 'system/modules/myContaoSearchPortal/html/autocompleter/css/auto_completer.css';
                #print $this->id;
	}
		
	protected function getCategoriesForSelect()
	{
		$objCats = $this->Database->prepare("SELECT `id`,`name` FROM `tl_mcsp_categories` 
							WHERE `active`='1' AND `pid`=0 ORDER BY `sorting`")
					    ->execute();
	    
		if ($objCats->numRows < 1)
		{
			return  array();						
		}	
		
		$arrCats[] = array(
		    'value' => '',
		    'label' => 'alle Kategorien'
		);
		
		while ($objCats->next())
		{		
		      $arrCats[] = array(
		        'value' =>  $objCats->id,
		        'label' => $objCats->name,	
		      );
		}
		return $arrCats;
			    
	}
	
	public function generateAjax()
	{
	   
	   $plzort = trim($this->Input->post('plz_ort'));

	   if((strlen($plzort) >= $this->mcsp_sb_min_characters) && (strlen($plzort) <= $this->mcsp_sb_max_characters))
	   {
		
		//prüfen ob es eine Zahl ist (plz)
		if (is_numeric($plzort))
		{
		    $resObj = $this->Database->prepare("SELECT `zc_zip`, `zc_location_name` FROM `zip_coordinates` WHERE `zc_zip` LIKE ?")
					  ->execute($plzort.'%');	   
		}
		else{
		    $resObj = $this->Database->prepare("SELECT `zc_zip`, `zc_location_name` FROM `zip_coordinates` WHERE `zc_location_name` LIKE ?")
					  ->execute($plzort.'%');	   
		
		}

		if ($resObj->numRows > 0)
		{
		    while($resObj->next())
		    {
		        $items[] = $resObj->zc_zip .' '. $resObj->zc_location_name; 
		    }
		   # print "Hallo";
		    header('Content-type: application/json');
		    echo json_encode($items);

		}					  
		
	   }
	}


}

?>