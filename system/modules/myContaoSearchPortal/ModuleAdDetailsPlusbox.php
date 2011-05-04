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
class ModuleAdDetailsPlusbox extends Module
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

			$objTemplate->wildcard = '### ANZEIGEN-Detai-PlusBox ###';

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
		$myHelper = new myPortalHelper;
		
		$this->Template->id = $resultObj->id;
		$this->Template->backlink = $this->getReferer();
		$this->Template->wishlistlink = $this->urlEncode($myHelper->createURL('id',$this->mcsp_wishlist_jumpTo,'anzeige='.$this->Input->get('anzeige'),'',true,false));
		$this->Template->printlink = $this->urlEncode($myHelper->createURL('id',$this->mcsp_print_jumpTo,'anzeige='.$this->Input->get('anzeige'),'',true,false));
		$this->Template->sharelink = $this->urlEncode($myHelper->createURL('id',$this->mcsp_share_jumpTo,'anzeige='.$this->Input->get('anzeige'),'',true,false));
		$this->Template->reportinglink = $this->urlEncode($myHelper->createURL('id',$this->mcsp_reporting_jumpTo,'anzeige='.$this->Input->get('anzeige'),'',true,false));
		
		$GLOBALS['TL_CSS'][] = 'system/modules/myContaoSearchPortal/html/css/campain_layer.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/myContaoSearchPortal/html/js/campainLayer.js';
		$GLOBALS['TL_MOOTOOLS'][] = '<div id="overLay"></div><div id="layer"><div id="closeBtn"></div><div id="layercontent"></div></div><!--#layer-->';
		$GLOBALS['TL_MOOTOOLS'][] = '<script type="text/javascript">
		<!--//--><![CDATA[//><!--
		window.addEvent(\'domready\', function() {		      
		    $$("a.cllshare").addEvent("click", function(event){
		      event.stop();
		      var share = new  myLayer({
			    drawOverLay:false, 
			    drawLayer:false, 
			    drawContent: false, 
			    drawCloseBtn:false, 
			    drawMlIframe: true, 
			    itemcount: 1, 
			    mkLinkEvents:false, 
			    showNow: false, 
			    overLayOpacity:0.7,
			    layerWidth:300,
			    layerHeight:550		    		      
		      }).open(this);			
		    });
		    $$("a.cllreport").addEvent("click", function(event){
		        event.stop();
			var report = new  myLayer({
			    drawOverLay:false, 
			    drawLayer:false, 
			    drawContent: false, 
			    drawCloseBtn:false, 
			    drawMlIframe: true, 
			    itemcount: 1, 
			    mkLinkEvents:false, 
			    showNow: false, 
			    overLayOpacity:0.7,
			    layerWidth:300,
			    layerHeight:420			    		      
		      }).open(this);
                    });
                    $$("a.cllwishlist").addEvent("click", function(event){
		        event.stop();
			var wishlist = new  myLayer({
			    drawOverLay:false, 
			    drawLayer:false, 
			    drawContent: false, 
			    drawCloseBtn:false, 
			    drawMlIframe: true, 
			    itemcount: 1, 
			    mkLinkEvents:false, 
			    showNow: false, 
			    overLayOpacity:0.7,
			    layerWidth:600,
			    layerHeight:420			    		      
		      }).open(this);
                    });
		});
		//--><!]]>    
		</script>';
    		    
      }
}

?>