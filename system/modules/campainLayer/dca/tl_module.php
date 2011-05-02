<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This file modifies the data container array of table tl_module.
 *
 * @copyright  Sven Rhinow 2011
 * @author     Sven Rhinow <sven@sr-tag.de>
 * @package    CampainLayer
 * @license    LGPL
 * @filesource

 */
 
$GLOBALS['TL_DCA']['tl_module']['palettes']['campain_layer']  = 'name,type;cl_content,cl_template,cl_css_file,cl_no_param,cl_substr;cl_option_layerwidth,cl_option_layerheight,cl_option_other;cl_set_cookie,cl_cookie_name,cl_cookie_dauer';

array_insert($GLOBALS['TL_DCA']['tl_module']['fields'] , 2, array
(
	'cl_template' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cl_template'],
		'exclude'                 => true,
		'inputType'               => 'select',
// 		'options'                 => $this->getTemplateGroup('cnt_')
		'options_callback'	  => array('kampagnen_layer','get_Template'),
		'eval'			=> array('tl_class'=>'clr')
	),
	'cl_content'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_option_other'],
	    'exclude' => true,
	    'inputType'  => 'textarea',
	    'eval' => array('mandatory'=>false,'rte'=>false,'allowHtml'=>true,'tl_class'=>'clr'),
	),
	'cl_substr'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_substr'],
	    'exclude' => true,
	    'inputType' => 'text',
	    'eval' => array('mandatory'=>false,'maxlength'=>55,'tl_class'=>'w50'),
	),

	'cl_css_file' => array
	(
	    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cl_css_file'],
	    'exclude'                 => true,
	    'inputType'               => 'fileTree',
	    'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'mandatory'=>false,'extensions'=>'css','tl_class'=>'clr')
	),
	'cl_no_param' => array
	(
	    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cl_no_param'],
	    'exclude'                 => true,
	    'inputType'               => 'checkbox',
	),
	'cl_set_cookie' => array
	(
	    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cl_set_cookie'],
	    'exclude'                 => true,
	    'inputType'               => 'checkbox',
	),
	'cl_cookie_name'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_cookie_name'],
	    'exclude' => true,
	    'inputType' => 'text',
	    'eval' => array('mandatory'=>false,'maxlength'=>55),
	),
	'cl_cookie_dauer'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_cookie_dauer'],
	    'default' => 3600,
	    'exclude' => true,
	    'inputType' => 'text',
	    'eval' => array('mandatory'=>false,'maxlength'=>55,'rgxp'=>'digit'),
	),
	'cl_option_layerwidth'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_layer_width'],
	    'default' => '600',
	    'exclude' => true,
	    'inputType' => 'text',
	    'eval' => array('mandatory'=>true,'maxlength'=>55,'tl_class'=>'w50','rgxp'=>'digit'),
	),
	'cl_option_layerheight'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_layer_height'],
	    'default' => '450',
	    'exclude' => true,
	    'inputType' => 'text',
	    'eval' => array('mandatory'=>true,'maxlength'=>55,'tl_class'=>'w50','rgxp'=>'digit'),
	),
	'cl_option_other'=> array
	(
	    'label' => &$GLOBALS['TL_LANG']['tl_module']['cl_option_other'],
	    'exclude' => true,
	    'default' => '
	drawOverLay:false,
	drawLayer:false,
	drawContent: false,
	drawCloseBtn:false,
	drawMlIframe: false,
	itemcount: 1,
	mkLinkEvents: false,
	showNow: true,
	overLayOpacity:0.7
	',
	    'inputType'  => 'textarea',
	    'eval' => array('mandatory'=>false,'rte'=>false,'allowHtml'=>true,'tl_class'=>'clr'),
	),			
));
/**
 * Class tl_ourimages
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2008-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Controller
 */
class kampagnen_layer extends Backend
{

     public function get_Template(DataContainer $dc)
    {
	if(version_compare(VERSION.BUILD, '2.9.0','>='))
	{
	    return $this->getTemplateGroup('cl_', $dc->activeRecord->pid);
	}else{
	    return $this->getTemplateGroup('cl_');
	}
    }

 }
?>