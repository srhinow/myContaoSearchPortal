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
 * @author    Sven Rhinow <sven@sr-tag.de>
 * @package    myContaoSearchPortal
 * @license    LGPL
 * @filesource
 */


/**
 * Table tl_mcsp_smallads
 */
$GLOBALS['TL_DCA']['tl_mcsp_smallads'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('createdate'),
			'flag'                    => 7,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title','adid'),
			'format'                  => '%s (%s)'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_mcsp_smallads']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('is_picture','is_video','is_link'),		
		'default' => 'typeid,categoryid,title,alias,adid,description;basic_agreement,price;userid,zc_id,address,stateid;{options_legend:hide},is_picture,is_video,is_link,is_title_hightlight,is_bg_hightlight,view_type;createdate'
	),
	// Subpalettes
	'subpalettes' => array
	(
		'is_picture'                  => 'pictures',
		'is_video'                    => 'video_title,int_videopath,ext_videopath,ext_videoportal',
		'is_link'                    => 'link_text,link_url',

	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>155,'tl_class'=>'long','allowHtml'=>false)
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_article']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128),
			'save_callback' => array
			(
				array('tl_mcsp_smallads', 'generateAlias')
			)

		),
		'adid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['adid'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true),
			'save_callback' => array
			(
				array('tl_mcsp_smallads', 'generateAdId')
			)

		),				
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['description'],
			'exclude'                 => true,
			'filter'                  => false,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>false),
			'save_callback' => array
			(
				array('tl_mcsp_smallads', 'cleanText')
			)			
			
		),
		'userid' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['userid'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_member.username',
			'eval'                    => array('includeBlankOption'=>false)
		),
		'categoryid' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['categoryid'],
// 			'exclude'                 => true,
			'filter'                  => true,
// 			'sorting'                 => true,
			'inputType'               => 'select',
// 			'foreignKey'              => 'tl_mcsp_categories.name',
// 			'reference'		  => 'categoryid',
			'options_callback'        => array('tl_mcsp_smallads','generateCategoryOptions'),
			'eval'                    => array('includeBlankOption'=>false)
		),
		'zc_id' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['zc_id'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_mcsp_smallads','generateLocateOptions'),
			'eval'                    => array('includeBlankOption'=>false)
		),
		'address' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_article']['address'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array( 'doNotCopy'=>true, 'maxlength'=>255),

		),						
		'invoiceid' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['invoiceid'],
			'exclude'                 => true,
			'filter'                  => false,
			'sorting'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_member.username',
			'eval'                    => array('includeBlankOption'=>false)
		),
		'typeid' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['typeid'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_mcsp_types.name',
			'eval'                    => array('includeBlankOption'=>false)
		),
		'stateid' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['stateid'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_mcsp_states.name',
			'eval'                    => array('includeBlankOption'=>false)
		),
		'basic_agreement' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['basic_agreement'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			
		),
		'price' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['price'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'extnd', 'maxlength'=>25)
		),				
		'is_picture' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['is_picture'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
			
		),				
		'is_video' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['is_video'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
			
		),		
		'video_title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['video_title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'extnd', 'maxlength'=>255,'tl_class'=>'long'),
		),
		'int_videopath' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['int_videopath'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'fileTree',
			'eval'                    => array('path'=>'tl_files/mein-anzeigenportal/costumer','fieldType'=>'radio','extensions'=>'mov,mp4,ogm', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false, 'multiple'=>false)
		),		
		'ext_videopath' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['ext_videopath'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>false,'rows'=>'4','style'=>'height:60px;','allowHtml'=>true),
			'save_callback' => array
			(
				array('tl_mcsp_smallads', 'getVideoUrlPath')
			)			
		),
		'ext_videoportal' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['ext_videoportal'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'select',
			'options'              	  => array('youtube'=>'Youtube','myvideo'=>'myVideo','vimeo'=>'Vimeo')
		),
		'is_link' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['is_link'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
			
		),	
		'link_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['link_text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'extnd', 'maxlength'=>55,'tl_class'=>'long'),
		),
		'link_url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['link_url'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'url', 'maxlength'=>255,'tl_class'=>'long'),
		),											
		'is_title_hightlight' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['is_title_hightlight'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			
		),
		'is_bg_hightlight' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['is_bg_hightlight'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			
		),
		
		'pictures' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['pictures'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'fileTree',
			'eval'                    => array('path'=>'tl_files/mein-anzeigenportal/costumer','fieldType'=>'checkbox','extensions'=>'jpg,jpeg', 'files'=>true, 'filesOnly'=>false, 'mandatory'=>false, 'multiple'=>true)
		),
		'view_type' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['view_type'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options'              	  => array('default'=>'Standart','pushup'=>'Push-Up','premium'=>'Premium'),
			'eval'                    => array('includeBlankOption'=>false)
		),
		'createdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['createdate'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),							
	)
	
);


