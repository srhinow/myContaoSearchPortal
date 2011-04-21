<?php

//-------------------------------------------------------------------
// MakeWsTemplateRun.php	WS-Template erstellen
//
// Copyright (c) 2007-2010 by Softleister
//
// Ergänzung am 30.9.2009 durch Softleister:
// ------------------------------------------
// Zielverzeichnis für WS-Templates einstellbar in localconfig.php (default: 'templates')
// $GLOBALS['BACKUPDB']['WsTemplatePath'] = 'tl_files/myTemplateBackups';
//-------------------------------------------------------------------
//  Systeminitialisierung
//-------------------------------------------------------------------
define('TL_MODE', 'BE');
require('../../initialize.php');

//-------------------------------------------------------------------
//  Backend um die WsTemplate-Funktionen erweitern
//-------------------------------------------------------------------
class BackupWsTemplate extends Backend  // Datenbank ist bereits geöffnet
{
  //-------------------------
  //  Modulversion
  //-------------------------
  const Version = '1.2.0';
 
  //-------------------------
  //  Variablen
  //-------------------------
  protected $User = '';
  protected $Exclude = Array (                 // Diese Datenbank-Tabellen gehören
                         "tl_cache",           // nicht in ein WS-Template
                         "tl_log",
                         "tl_search",
                         "tl_search_index",
                         "tl_session",
                         "tl_undo",
                         "tl_version"
                       );

  protected $extcludeExt = Array (            // Module aus der Standard-Installation < 2.7
                             "backend", "calendar", "comments", "development", "dfGallery",
                             "frontend", "listing", "news", "newsletter", "pun_bridge",
                             "registration", "rss_reader", "tpl_editor", "BackupDB", "faq",
                             "rep_base", "rep_client", "memberlist"
                           );

  protected $extcludeExt27 = Array (            // Module aus der Standard-Installation >= 2.7
                             "backend", "calendar", "comments", "dfGallery", "faq", "frontend", 
                             "glossary", "listing", "memberlist", "news", "newsletter", 
                             "registration", "rep_base", "rep_client", "rss_reader", "tpl_editor", 
                             "BackupDB"
                           );

  protected $extcludeExt28 = Array (            // Module aus der Standard-Installation >= 2.8 (auch 2.9)
                             "backend", "calendar", "comments", "faq", "frontend", "listing", 
                             "news", "newsletter", "registration", "rep_base", "rep_client", 
                             "rss_reader", "tpl_editor", "BackupDB"
                           );

  //-------------------------
  //  Constructor
  //-------------------------
  public function __construct( )
  {
    $this->import('BackendUser', 'User');	// User importieren
    parent::__construct(); 			// Construktor Backend ausführen
    $this->User->authenticate(); 		// Authentifizierung überprüfen
    $this->loadLanguageFile('default');		// Sprachenfiles laden
    $this->loadLanguageFile('modules');
    $this->loadLanguageFile('tl_BackupDB'); 
  }

  //------------------------------------------------
  //  Dateifähiger Filename
  //------------------------------------------------
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
        
  //------------------------------------------------
  //  Erzeugt die Strukturdefinitionen
  //------------------------------------------------
  private function getFromDB()
  {
    $tables = $this->Database->listTables( );
    if( !count($tables) ) return array( );		// keine Tabellen, leeres Array zurückgeben

    $return = array ();					// Ergebnisvariable vorbereiten

    foreach( $tables as $table ) {
      $fields = $this->Database->listFields( $table );	// Liste der Felder lesen
               
      $fstr = "";
      foreach( $fields as $field ) {
        $fstr .= '`'.$field['name'].'`, ';
	$return[$table][$name] = $fstr;
      }
    }
    return $return;
  }

