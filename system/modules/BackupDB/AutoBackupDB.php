<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

//-------------------------------------------------------------------
// AutoBackupDB.php	Backup Contao-Datenbank mit Cron-Job
//
// Copyright (c) 2007-2010 by Softleister
//
// Der Cron-Job nimmt diese Datei als Include-Datei für CronController.php
// aktueller Pfad bei Ausführung: system/modules/cron
//
// Ergänzung am 29.3.2009 durch Softleister:
// ------------------------------------------
// Anzahl der Backups einstellbar in localconfig.php (default: 3)
// $GLOBALS['BACKUPDB']['AutoBackupCount'] = 5;
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//  Backend um die Backup-Funktionen erweitern
//-------------------------------------------------------------------
class AutoBackupDb extends Backend      	// Datenbank ist bereits geöffnet
{
  //-------------------------
  //  Modulversion
  //-------------------------
  const Version = '1.2.0';
  
  //-------------------------
  //  Variablen
  //-------------------------
  protected $User = '';

  //-------------------------
  //  Constructor
  //-------------------------
  public function __construct( )
  {
    $this->import('BackendUser', 'User');	// User importieren
    parent::__construct(); 			// Construktor Backend ausführen
    $this->loadLanguageFile('default');		// Sprachenfiles laden
    $this->loadLanguageFile('modules');
    $this->loadLanguageFile('tl_BackupDB'); 
  }

  //------------------------------------------------
  //  Erzeugt die Strukturdefinitionen
  //------------------------------------------------
  private function getFromDB()
  {
    $tables = $this->Database->listTables( );
    if( !count($tables) ) return array( );		// keine Tabellen, leeres Array zurückgeben

    $return = array( );					// Ergebnisvariable vorbereiten

    foreach( $tables as $table ) {
      $fields = $this->Database->listFields( $table );	// Liste der Felder lesen

      foreach( $fields as $field ) {
	$name = $field['name'];
	$field['name'] = '`'.$field['name'].'`';

	// Field type
	if( strlen($field['length']) ) {
	  $field['type'] .= '(' . $field['length'] . (strlen($field['precision']) ? ',' . $field['precision'] : '') . ')';

	  unset( $field['length'] );
	  unset( $field['precision'] );
	}

	// Default values
	if( in_array(strtolower($field['type']), array('text', 'tinytext', 'mediumtext', 'longtext', 'blob', 'tinyblob', 'mediumblob', 'longblob', 'time', 'date', 'datetime')) || stristr($field['extra'], 'auto_increment') ) {
	  unset( $field['default'] );
	}

	else if( is_null($field['default']) || strtolower($field['default']) == 'null' ) {
	  $field['default'] = "default NULL";
	}

	else {
	  $field['default'] = "default '" . $field['default'] . "'";
	}

	// Indices
	if( strlen($field['index']) ) {
	  switch( $field['index'] ) {
	    case 'PRIMARY':	$return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'PRIMARY KEY  (`'.$name.'`)';
				break;

	    case 'UNIQUE':      $return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'UNIQUE KEY `'.$name.'` (`'.$name.'`)';
				break;

	    case 'FULLTEXT':    $return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'FULLTEXT KEY `'.$name.'` (`'.$name.'`)';
				break;

	    default:            if( (strpos(' '.$field['type'], 'text') || strpos(' '.$field['type'], 'char')) && ($field['null'] == 'NULL') )	// Fulltext-Search bei text-Fields
	    			  $return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'FULLTEXT KEY `'.$name.'` (`'.$name.'`)';
	    			else
	                	  $return[$table]['TABLE_CREATE_DEFINITIONS'][$name] = 'KEY `'.$name.'` (`'.$name.'`)';
				break;
	  }
          unset( $field['index'] );
	}
	$return[$table]['TABLE_FIELDS'][$name] = trim( implode(' ', $field) );
      }
    }
    
    // Table status
    $objStatus = $this->Database->prepare( "SHOW TABLE STATUS" )->execute( );
    while( $zeile = $objStatus->fetchAssoc() ) {
      $return[$zeile['Name']]['TABLE_OPTIONS'] = " ENGINE=".$zeile['Engine']." DEFAULT CHARSET=".substr($zeile['Collation'], 0, strpos($zeile['Collation'],"_"))."";
      if( $zeile['Auto_increment'] != "" ) $return[$zeile['Name']]['TABLE_OPTIONS'] .= " AUTO_INCREMENT=".$zeile['Auto_increment']." ";
    }

    return $return;
  }

