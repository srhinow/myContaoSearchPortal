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
class ModuleAdDetailsSidebar extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mcsp_adsidebar';


	/**
	 * Target pages
	 * @var array
	 */
	protected $arrTargets = array();

 	/**
	 * form error
	 * @var bool
	 */
	protected $formError = false;
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ANZEIGEN-Detail-Sidebar ###';

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
		$adObj = $this->Database->prepare('SELECT `id` FROM `tl_mcsp_smallads` WHERE `alias`= ?')
				       ->limit(1)
				       ->execute($this->Input->get('anzeige'));

                //formular-fieds
                $inputEmail = new FormTextField();
		$inputEmail->id = 'your_email';
		$inputEmail->name = 'your_email';
		$inputEmail->label = 'Ihre E-Mail-Adresse';
		$inputEmail->mandatory = true;		
		$inputEmail->rgxp = 'email';
		
                $inputNotice = new FormTextArea();
		$inputNotice->id = 'your_notice';
		$inputNotice->name = 'your_notice';
		$inputNotice->label = 'Ihre Nachricht';
		$inputNotice->mandatory = true;		
		$inputNotice->rgxp = 'extnd';	
			
                $inputCaptcha = new FormCaptcha();
		$inputCaptcha->id = 'captcha';
		$inputCaptcha->name = 'captcha';
		$inputCaptcha->mandatory = true;		
		
		//if form send
		if($this->Input->post('FORM_SUBMIT')=='ad_contact_form'.$adObj->id)
		{
		    $your_email = $this->Input->post('your_email');
		    $notice = $this->Input->post('your_notice');
		    $captcha = $this->Input->post('captcha');
		    							
		    $inputEmail->validate();
		    if($inputEmail->hasErrors()) $this->formError = true;
		    $inputNotice->validate();
		    if($inputNotice->hasErrors()) $this->formError = true;
		    $inputCaptcha->validate();
		    if($inputCaptcha->hasErrors()) $this->formError = true;
		    							
		    //if not errors
		    if(!$this->formError)
		    {
			$userObj = $this->Database->prepare('SELECT `tl_member`.* 
			FROM `tl_mcsp_smallads` 
			LEFT JOIN `tl_member` ON `tl_mcsp_smallads`.`userid` = `tl_member`.`id`
			WHERE `tl_mcsp_smallads`.`id`=? OR `tl_mcsp_smallads`.`alias`=?')
			->limit(1)
			->execute($this->Input->get('anzeige'), $this->Input->get('anzeige'));			
			
			#print $portalSettings->mail_adform_startText."\n E-Mail:".$email ."\nNachricht:".$notice."\n".$portalSettings->mail_adform_endText;
			//Email mit Zugangsdaten senden
			$email = new Email();
			$email->from = $portalSettings->mail_adform_fromEmail;
			$email->fromName = $portalSettings->mail_adform_fromText;
			$email->replyTo($your_email);
			$email->charset = 'UTF-8';
			$email->subject = $portalSettings->mail_adform_subject;
			$email->text ='text';
			$email->text =	"'".$portalSettings->mail_adform_startText."\n E-Mail:".$your_email ."\nNachricht:".$notice."\n".$portalSettings->mail_adform_endText."'";
			
			$email->sendTo($userObj->email);
			
			//als gesendet markieren
			$this->setCookie('success'.$adObj->id, 1, $cookieLifeTime);						
			$this->Template->sendFormSuccessText = $portalSettings->mail_adform_successText;
		    }
		    
		}
		else
		{
		    if($this->Input->cookie('success'.$adObj->id)) $this->Template->sendFormSuccessText = nl2br($portalSettings->mail_adform_successText);
                }
                //Suchanfragen berücksichtigen
                if(!$this->mcsp_ignore_filter)
                {
		    $searchWhereArr = array();		                    
		    $searchWhereStr  = '';
                
		    //Daten holen
		    $resultObj = $this->Database->prepare("SELECT 
		    `tl_mcsp_smallads`.* ,
		    `tl_member`.`groups`,
		    `tl_member`.`phone`,
		    `tl_member`.`mobile`,
		    `zip_coordinates`.`zc_zip` as `plz`,
		    `zip_coordinates`.`zc_location_name` as `ort`
		    FROM `tl_mcsp_smallads` 
		    LEFT JOIN `tl_member` ON `tl_mcsp_smallads`.`userid` = `tl_member`.`id`
		    LEFT JOIN `zip_coordinates` USING(`zc_id`)
		    WHERE `tl_mcsp_smallads`.`id`=? OR `tl_mcsp_smallads`.`alias`=?")
						->limit(1)
						->execute($this->Input->get('anzeige'),$this->Input->get('anzeige'));
		    if ($resultObj->numRows < 1)
		    {
			    #$this->Template->items = array();
			    return;
			    
		    }
		    //get first group (privat/gewerblich)
		    $groups = unserialize($resultObj->groups);
		    if(count($groups)>0)
		    {
			$groupObj = $this->Database->prepare('SELECT `name` FROM `tl_member_group` WHERE `id`=?')
						  ->limit(1)
						  ->execute($groups[0]);	  	                  
		    }	  	                  
		    
		    //get phoneNumber
		    $isPhone = false;
		    if(strlen($resultObj->phone) || strlen($resultObj->mobile))
		    {
			$isPhone = true;
			$number = strlen($resultObj->phone) ? $resultObj->phone : $resultObj->mobile;
		    }
		    
		    //set values for template
		    $this->Template->id = $resultObj->id;
		    $this->Template->moduleId = $this->id;
		    $this->Template->title = $resultObj->title;
		    $this->Template->adid = $resultObj->adid;
		    $this->Template->plz = $resultObj->plz;
		    $this->Template->ort = $resultObj->ort;
		    $this->Template->group = $groupObj->name;
		    $this->Template->address = $resultObj->address;
		    $this->Template->isPhone = $isPhone;
		    $this->Template->number = $number;
		    $this->Template->form_submit = 'ad_contact_form'.$adObj->id;
		    $this->Template->category = $resultObj->catname;		
		    $this->Template->price = $myHelper->getPriceString($resultObj->price,$resultObj->basic_agreement);
		    $this->Template->humandate = $myHelper->getHumandate($resultObj->createdate);
		    $this->Template->backlink = $this->getReferer();
			
		    $this->Template->inputEmail = $inputEmail;
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
}

?>