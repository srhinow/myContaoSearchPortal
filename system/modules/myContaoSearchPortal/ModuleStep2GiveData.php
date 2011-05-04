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
class ModuleStep1SelectCategory extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_step1';


	/**
	 * Form Error
	 * @var bool
	 */
	protected $error = false;


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### STEP1 SELECT CATEGORY ###';

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
		$this->import('Session');
		
		// eventl. aktuell gespeicherte Kategorie setzen
		$curcat='';
		if($this->Session->get('formCat')) $curcat = $this->Session->get('formCat'); 
		print $curcat;
		
		//if form send
		if($this->Input->post('FORM_SUBMIT')=='ad_selectcat_form'.$this->id)
		{
		    
		    if(strlen($this->Input->post('category')))
		    {
			
			$this->Session->set('formCat',$this->Input->post('category'));
			$this->redirect($this->urlEncode($myHelper->createURL('id',$this->mcsp_next_jumpTo,'','',true,false)));
		    }else $this->error = true;
		}
				
		//holle alle aktiven Kategorien		
		$objCats = $this->Database->prepare("SELECT * FROM `tl_mcsp_categories` WHERE `active`='1' AND `pid`=0 ORDER BY `sorting`")
					  ->execute();
	    
		if ($objCats->numRows < 1)
		{
			$this->Template->entries = array();
			return;			
		}
               
		// Add Categories
		$arrCats = array();
		
		while ($objCats->next())
		{		
		      $indexer++;
		      $subdata = $this->getSubMenuData($objCats->id,$curcat);
		      $arrCats[] = array(
		        'id' =>  $objCats->id,
		        'name' => $objCats->name,	
		        'subdata'=>$subdata,	        
			'class'=> strcmp($subcat,$objCats->alias)==0?'active':'normal'
		      );
		      if(!$this->mcsp_ignore_filter)
		      {
			  if($subdata['subactive']) $JSOptionShowActive = $indexer; 
			  if(strcmp($objCats->id,$actCategory)==0) $JSOptionShowActive = $indexer; 
                      }
		}
				
                $this->Template->headline = $this->headline;
		$this->Template->entries = $arrCats;
                $this->Template->JSOptionShowActive = $JSOptionShowActive;
                $this->Template->form_submit = 'ad_selectcat_form'.$this->id;
                $this->Template->isError = $this->error;
                $this->Template->errorText = '<p class="error">Bitte selektieren Sie eine Kategorie zu Ihrer Anzeige</p>';
               # $this->Template->action = $this->urlEncode($myHelper->createURL('id',$this->mcsp_next_jumpTo,'','',true,false));
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
			'class'=> strcmp($curcat,$objCats->id)==0?'active':'normal'
		      );	
		      if(strcmp($curcat,$objCats->alias)==0) $active= true;	     
		}
		#$arrCats['subactive'] = $active;
		return $arrCats;	
	}

}

?>