  //-------------------------
  //  Backup ausführen
  //-------------------------
  public function run( )
  {
    @set_time_limit( 600 );
    
    $pfad = TL_ROOT . '/'.$GLOBALS['TL_CONFIG']['uploadPath'].'/AutoBackupDB';
    if( !file_exists( $pfad."/.htaccess" ) )
      copy( TL_ROOT . '/system/modules/BackupDB/htacc', $pfad . '/.htaccess' );
    
    //--- alte Backups aufrutschen ---  Anzahl einstellbar 29.3.2009 Softleister
    $anzBackup = 3;
    if( isset( $GLOBALS['BACKUPDB']['AutoBackupCount'] ) && is_int($GLOBALS['BACKUPDB']['AutoBackupCount']) )
      $anzBackup = $GLOBALS['BACKUPDB']['AutoBackupCount'];
    
    if( file_exists( $pfad."/AutoBackupDB-".$anzBackup.".sql" ) )
      unlink( $pfad."/AutoBackupDB-".$anzBackup.".sql" );
    for( ; $anzBackup > 1; $anzBackup-- ) {
      if( file_exists( $pfad."/AutoBackupDB-".($anzBackup-1).".sql" ) )
        rename( $pfad."/AutoBackupDB-".($anzBackup-1).".sql", $pfad."/AutoBackupDB-".$anzBackup.".sql" );
    }

    $heute = date( "Y-m-d" );
    $uhrzeit = date( "H:i:s" );

    //--- neue Datei AutoBackupDB-1.sql ---
    $datei = new File( $GLOBALS['TL_CONFIG']['uploadPath'].'/AutoBackupDB/AutoBackupDB-1.sql' );
    $datei->write( "#================================================================================\r\n"
                  ."# Contao-Website   : ".$GLOBALS['TL_CONFIG']['websiteTitle']."\r\n"
                  ."# Contao-Database  : ".$GLOBALS['TL_CONFIG']['dbDatabase']."\r\n"
                  ."# Saved by User    : ".$this->User->username." (".$this->User->name.")\r\n"
                  ."# Time stamp       : $heute at $uhrzeit\r\n"
                  ."#\r\n"
                  ."# Contao Extension : BackupDB, Version ".self::Version."\r\n"
                  ."# Copyright        : Softleister (www.softleister.de)\r\n"
                  ."# Author           : Hagen Klemp\r\n"
                  ."# Licence          : LGPL\r\n"
                  ."#\r\n"
                  ."# Visit Contao project page http://www.contao.org for more information\r\n"
                  ."#================================================================================\r\n" );
      
    $sqlarray = $this->getFromDB( );
    
    if( count($sqlarray) == 0 ) print "No tables found in database.";
    else {
      foreach( array_keys($sqlarray) as $table ) {
	$datei->write( "\r\n"
	              ."#---------------------------------------------------------\r\n"
	              ."# Table structure for table '$table'\r\n"
	              ."#---------------------------------------------------------\r\n"
                      ."CREATE TABLE `" . $table . "` (\n  " . implode(",\n  ", $sqlarray[$table]['TABLE_FIELDS']) . (count($sqlarray[$table]['TABLE_CREATE_DEFINITIONS']) ? ',' : '') . "\n" );
        if( is_Array( $sqlarray[$table]['TABLE_CREATE_DEFINITIONS'] ) )                     // Bugfix 29.3.2009 Softleister
          $datei->write( "  " . implode(",\n  ", $sqlarray[$table]['TABLE_CREATE_DEFINITIONS'])."\n" );
        $datei->write( ")" . $sqlarray[$table]['TABLE_OPTIONS'] . ";\r\n\r\n"
	              ."#\r\n"
	              ."# Dumping data for table '$table'\r\n"
	              ."#\r\n"
	              ."\r\n" );

        $objData = $this->Database->prepare( "SELECT * FROM $table" )->execute( );
        $fields = $this->Database->listFields( $table );		// Liste der Felder lesen

        while( $row = $objData->fetchRow() ) {
          $insert_data = "INSERT INTO `$table` VALUES (";
          $i = 0;							// Fields[0]['type']
          foreach( $row as $field_data ) {
	    if( !isset( $field_data ) )
	      $insert_data .= " NULL,";
	    else if( $field_data != "" ) {
	      switch( strtolower($fields[$i]['type']) ) {
	        case 'blob':
	        case 'tinyblob':
	        case 'mediumblob':
	        case 'longblob':    $insert_data .= " 0x";		// Auftackt für HEX-Darstellung
	                            $insert_data .= bin2hex($field_data);
	    			    $insert_data .= ",";		// Abschuß
	    			    break;
	    
	        case 'smallint':
	        case 'int':         $insert_data .= " $field_data,";
	    			    break;
	    
	        case 'text':
	        case 'mediumtext':  if( strpos( $field_data, "'" ) != false ) {  // ist im Text ein Hochkomma vorhanden, wird der Text in HEX-Darstellung gesichert
	        		      $insert_data .= " 0x" . bin2hex($field_data) . ",";
	    			      break;
	    			    }
	    			    // else: weiter mit default  
	    
	        default:	    $insert_data .= " '".str_replace( array("\\", "'", "\r", "\n"), array("\\\\", "\\'", "\\r", "\\n"), $field_data )."',";
				    break;
	      }
	    }
	    else
	      $insert_data .= " '',";
	    $i++;						// Next Field
          }
          $insert_data = trim( $insert_data, ',' );
          $insert_data .= ")";
          $datei->write( "$insert_data;\r\n" );		// Zeile ausgeben
        }
      }
    }
    $datei->write( "\r\n# --- End of Backup ---\r\n" );     // Endekennung
    $datei->close();
  }	// end function definition
  
  //------------------------------------------------
}	// End class definition

//-------------------------------------------------------------------
//  Programmstart
//-------------------------------------------------------------------
$objBackupDB = new AutoBackupDB( );
$objBackupDB->run( );

//-------------------------------------------------------------------
?>