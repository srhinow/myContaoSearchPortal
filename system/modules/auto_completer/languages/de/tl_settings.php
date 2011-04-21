<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
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
 * @copyright  LU-Hosting 2010, CyberSpectrum 2010
 * @author     Leo Unglaub <leo@leo-unglaub.net>, Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    auto_completer 
 * @license    GNU/GPL 
 * @filesource
 */


// Label for the Auto Completer
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_legend'] = 'Auto Completer - Globale Konfiguration';

// Label for the two checkboxes
$GLOBALS['TL_LANG']['tl_settings']['use_auto_completer'] 				= array('Auto-Completer aktivieren', 'Aktiviert die Vervollständigung der Suchbegriffe wie bei Google oder Wikipedia');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_expert_settings'] 	= array('Expertenoptionen', 'Zeigt Expertenoptionen für die Konfiguration des Auto Completers. Alle Werte sind jedoch mit einem sinnvollen Default-Wert belegt. Achtung: Veränderungen an diesen Optionen können den Auto Completer negativ beeinflussen.');

// Beschriftung der Felder unterhalb von "use_auto_completer"
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_min_length'] 		= array('Mindestanzahl der Buchstaben', 'Bitte geben Sie hier die Mindestanzahl von Buchstaben an die benötigt werden bevor dem Benutzer Suchvorschläge angezeigt werden.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_max_choises'] 		= array('Maximale Anzahl an Suchergebnissen', 'Hier können Sie die maximale Anzahl an Suchvorschlägen definieren. Wenn Sie dieses Feld leer lassen werden 10 Vorschläge angezeigt.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_global_ignore_words'] = array('Globale Ignore Wörter', 'Hier können Sie Wörter eintragen die bei JEDER Auto-Completer verwendung nicht angezeigt werden sollen. So können Sie eine globale Blackliste erstellen und diese dann in den einzelnen modulen erweitern und anpassen. Achtung: Diese Ignorier-Liste gilt auch bei Hooks.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_language'] 		= array('Sprache der Treffer', 'Bitte wählen Sie eine Sprache aus in der die Suchbegriffe angezeigt werden sollen. Es sind nur Sprachen verfügbar die auch innerhalb der Seite definiert wurden.');
$GLOBALS['TL_LANG']['tl_settings']['auto_complete_template'] 			= array('Template', 'Wählen Sie bitte ein Template aus, welches zur Anzeige der Suchbox verwendet werden soll.');

//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_mark_query'] 	= array('mark query', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_width'] 			= array('width', '(mixed) Hier können Sie die Breite der Drop-Down box definieren. Geben Sie entweder die Breite in Pixeln an, oder nehmen Sie den Default-Wert \'inherit\' ein.');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_inject_choice'] 	= array('inject choice', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_custom_choices'] = array('custom_choices', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_empty_choises'] 	= array('empty_choises', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_visible_choises'] = array('visible_choises', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_class_name'] 		= array('class name', '(string) Hier können Sie den class-Wert der Drop-Down Box definieren. Der Default Wert ist \'autocompleter-choices\'');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_z_index'] 			= array('z-index', '(integer) Hier können Sie den z-index der Drop-Down Box definieren. Der Standardwert ist 42');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_delay'] 			= array('delay', '(integer) Die Zeitdauer in Milisekunden bevor ein Ergebnis angezeigt wird oder die Suchergebnisse aktuallisiert werden. Der Standardwert ist 400ms .');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_observer_options'] = array('observer options', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_fx_options'] 	= array('fx options', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_submit'] 		= array('auto submit', '(boolean) Wählen Sie hier Ja aus wenn Sie möchten, dass ein Suchergebnis nach dem Auswählen eines Suchwortes per Enter-Taste automatisch abgeschickt wird. Der Standardwert ist Nein.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow'] 		= array('overflow', '(boolean) Wählen Sie hier Ja aus wenn Sie die Option maxChoices umgehen möchten und sicherstellen wollen, dass ALLE Vorschläge angezeigt werden. Der Standardwert ist Nein.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow_margin'] 	= array('overflow margin', '(integer) Wenn Sie die Option overflow auf ja gesetzt haben, dann können Sie hier die Sprungbreite angeben die genutzt werden soll um Items darzustellen die auserhalb der Listenwerte liegen. (per Pfeiltasten) Der Standardwert ist hierbei 25.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_first'] 	= array('select first', '(boolean) Aktivieren Sie diese Option wenn Sie möchten, dass das erste Suchergebnis automatisch ausgewählt wird. Beispiel: Wenn Sie in die Suchmaske "aj" eintippen wird als erster Treffer das Wort "ajax" vorgeschlagen. Wenn Sie diese option aktivieren, dann wird "ajax" automatisch ausgewählt auch wenn es noch nicht 100% mit dem Treffer übereinstimmt. Der Standardwert ist Nein.');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter'] 		= array('filter', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_case']	= array('filter case', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_subset']	= array('filter subset', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_force_select'] 	= array('Force select', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_mode'] 	= array('Select mode', '');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_choices_match'] 	= array('Choices Match', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_multiple'] 		= array('Multiple', '(boolean) Wenn Sie hier Ja auswählen, werden mehrere Suchwörter vervollständigt. Die Trennung ist über die Parameter separator und Separator split geregelt. Der Standardwert ist Nein.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator'] 		= array('Separator', '(string) Wenn Sie die Option Multiple auf Ja gestellt haben, können Sie über diese Option das Trennzeichen regeln. Der Standardwert ist ein Leerzeichen.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator_split'] 	= array('Separator split', '(RegExp) Hier können Sie ein RegExp eintragen der Multiple Suchergebnisse trennen soll. Standardmäsig ist hier kein Wert gesetzt.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_trim'] 		= array('Auto Trim', '(boolean) Wenn Sie diese Option aktivieren werden Leerzeichen am Anfang und am Ende eines Wortes entfernt. Der Standardwert ist Ja.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_allow_dupes'] 		= array('Allow dupes', '(boolean) Wenn Sie diese Option auf Ja setzen werden doppelte Suchvorschläge angezeigt. Standardmäsig ist diese Funktion nicht aktiv. <br />Technischer Hinweiß: Wird der Auto Completer mit dem normalen TYPOlight Suchindex verwendet verhindert der Abfragequery bereits, dass doppelte Ergebnisse angezeigt werden. Dies ist notwendig um eine bessere Performence zu gewährleisten. Diese Option hat nur einen Sinn wenn per Hook eine andere Datenquelle abgefragt wird.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_cache'] 			= array('cache', '(boolean) Wenn Sie diese Option auf Ja setzen wird für bereits angezeigte Wörter kein erneuter Ajax-Request gesendet. Standardmäsig ist diese Funktion aktiv.');
//$GLOBALS['TL_LANG']['tl_settings']['auto_completer_relative'] 		= array('relative', '(boolean) if true, the suggestions dropdown element is injected immediately after the input. This allows the parent of the input to move and have the suggestions dropdown move with it; defaults to false.');

?>