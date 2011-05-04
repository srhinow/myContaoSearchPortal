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
class ModuleAdReportForm extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_adreportform';


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

			$objTemplate->wildcard = '### ANZEIGEN-REPORT-FORM ###';

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
		$cookieLifeTime = time()+3600*24*7;		
		$myHelper = new myPortalHelper;
		$myHelper->portalSettings();
                $portalSettings = $myHelper->portalSettings;
                
		//Unterkategorie per Get
		if(!$this->Input->get('anzeige')) 
		{
                   $this->Template->item = array();
                   return;
                }                                              

		//get adId from get-var
		$adObj = $this->Database->prepare('SELECT * FROM `tl_mcsp_smallads` WHERE `alias`= ?')
				       ->limit(1)
				       ->execute($this->Input->get('anzeige'));

                //formular-fieds
                $inputJustfication = new FormSelectMenu();
		$inputJustfication->id = 'justification';
		$inputJustfication->name = 'justification';
		$inputJustfication->label = 'Anlass';
		$inputJustfication->mandatory = true;				
		$inputJustfication->options = array( 
		    array('value'=>'', 'label'=>' bitte auswählen'),
		    array('value'=>'Spam','label'=>'Spam'),
		    array('value'=>'Betrug','label'=>'Betrug'),
		    array('value'=>'verbotener Artikel','label'=>'verbotener Artikel'),
		    array('value'=>'falsche Kategorie','label'=>'falsche Kategorie'),
		    array('value'=>'anderer Grund','label'=>'anderer Grund')
		);
		
                $inputNotice = new FormTextArea();
		$inputNotice->id = 'your_notice';
		$inputNotice->name = 'your_notice';
		$inputNotice->label = 'Ihre Nachricht (optional)';
// 		$inputNotice->mandatory = true;		
		$inputNotice->rgxp = 'extnd';	
			
                $inputCaptcha = new FormCaptcha();
		$inputCaptcha->id = 'captcha';
		$inputCaptcha->name = 'captcha';
		$inputCaptcha->label = 'Spam-Schutz';
		$inputCaptcha->mandatory = true;		
		
		//if form send
		if($this->Input->post('FORM_SUBMIT')=='ad_report_form'.$this->id)
		{

		    $justification = $this->Input->post('justification');
		    $notice = $this->Input->post('your_notice');
		    $captcha = $this->Input->post('captcha');
		    							
		    $inputJustfication->validate();
		    if($inputJustfication->hasErrors()) $this->formError = true;	    
		    
		    $inputNotice->validate();
		    if($inputNotice->hasErrors()) $this->formError = true;
		    
		    $inputCaptcha->validate();
		    if($inputCaptcha->hasErrors()) $this->formError = true;
		    							
		    //if not errors
		    if(!$this->formError)
		    {
			//Email mit Zugangsdaten senden
			$email = new Email();
			$email->from = $this->mcsp_email_fromAddress;
			$email->fromName = $this->mcsp_email_fromText;
			$email->charset = 'UTF-8';
			$email->subject = $this->mcsp_email_subject;
						
			$this->mcsp_email_text = str_replace('{{domain}}', $this->Environment->base.$this->urlEncode($myHelper->createURL('id',$this->mcsp_detail_jumpTo,'anzeige='.$this->Input->get('anzeige'),'',true,false)), $this->mcsp_email_text);
			$this->mcsp_email_text = str_replace('{{justification}}', $justification, $this->mcsp_email_text);
			$this->mcsp_email_text = str_replace('{{notice}}', $notice, $this->mcsp_email_text);
			$this->mcsp_email_text = str_replace('{{ip}}', $this->Environment->ip, $this->mcsp_email_text);
			$this->mcsp_email_text = str_replace('{{browser}}', $this->Environment->httpUserAgent, $this->mcsp_email_text);
			$email->text = $this->mcsp_email_text;

						
			$email->sendTo($this->mcsp_email_toAddress);
			
			//als gesendet markieren
			/*$this->setCookie('success'.$adObj->id, 1, $cookieLifeTime);	*/					
			$this->Template->sendFormSuccessText = $this->mcsp_email_success;
		    }
		    
		}				
		
		//set values for template
		$this->Template->id = $resultObj->id;
		$this->Template->moduleId = $this->id;
		$this->Template->form_submit = 'ad_report_form'.$this->id;
		    
		$this->Template->inputJustfication = $inputJustfication;
		$this->Template->inputNotice = $inputNotice;
		$this->Template->inputCaptcha = $inputCaptcha;   
		    
		//customer css-file forr this module 
		if(strlen($this->mcsp_css_file)>0) 
		{
		    $cssfiles = unserialize($this->mcsp_css_file);		    
		    foreach($cssfiles as $k => $v) $GLOBALS['TL_CSS'][] = $v; 
		}
      }
}

?>