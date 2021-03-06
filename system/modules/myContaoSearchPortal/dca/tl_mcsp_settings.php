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
 * Table tl_mcsp_settings
 */
$GLOBALS['TL_DCA']['tl_mcsp_settings'] = array
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
			'mode'                    => 1,
			'fields'                  => array('name'),
			'flag'                    => 1,
			'panelLayout'             => 'search,limit'
		),
		'label' => array
		(
			'fields'                  => array('name'),
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_mcsp_settings']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__' => array('mail_customer'),
		'default' => '{title_legend},name,sslorder,startadnumber;{currency_legend:hide},currency,currency_symbol;{standards_legend:hide},tax,duration,costumer_group,mailarticle,paymentarticle,paymentarticle2,shippingarticle,mailcss,shippingpage;{customermails_legend:hide},mail_customer_from,mail_customer_subject,mail_customer_attach;{mail_addetailform:hide},mail_adform_fromEmail,mail_adform_fromText,mail_adform_subject,mail_adform_startText,mail_adform_endText,mail_adform_successText'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'mail_customer' => 'mail_customer_from,mail_customer_subject,mail_customer_attach',
		'mail_addetailform' => 'mail_adform_fromEmail,mail_adform_fromText,mail_adform_subject,mail_adform_startText,mail_adform_endText,mail_adform_successText',
	),

	// Fields
	'fields' => array
	(
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>64)
		),
		'sslorder' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['sslorder'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>false)
		),

		'tax' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['tax'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'duration' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['duration'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit')
		),		
		'costumer_group' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['costumer_group'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_member_group.name',
			'eval'                    => array('mandatory'=>false, 'multiple'=>true)
		),
		'currency' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['currency'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'currency_symbol' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['currencysymbol'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true)
		),
		'mail_customer_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_customer_from'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>email )
		),
		'mail_customer_subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_customer_subject'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true )
		),
		'mail_customer_attach' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_customer_attach'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'checkbox', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false)
		),
		'mailarticle' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mailarticle'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_article.title',
			'eval'                    => array('multiple'=>false, 'mandatory'=>false, 'includeBlankOption'=>true)
		),
		'mail_adform_fromEmail' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_adform_fromEmail'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>email )
		),
		'mail_adform_fromText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_adform_fromText'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true )
		),
		'mail_adform_subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mail_adform_subject'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'tl_class'=>'long')
		),
		'mail_adform_startText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['mail_adform_startText'],
			'exclude'                 => true,
			'filter'                  => false,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>false),			
			
		),
		'mail_adform_endText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['mail_adform_endText'],
			'exclude'                 => true,
			'filter'                  => false,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>false),			
			
		),
		'mail_adform_successText' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_smallads']['mail_adform_successText'],
			'exclude'                 => true,
			'filter'                  => false,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'cols'=>'5','rows'=>'30','rte'=>false,'allowHtml'=>false),			
			
		),						
		'paymentarticle' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['paymentarticle'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_article.title',
			'eval'                    => array('multiple'=>false, 'mandatory'=>false, 'includeBlankOption'=>true)
		),
		'paymentarticle2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['paymentarticle2'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_article.title',
			'eval'                    => array('multiple'=>false, 'mandatory'=>false, 'includeBlankOption'=>true)
		),
		'mailcss' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['mailcss'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_style_sheet.name',
			'eval'                    => array('multiple'=>false, 'mandatory'=>false, 'includeBlankOption'=>true)
		),
		'startadnumber' =>  array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mcsp_settings']['startadnumber'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'digit')
		),		
	)
);


/**
 * Class tl_mcsp_settings
 */
class tl_mcsp_settings extends Backend
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


}




?>