/**
 * Class tl_mcsp_smallads
 */
class tl_mcsp_smallads extends Backend
{

	/**
	 * Return the link picker wizard
	 * @param object
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		$strField = 'ctrl_' . $dc->field . (($this->Input->get('act') == 'editAll') ? '_' . $dc->id : '');
		return ' ' . $this->generateImage('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top; cursor:pointer;" onclick="Backend.pickPage(\'' . $strField . '\')"');
	}
	
 	/**
	 * generate an array with parent-category as optgroup
	 * @param mixed
	 * @param object
	 * @return array
	 */
	public function generateCategoryOptions()
	{
	    $items = array();
	    
	    $objCats = $this->Database->prepare("SELECT * FROM `tl_mcsp_categories` 
						WHERE `active`='1' AND `pid`=0 ORDER BY `sorting`")
				    ->execute();
	    // get subcats
	    if ($objCats->numRows > 0)
	    {
		while($objCats->next())
		{
		    $objSubCats = $this->Database->prepare("SELECT * FROM `tl_mcsp_categories` WHERE `pid`=? AND `active`='1' ORDER BY `sorting`")
						->execute($objCats->id);
		    if ($objSubCats->numRows > 0)
		    {
			while($objSubCats->next())
			{
			    $items[$objCats->name][$objSubCats->id] = $objSubCats->name;
			}
		    }
		}					    
		
	    }
	   # print_r($items);
	   return $items;
	}
	
	/**
	 * getVideoUrlPath
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function getVideoUrlPath($varValue, DataContainer $dc)
	{
		
                if(empty($varValue)) return '';
                
		return myPortalHelper::extractVideoPath($varValue,$dc->activeRecord->ext_videoportal);
	}
	
	/**
	 * cleanText
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function cleanText($varValue, DataContainer $dc)
	{
		
                if(empty($varValue)) return '';
                
		return myPortalHelper::cleanText($varValue);
	}
	
	/**
	 * Autogenerate an article alias if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if (!strlen($varValue))
		{
			$autoAlias = true;
			$varValue = standardize($dc->activeRecord->title);
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_mcsp_smallads WHERE id=? OR alias=?")
								   ->execute($dc->id, $varValue);

		// Check whether the page alias exists
		if ($objAlias->numRows > 1)
		{
			if (!$autoAlias)
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
			}

			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}
	/**
	 * Autogenerate an public smallad-ID if it has not been set yet
	 * @param mixed
	 * @param object
	 * @return string
	 */
	public function generateAdId($varValue, DataContainer $dc)
	{
		$autoAdId = false;


		// Generate adid if there is none
		if (!strlen($varValue) || $varValue==0)
		{
			$objLastId = $this->Database->prepare("SELECT `adid` FROM `tl_mcsp_smallads` ORDER BY `adid` DESC")
						    ->limit(1)
						   ->execute();

                        if($objLastId->adid == 0)
                        {
			   $settingObj = $this->Database->prepare('SELECT `startadnumber` FROM `tl_mcsp_settings`')
							->limit(1)
							->execute();
			   $varValue = $settingObj->startadnumber; 
                        }
                        else
                        {
			    $varValue = $objLastId->adid;
                        }
                        
                        $autoAdId = true;
                   
		}
		
		//wenn Nummer neu gesetzt wird einen weiter zählen
		if($autoAdId) $varValue++;
		
		return $varValue;
	}	
		
	public function generateLocateOptions()
	{
	    $items = array();
	    
	    $objLocate = $this->Database->prepare("SELECT `zc_id`,`zc_zip`,`zc_location_name` FROM `zip_coordinates` ORDER BY `zc_zip`")
				      ->execute();
	    	    // get subcats
	    if ($objLocate->numRows < 1)    return $items;
		
	    while($objLocate->next())
	    {
	       $items[$objLocate->zc_id] = $objLocate->zc_zip.' '.$objLocate->zc_location_name;
	    }					    
	    
	    return $items;
		
	}
}




?>