  //------------------------------------------------
  //  Erzeugt INSERT-Zeilen mit den Datenbankdaten
  //------------------------------------------------
  protected function get_table_content( $table, $fieldlist )
  {
    $objData = $this->Database->prepare( "SELECT * FROM $table" )->execute( );
    $fields = $this->Database->listFields( $table );		// Liste der Felder lesen

    $result = "";
    while( $row = $objData->fetchRow() ) {
      $insert_data = "INSERT INTO `$table` ($fieldlist) VALUES (";
      $i = 0;							// Fields[0]['type']
      foreach( $row as $field_data ) {
	if( !isset( $field_data ) )
	  $insert_data .= " NULL,";
	else if( $field_data != "" ) {
	  switch( strtolower($fields[$i]['type']) ) {
	    case 'blob':
	    case 'tinyblob':
	    case 'mediumblob':
	    case 'longblob':	$insert_data .= " 0x";		// Auftakt für HEX-Darstellung
	                        $insert_data .= bin2hex($field_data);
	    			$insert_data .= ",";		// Abschuß
	    			break;
	    
	    case 'smallint':
	    case 'int':		$insert_data .= " $field_data,";
	    			break;
	    
	    case 'text':
	    case 'mediumtext':	if( strpos( $field_data, "'" ) != false ) {  // ist im Text ein Hochkomma vorhanden, wird der Text in HEX-Darstellung gesichert
	    			  $insert_data .= " 0x" . bin2hex($field_data) . ",";
	    			  break;
	                        }
	                        // else: weiter mit default

	        default:	$insert_data .= " '".str_replace( array("\\", "'", "\r", "\n"), array("\\\\", "\\'", "\\r", "\\n"), $field_data )."',";
				break;
	  }
	}
	else
	  $insert_data .= " '',";
	$i++;						// Next Field
      }
      $insert_data = trim( $insert_data, ',' );
      $insert_data .= ")";
      $result .= "$insert_data;\r\n";			// Zeile ausgeben
    }
    if( $result != "" ) return "\r\n--\r\n-- Table '$table'\r\n--\r\n\r\n".$result;
  }
		
