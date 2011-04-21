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
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_legend'] = 'Auto Completer - Global Configuration';

// Label for the two checkboxes
$GLOBALS['TL_LANG']['tl_settings']['use_auto_completer'] 				= array('Enable Auto-Completer', 'Enable the Auto-Completer Extension on this module (keyword suggestion as known from Google or Wikipedia');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_expert_settings'] 	= array('expert options', 'Show the expert options. This options are only for advanced users.');

// Caption for all the default config fields
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_min_length'] 		= array('min length', '(integer) the minimum length of the string the user must enter before the suggestions are displayed; defaults to 1');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_max_choises'] 		= array('max choises', '(integer) the maximum number of suggestion items to display; defaults to 10');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_global_ignore_words'] = array('global ignore list', 'You can insert a list of comma separated values to exclude them from all auto completer instances on your website. Please remember that a hook also use this list.');
$GLOBALS['TL_LANG']['tl_settings']['auto_complete_template'] 			= array('Template', 'Please select the template that shall be used for displaying the box.');

// Beschriftung der Felder unterhalb von "auto_completer_expert_settings"
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_mark_query'] 		= array('mark query', '(boolean) whether or not to wrap the portion of each suggestion that matches the user entry with a span tag (which gets the css class autocompleter-queried); defaults to true');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_width'] 			= array('width', '(mixed) either the string \'inherit\', which specifies that the suggestions dropdown should be as wide as the input, or an integer for the desired width in pixels; defaults to \'inherit\'');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_inject_choice'] 	= array('inject choice', '(function) the function that creates each suggestion item in the suggestions dropdown. The default is a function that injects an li element into the suggestion dropdown. This method is passed a token, which is one of the suggested values (which may or may not be a string, depending on what your server returns). Note that the element created by this function must have an attribute called \'inputValue\' that returns the value to be inserted into the input when a suggestion item is selected.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_custom_choices'] 	= array('custom_choices', '(element) an element container for the suggestion items; by default a ul is created on the fly, but you may specify a different container into which suggestion items will be injected.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_empty_choises'] 	= array('empty_choises', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_visible_choises'] 	= array('visible_choises', '');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_class_name'] 		= array('class name', '(string) the class name to apply to the suggestion container; defaults to \'autocompleter-choices\'');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_z_index'] 			= array('z-index', '(integer) the z-index of the suggestion dropdown; defaults to 42');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_delay'] 			= array('delay', '(integer) the period (in milliseconds) to wait befor the suggestion dropdown is displayed or its items updated after typing in the input; defaults to 400.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_observer_options'] = array('observer options', '(object) options passed on to the Observer class');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_fx_options'] 		= array('fx options', '(object or null) options passed to the effect (Fx.Tween) instance that fades the suggestions dropdown in/out; specifying null will mean no effect is used; defaults to {} (empty object)');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_submit'] 		= array('auto submit', '(boolean) whether to submit the form when the user chooses a suggestion item by hitting enter; defaults to false');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow'] 		= array('overflow', '(boolean) If set to true, the maxChoices option is ignored and all the available suggestion items are displayed; defaults to false.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow_margin'] 	= array('overflow margin', '(integer) if overflow is true and the user moves their selection (using the cursor keys) to an item that is outside the viewable list, this option specifies how far to jump down the suggestions dropdown to show more suggestion items; defaults to 25');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_first'] 	= array('select first', '(boolean) whether to automatically select the first suggestion item even if it doesn\'t completely match the user entry. For instance: if the user types "aj" and the first suggestion is "ajax", a true setting for this option would select that first entry even though it doesn\'t completely match the user\'s entry; defaults to false');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter'] 			= array('filter', '(function) if defined it will replace the default filter that is applied to the values returned as suggestion items. By default this method constructs a regular expression based on the following filterCase and filterSubset options.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_case']		= array('filter case', '(boolean) if filter is not defined (and therefore the filter used is the default one) this setting will, if true, filter results using a case sensitive regex; defaults to false.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_subset']	= array('filter subset', '(boolean) whether to hide the suggestion dropdown only if the user selects a suggestion item or enters a value that is an exact match from the suggestion items; defaults to false.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_force_select'] 	= array('Force select', '(boolean) whether to hide the suggestion dropdown only if the user selects a suggestion item or enters a value that is an exact match from the suggestion items; defaults to false.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_mode'] 		= array('Select mode', 'more infos at http://www.clientcide.com/docs/3rdParty/Autocompleter');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_choices_match'] 	= array('Choices Match', '(string) if defined, this string will be used to select for the choice element objects; defaults to null, which does not apply a filter.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_multiple'] 		= array('Multiple', '(boolean) whether to split the user entered text into multiple values; defaults to false; the following two options affect the behavior of the split.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator'] 		= array('Separator', '(string) if multiple is true, this is the delemiter that will be used to seperate values; defaults to \', \' (comma space)');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator_split'] 	= array('Separator split', '(RegExp) if multiple is true, this regular expression will split the value into multiple values');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_trim'] 		= array('Auto Trim', '(boolean) whether to remove leading and trailing spaces from the user entered text when the input loses or gains focus; defaults to true; (if multiple is true, empty values are also removed; i.e. "blah, , foo , bar" is cleaned up to "blah, foo, bar")');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_allow_dupes'] 		= array('Allow dupes', '(boolean) whether to allow duplicate suggestion items; defaults to false.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_cache'] 			= array('cache', '(boolean) do not recompute (or re-fetch) suggestions for a value that was previously typed; defaults to true.');
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_relative'] 		= array('relative', '(boolean) if true, the suggestions dropdown element is injected immediately after the input. This allows the parent of the input to move and have the suggestions dropdown move with it; defaults to false.');

?>