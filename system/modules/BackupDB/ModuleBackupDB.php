<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Softleister 2007-2010 <info@softleister.de>
 * @author     Hagen Klemp
 * @package    BackupDB
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleBackupDB 
 *
 * @copyright  Softleister 2007-2010 (www.softleister.de)
 * @author     Hagen Klemp  
 * @package    BackupDB
 */
class ModuleBackupDB extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_backup_db';

        /**
         * Function gives Filename for WS template
         */
        protected function getWsName( )
        {
          $result = $GLOBALS['TL_CONFIG']['websiteTitle'];
          $result = str_replace( " - ", "_", $result );
          $result = str_replace( " ",  "_", $result );
          $result = str_replace( ".",  "", $result );
          $result = str_replace( ",",  "", $result );
          $result = str_replace( "\\", "", $result );
          $result = str_replace( "/",  "", $result );
          $result = str_replace( ":",  "", $result );
          $result = str_replace( "*",  "", $result );
          $result = str_replace( "?",  "", $result );
          $result = str_replace( "\"", "'", $result );
          $result = str_replace( "<",  "(", $result );
          $result = str_replace( ">",  ")", $result );
          $result = str_replace( "|",  "", $result );

          return $result;
        }
        
        /**
         * Function check cron job
         */
        protected function checkCron( )
        {
          $result = 0;                      // kein Cron
          if( $this->Database->tableExists( 'tl_cron' ) ) {
            $result = 1;                    // Cron vorhanden, kein Job
	    $abjob = $this->Database->prepare("SELECT * FROM tl_cron WHERE `job`='system/modules/BackupDB/AutoBackupDB.php' LIMIT 1")->execute();
            if( $job = $abjob->fetchAssoc() ) {
              if( $job['enabled'] )
                $result = 3;                // Cron vorhanden, Job AKTIV
              else
                $result = 2;                // Cron vorhanden, Job INAKTIV
            }
          }
          return $result;
        }
        
	/**
	 * Generate module
	 */
	protected function compile()
	{
          //--- Zielverzeichnis für Website-Templates ---  einstellbar 30.9.2009 Softleister
          $zielVerz = 'templates';
          if( isset( $GLOBALS['BACKUPDB']['WsTemplatePath'] ) && is_dir(TL_ROOT.'/'.trim($GLOBALS['BACKUPDB']['WsTemplatePath'], '/')) )
            $zielVerz = trim($GLOBALS['BACKUPDB']['WsTemplatePath'], '/');

	  $this->Template->backup_text         = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['backup_text'];
	  $this->Template->button_caption      = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['button_caption'];
	  $this->Template->button_title        = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['button_title'];

	  $this->Template->ws_template_text    = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_text'];
          $this->Template->ws_template_sqlfile = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_sqltxt'] . '/'.$zielVerz.'/' . $this->getWsName() . '.sql';
          $this->Template->ws_template_txtfile = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_sqltxt'] . '/'.$zielVerz.'/' . $this->getWsName() . '.txt';
	  $this->Template->ws_template_caption = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_caption'];
	  $this->Template->ws_template_files   = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_files'];
	  $this->Template->ws_button_title     = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_button_title'];

	  $this->Template->ws_cron_text1       = '[<a href="'.$this->Environment->base . $this->Environment->request.'&amp;op=cron">'.$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_cron1'].'</a>]';
	  $this->Template->ws_cron_text2       = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_cron2'];
	  $this->Template->ws_cron_text3       = $GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_cron3'];
	  
          if( ($this->Input->get('op') == 'cron') && ($this->checkCron() == 1) ) {
            $sql = "INSERT INTO `tl_cron` "
                  ."(`id`, `tstamp`, `lastrun`, `nextrun`, `scheduled`, `title`, `job`, `t_minute`, `t_hour`, `t_dom`, `t_month`, `t_dow`, `runonce`, `enabled`, `logging`) "
                  ."VALUES ( 0, " . time() . ", 0, 0, 0, 'AutoBackupDB', 'system/modules/BackupDB/AutoBackupDB.php', '0', '2', '*', '*', '*', '', '', '1')";
            $this->Database->prepare( $sql )->execute();      // inaktiven Cronjob eintragen
            $this->reload();
          }

          $this->Template->ws_cron = $this->checkCron();
	}
}

?>