  //-------------------------
  //  Backup ausführen
  //-------------------------
  public function run( )
  {
    @set_time_limit( 600 );
    echo "<html><head>\n"
        ."<title>".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_txt1']."</title>\n"
        ."<meta http-equiv=\"cache-control\" content=\"no-cache\">\n"
        ."<meta http-equiv=\"pragma\" content=\"no-cache\">\n"
        ."</head>\n"
        ."<body style=\"font-family:Arial,Helvetica,sans-serif; font-size:12px;\">\n"
        ."".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_txt2']."<br />\n";

    $headertext  = "#================================================================================\r\n";
    $headertext .= "# Website-Template    : ".$this->getWsName( ).".sql\r\n";
    $headertext .= "#================================================================================\r\n";
    $headertext .= "# Contao Website   : ".$GLOBALS['TL_CONFIG']['websiteTitle']."\r\n";
    $headertext .= "# Contao Database  : ".$GLOBALS['TL_CONFIG']['dbDatabase']."\r\n";
    $headertext .= "# Contao Version   : ".VERSION." Build ".BUILD."\r\n";
    $headertext .= "#\r\n";
    $headertext .= "# Saved by User    : ".$this->User->username." (".$this->User->name.")\r\n";
    $headertext .= "# Time stamp       : ".date( "Y-m-d" )." at ".date( "H:i:s" )."\r\n";
    $headertext .= "#\r\n";
    $headertext .= "# Contao Extension : BackupDB, Version ".self::Version."\r\n";
    $headertext .= "# Copyright        : Softleister (www.softleister.de)\r\n";
    $headertext .= "# Licence          : LGPL\r\n";
    $headertext .= "#\r\n";
    $headertext .= "# Visit Contao project page http://www.contao.org for more information\r\n";
    $headertext .= "#================================================================================\r\n";

    //--- Zielverzeichnis für Website-Templates ---  einstellbar 30.9.2009 Softleister
    $zielVerz = 'templates';
    if( isset( $GLOBALS['BACKUPDB']['WsTemplatePath'] ) && is_dir(TL_ROOT.'/'.trim($GLOBALS['BACKUPDB']['WsTemplatePath'], '/')) )
      $zielVerz = trim($GLOBALS['BACKUPDB']['WsTemplatePath'], '/');

    // Import Files-Library für FTP-Support, wenn aktiviert
    $this->import( 'Files', 'Files' );
    $tempdir = '/system/tmp/';   	    // geändert in 1.0.1 am 15.12.2008 SL

    $file1 = $this->getWsName( ).".sql";    // Datenbank-Datei
    $file2 = $this->getWsName( ).".txt";    // Info-Datei

    $datei = new File( $tempdir.$file1 );
    $datei->write( $headertext );

    $sqlarray = $this->getFromDB( );
    
    if( count($sqlarray) == 0 ) $datei->write( "\r\nNo tables found in database." );
    else {
      foreach( array_keys($sqlarray) as $table ) {
        if( substr( $table, 0, 3 ) != "tl_" ) continue;             // Nur tl_-Datentabellen gehören dazu
        if( in_array( $table, $this->Exclude ) ) continue;          // Exclude-Tabellen überspringen

	$fields = implode(" ", $sqlarray[$table]);
	$datei->write( $this->get_table_content( $table, substr( $fields, 0, -2 ) ) );	// Dateninhalte in Datei schreiben
      }
    }
    $datei->write( "\r\n# --- End of Backup ---\r\n" );     // Endekennung
    $datei->close();

    $datei = new File( $tempdir.$file2 );     // Textdatei öffnen
    $datei->write( $headertext."\r\n" );

    //--- Installierte Module unter /system/modules auflisten ---
    $datei->write( "#------------------------------------------\r\n" );
    $datei->write( "# ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_module']."\r\n" );
    $datei->write( "#------------------------------------------\r\n" );
    $modullist = "";
    $handle = opendir( ".." );
    while( $file = readdir( $handle ) ) {
      if( substr( $file, 0, 1 ) == "." ) continue;             // . und .. ausblenden
      if( VERSION < 2.7 ) {
        if( in_array( $file, $this->extcludeExt ) ) continue;    // Standard-Module überspringen
      }
      else if( VERSION < 2.8 ) {
        if( in_array( $file, $this->extcludeExt27 ) ) continue;
      }
      else {
        if( in_array( $file, $this->extcludeExt28 ) ) continue;
      }
      $modullist .= "  - $file\r\n";
    }
    closedir( $handle );
    if( $modullist != "" ) $datei->write( $modullist."\r\n" );
    else                   $datei->write( "  == keine ==\r\n" );
    
    //--- Installationsanleitung ---
    $datei->write( "#------------------------------------------\r\n" );
    $datei->write( "# ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_inst']."\r\n" );
    $datei->write( "#------------------------------------------\r\n\r\n" );

    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl10']."\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl11']."\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl12']."\r\n\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl20']."\r\n\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl30']."\r\n\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl40']."\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl41']."\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl42']."\r\n\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl50']."\r\n" );
    $datei->write( " ".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_anl51']."\r\n\r\n" );
    
    $datei->close();

    if( $GLOBALS['TL_CONFIG']['useFTP'] ) {
      $this->Files->rename( substr($tempdir,1).$file1, $zielVerz.'/'.$file1 );
      $this->Files->rename( substr($tempdir,1).$file2, $zielVerz.'/'.$file2 );
    }
    else {
      rename( TL_ROOT.$tempdir.$file1, TL_ROOT.'/'.$zielVerz.'/'.$file1 );
      rename( TL_ROOT.$tempdir.$file2, TL_ROOT.'/'.$zielVerz.'/'.$file2 );
    }

    echo " <br />".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_txt3']."<br />\n <br />\n";
    echo "<b>".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_files']."</b><br />\n";
    echo "/".$zielVerz."/$file1<br />\n";
    echo "/".$zielVerz."/$file2<br />\n";
    echo " <br />\n";
    echo "".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_txt5']."<br />\n";
    echo " <br />\n";
    echo "<a href=\"javascript:window.close()\">".$GLOBALS['TL_LANG']['MSC']['tl_backupdb']['ws_template_txt4']."</a><br />\n";
    echo "</body></html>\n";
  }	// end function definition
  
  //------------------------------------------------
}	// End class definition

//-------------------------------------------------------------------
//  Programmstart
//-------------------------------------------------------------------
$objWsTemplate = new BackupWsTemplate( );
$objWsTemplate->run( );

//-------------------------------------------------------------------

?>