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
 * @copyright  Leo Feyer 2005-2009
 * @author     Leo Feyer <leo@typolight.org>
 * @package    Language
 * @license    LGPL
 * @filesource
 *
 * @copyright  Sven Rhinow 2010
 * @author     Sven Rhinow <sven@sr-tag.de>
 * @package    Language
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['cl_template']         = array('Layer-Template', 'dieses Template ist der äußere Rand vom Layer und ist für die Funktionstüchtigkeit verantwortich');
$GLOBALS['TL_LANG']['tl_module']['cl_css_file']         = array('CSS-Datei', 'Falls Sie eine seperate CSS-Datei benötigen um nur speziell die Auszeichnung für diesen Layer zu kontrollieren.');
$GLOBALS['TL_LANG']['tl_module']['cl_no_param']         = array('keine Parameter notwendig', 'wenn es keinen Parameter braucht um den Layer aufzurufen');
$GLOBALS['TL_LANG']['tl_module']['cl_substr']         = array('GET-Parameter', 'wenn genau dieser Parameter als GET-Paramter als Key übergeben wurde, wird der Layer angezeigt');
$GLOBALS['TL_LANG']['tl_module']['cl_content']         = array('Layer-Inhalt', 'geben Sie hier den Layer-Inhalt ein. Es ist HTML erlaubt. Sie können aber auch Include-Elemente wie z.B. {{insert_content::23}} eingeben. Weitere wären z.B. {{insert_article::ID}} oder {{insert_module::ID}}.');
$GLOBALS['TL_LANG']['tl_module']['cl_layer_width']         = array('Layer-Breite', '');
$GLOBALS['TL_LANG']['tl_module']['cl_layer_height']         = array('Layer-Höhe', '');
$GLOBALS['TL_LANG']['tl_module']['cl_set_cookie']         = array('ein Cookie setzen', 'um die mehrmalige Anzeige per Cookie zu beschränken');
$GLOBALS['TL_LANG']['tl_module']['cl_cookie_name']         = array('Cookie-Name', 'wenn es leer bleibt wird ein Name generiert.');
$GLOBALS['TL_LANG']['tl_module']['cl_cookie_dauer']         = array('Cookie-Dauer', 'in Millisekunden Standart 3600 = 1 Stunde.');

?>