<?php
/**
*  myHelper-Class for Geldkoffer-Modules
*
*/
     
class myPortalHelper extends Frontend
{
    
    /**
     * target-Image-Path for created new Images
     * @var string
     */           
   public function getRgbFromHex($dataArr)
   {
       $colors = array();
       
       $aktValues = $dataArr['pd']['aktValues'];
       
       if(strlen(substr($aktValues['aktMotive_color'],5))==6)
       {
	   $hex = substr($aktValues['aktMotive_color'],5);
	   $hexcolors = str_split($hex,2);
	   foreach($hexcolors As $key => $color) $colors[$key] = hexdec($color);
	   
       } 
       elseif($aktValues['aktMotive_color'][0]=='#') 
       {
	   
	   $hex = substr($aktValues['aktMotive_color'],1);
	   $hexcolors = str_split($hex,2);
	   foreach($hexcolors As $key => $color) $colors[$key] = hexdec($color);
       
       }
       return $colors;
   }
    
	
    public function getSeoFromRequest($request,$checkkey)
    {
	     	$queryVar="";
	     	$getvar=$this->Input->get('Kategorie');
		$requestUri = $this->Environment->requestUri;
		
		if(!empty($getvar)) $queryVar = $getvar;		   		    
		
		if(!$queryVar)
		{
		    if(!empty($requestUri))
		    {	
		        $requestUri=urldecode($requestUri);
		        
			preg_match('/.*\/([A-Za-z0-9-_ ]*)\.html/', $requestUri, $array);
			if(count($array[1])>0) $queryVar = $array[1];
		    }	
		}
		return $queryVar;
	}
	        
        public function createURL($type='url',$strUrl='',$queryStr='',$extraQuery='',$newget=false,$seo=false)
        {	  

            if($type=='id')
            {
		$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
			->limit(1)
			->execute($strUrl);
			
		$pageArr = ($objPage->numRows) ? $objPage->fetchAssoc() : array();
		
                $strUrl = $this->addQueryToUrl($pageArr,$queryStr,$newget,$seo);
                
            }elseif($type=='url'){
		$url = clone $this;
		$strUrl = $url->addToUrl($queryStr);
	    }
	    if(!empty($extraQuery)) $strUrl .= (!strstr($strUrl,'?'))?'?'.$extraQuery:'&amp;'.$extraQuery; 
	    return  $strUrl;
        }
        
        protected function addQueryToUrl($pageArr,$strRequest,$newget,$seo=false)
	{
		if($newget) $arrGet=array();
		else $arrGet = $_GET;
		if($strRequest!='')
		{
		    $arrFragments = preg_split('/&(amp;)?/i', $strRequest);
		    foreach ($arrFragments as $strFragment)
		    {
			    $arrParams = explode('=', $strFragment);
			    $arrGet[$arrParams[0]] = $arrParams[1];
		    }
                }
		$strParams = '';
                
		if(count($arrGet)>0)foreach ($arrGet as $k=>$v)
		{
			if($seo)  $strParams .= $GLOBALS['TL_CONFIG']['disableAlias'] ? '&amp;' . $k . '=' . $v  : '/' . $v;
			else  $strParams .= $GLOBALS['TL_CONFIG']['disableAlias'] ? '&amp;' . $k . '=' . $v  : '/' . $k . '/' . $v;
		}

		// Do not use aliases
		if ($GLOBALS['TL_CONFIG']['disableAlias'])
		{
			return 'index.php?' . preg_replace('/^&(amp;)?/i', '', $strParams);
		}

		$pageId = strlen($pageArr['alias']) ? $pageArr['alias'] : $pageArr['id'];
  
		// Get page ID from URL if not set
		if (empty($pageId))
		{
			$pageId = $this->getPageIdFromUrl();
		}

		return ($GLOBALS['TL_CONFIG']['rewriteURL'] ? '' : 'index.php/') . $pageId . $strParams . $GLOBALS['TL_CONFIG']['urlSuffix'];
	}
	
	public function setVoucherStatus(){
						
		//alle grundsätzlich erstmal auf status="nicht aktiv" (0) setzen
		$this->Database->execute("UPDATE `tl_gk_vouchers` SET `status`='0'");
		
		//alle im Bereich zwischen start und Ende auf status="aktiv" (1) setzten		
		$this->Database->execute("UPDATE `tl_gk_vouchers` SET `status`='1' 
						    WHERE date(from_unixtime(`tl_gk_vouchers`.`start`)) <= '".date('Y-m-d')."'
						    AND date(from_unixtime(`tl_gk_vouchers`.`stop`)) >= '".date('Y-m-d')."'");
		
		//alle im Bereich zwischen start und Ende auf status="Nachlauf" (2) setzten		
		$this->Database->execute("UPDATE `tl_gk_vouchers` SET `status`='2' 
						    WHERE date(from_unixtime(`tl_gk_vouchers`.`stop`)) < '".date('Y-m-d')."'
						    AND adddate(from_unixtime(`tl_gk_vouchers`.`stop`),3) >= '".date('Y-m-d')."'");
		return;				    				
	}

	
	/**
	 * Get Table-Entry-ID with this alias
	 * @param string
	 * @param string
	 * @return int
	 */
	public function getIdFromAlias($alias='', $table='')
	{
	    $this->import('Database');
	    
	    if(!strlen($alias)) return false;
	    if(!strlen($table)) return false;
	    
	    $result = $this->Database->prepare('SELECT `id` FROM '.$table.' WHERE `alias`=?')
		    ->limit(1)
		    ->execute($alias);

	    if($result->numRows > 0) return (int) $result->id;
	    else return false;
	}
		
	/**
	 * clean and extract video-path
	 * @param string
	 * @param string
	 * @return int
	 */
	public function extractVideoPath($text='',$plattform='youtube')
	{
	     
	     //wenn direkt eine URL eingegeben wurde ohne embed-Code sauber gleich wieder zurück geben
	     if(substr($text,0,4)=='http'){
		 $text = strip_tags($text);
		 return $text;
	     }
	     
	     //nach Videoportal den URL extrahieren
	     $video_url = '';
	     
	     if(strlen($text))
	     {
		 switch($plattform)
		 {
		     case 'youtube':
		     case 'vimeo':
			   
			   preg_match('/(src)=("[^"]*")/i', $text,$srcmatch);
			   if (count($srcmatch)) {
			    
				 $video_url = str_replace(array('\'','"'),'',strip_tags($srcmatch[2]));
			    }else  $video_url = '';
		    break;
		    case 'myvideo':
			    
			  preg_match("/(value)=('[^']*')/i", $text,$srcmatch);
			  if (count($srcmatch)) {
				
				$video_url = str_replace(array('\'','"'),'',strip_tags($srcmatch[2]));
				
			  }else $video_url = '';				      		 
		     break;
		 }
	     }
	     return $video_url;
	}
		
	//brutto berechen
	public function brutto($wert) {
		return number_format($wert + ($wert/100*MWST), 2, '.', '');
	}

	//netto berechen
	public function netto($wert) {
  	return number_format($wert / (100 + MWST) * 100, 2, '.', '');
	}
			
	/**
	 * clean text and delete html-tags and links 
	 * @param string
	 * @param string
	 * @return string
	 */			
	public function cleanText($text='')
	{
	      //html-tags entfernen
	      $aktval = strip_tags($text);
	      
	      //URL aus Text entfernen			  
	      $regExpr2 = "#(((file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp)://)|(www\.))+(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(/[^ <]*)?#";
	      $aktval = preg_replace($regExpr2,'',$aktval);
	      	
	      return $aktval;
	}
			
	/**
	 * get better human reedable date-Format
	 * @param string
	 * @param string
	 * @return string
	 */			
	public function getHumandate($date='')
	{
              if(empty($date)) return '';
	      	
	      $anzdate = date($GLOBALS['TL_CONFIG']['dateFormat'],$date);
	      $today = date($GLOBALS['TL_CONFIG']['dateFormat']);
	      $yesterday = date($GLOBALS['TL_CONFIG']['dateFormat'],time() - (24 * 60 * 60));
	      
	      if(strcmp($anzdate,$today)==0) return 'heute '. date($GLOBALS['TL_CONFIG']['timeFormat'],$date);
	      elseif(strcmp($anzdate,$yesterday)==0) return 'gestern '. date($GLOBALS['TL_CONFIG']['timeFormat'],$date);
	      else return date($GLOBALS['TL_CONFIG']['datimFormat'],$date);
	}
	
	/**
	 * get Price-String in PriceFormat plus delevery
	 * @param float
	 * @param string
	 * @return string
	 */							
	public function getPriceString($price=0,$vb='')
	{
            
            $str='';
            $this->portalSettings();
            
            if($price > 0)
            {
		$price = str_replace(',','.',$price);
		$str  =  number_format($price,2,',','.').htmlentities($this->portalSettings->currency_symbol,ENT_QUOTES,'UTF-8');
	    }
	    $str .= ($vb)?' VB':'';
	    return $str;
	}
	
	/**
	 * get global Portal-Settings
	 * @return string
	 */					
	public function portalSettings()
	{
	    $resultObj = $this->Database->prepare('SELECT * FROM `tl_mcsp_settings`')
		    ->limit(1)
		    ->execute();
	    $this->portalSettings = $resultObj;	
	}
	
	/**
	 * get Distance between two locations
	 * @param string
	 * @param string
	 * @return string
	 */	
	public function getDistance($actpointID='',$destinationID='')
	{
	    if($actpointID=='' ||  $destinationID=='') return '';
	    
	    $actpointID = (int) $actpointID;
	    $destinationID = (int) $destinationID;
	    
	    $pointObj = $this->Database->prepare('SELECT * FROM zip_coordinates WHERE `zc_id`= ?')->limit(1)->execute($actpointID);

	    $distanceObj = $this->Database->prepare('SELECT 
		ACOS(
		     SIN(RADIANS(zc_lat)) * SIN(RADIANS('.$pointObj->zc_lat.')) 
		     + COS(RADIANS(zc_lat)) * COS(RADIANS('.$pointObj->zc_lat.')) * COS(RADIANS(zc_lon)
		     - RADIANS('.$pointObj->zc_lon.'))
		     ) * 6380 AS distance
	    FROM zip_coordinates
	    WHERE `zc_id` = ?')
		    ->limit(1)
		    ->execute($destinationID);
	    
	    return $distanceObj->distance;
	}
	
	public function getZcId($zipcityStr = '')
	{
	     if($zipcityStr=='') return false;
	     
	     $parts = explode(' ',$zipcityStr);
	     
	     $pointObj = $this->Database->prepare('SELECT `zc_id` FROM zip_coordinates WHERE `zc_zip`= ? AND `zc_location_name` = ?')->limit(1)->execute($parts[0],$parts[1]); 
	     
	     return $pointObj->zc_id;
	}
}     
?>