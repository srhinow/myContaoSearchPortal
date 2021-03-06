<?php
/**
 * TL_ROOT/system/modules/auto_completer/languages/pl/tl_settings.php 
 * 
 * Contao extension: auto_completer 1.7.0 stable 
 * Polnisch translation file 
 * 
 * Copyright : 2009 by Leo Unglaub && Christian Schiffler 
 * License   : GNU Lesser Public License (LGPL) 
 * Author    : Leo Unglaub (leo.unglaub), http://www.leo-unglaub.net 
 * Translator: Tomasz Adamski (djtms), www.miastopiaseczno.pl 
 * 
 * This file was created automatically be the Contao extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish 
 * permanent text corrections which are update-safe. 
 */
 
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_legend'] = "Auto Completer - Ustawienia globalne";
$GLOBALS['TL_LANG']['tl_settings']['use_auto_completer']['0'] = "Włącz Auto-Completer";
$GLOBALS['TL_LANG']['tl_settings']['use_auto_completer']['1'] = "Włącz Auto-Completer w tym module (sugestie słów kluczowych znanych z Google lub Wikipedii";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_expert_settings']['0'] = "opcje experta";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_expert_settings']['1'] = "Show the expert options. This options are only for advanced users.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_min_length']['0'] = "min długości";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_min_length']['1'] = "(integer) the minimum length of the string the user must enter before the suggestions are displayed; defaults to 1";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_max_choises']['0'] = "max wyborów";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_max_choises']['1'] = "(integer) the maximum number of suggestion items to display; defaults to 10";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_global_ignore_words']['0'] = "global ignore list";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_global_ignore_words']['1'] = "You can insert a list of comma separated values to exclude them from all auto completer instances on your website. Please remember that a hook also use this list.";
$GLOBALS['TL_LANG']['tl_settings']['auto_complete_template']['0'] = "Template";
$GLOBALS['TL_LANG']['tl_settings']['auto_complete_template']['1'] = "Please select the template that shall be used for displaying the box.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_mark_query']['0'] = "mark query";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_mark_query']['1'] = "(boolean) whether or not to wrap the portion of each suggestion that matches the user entry with a span tag (which gets the css class autocompleter-queried); defaults to true";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_width']['0'] = "width";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_width']['1'] = "(mixed) either the string 'inherit', which specifies that the suggestions dropdown should be as wide as the input, or an integer for the desired width in pixels; defaults to 'inherit'";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_inject_choice']['0'] = "inject choice";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_inject_choice']['1'] = "(function) the function that creates each suggestion item in the suggestions dropdown. The default is a function that injects an li element into the suggestion dropdown. This method is passed a token, which is one of the suggested values (which may or may not be a string, depending on what your server returns). Note that the element created by this function must have an attribute called 'inputValue' that returns the value to be inserted into the input when a suggestion item is selected.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_custom_choices']['0'] = "custom_choices";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_custom_choices']['1'] = "(element) an element container for the suggestion items; by default a ul is created on the fly, but you may specify a different container into which suggestion items will be injected.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_empty_choises']['0'] = "empty_choises";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_visible_choises']['0'] = "visible_choises";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_class_name']['0'] = "nazwa klasy";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_class_name']['1'] = "(String) nazwa klasy stosuje się do pojemnika propozycja; domyślnie \"autocompleter do wyborów\"";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_z_index']['0'] = "z-index";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_z_index']['1'] = "(Integer) z-index z rozwijanej listy sugestii, domyślnie 42";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_delay']['0'] = "opóźnienie";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_delay']['1'] = "(integer) the period (in milliseconds) to wait befor the suggestion dropdown is displayed or its items updated after typing in the input; defaults to 400.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_observer_options']['0'] = "opcje obserwatora";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_observer_options']['1'] = "(object) options passed on to the Observer class";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_fx_options']['0'] = "opcje fx";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_fx_options']['1'] = "(object or null) options passed to the effect (Fx.Tween) instance that fades the suggestions dropdown in/out; specifying null will mean no effect is used; defaults to {} (empty object)";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_submit']['0'] = "automatycznie prześlij";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_submit']['1'] = "(boolean) whether to submit the form when the user chooses a suggestion item by hitting enter; defaults to false";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow']['0'] = "overflow";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow']['1'] = "(boolean) If set to true, the maxChoices option is ignored and all the available suggestion items are displayed; defaults to false.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow_margin']['0'] = "margines overflow";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_overflow_margin']['1'] = "(integer) if overflow is true and the user moves their selection (using the cursor keys) to an item that is outside the viewable list, this option specifies how far to jump down the suggestions dropdown to show more suggestion items; defaults to 25";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_first']['0'] = "Wybierz pierwszy";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_first']['1'] = "(boolean) whether to automatically select the first suggestion item even if it doesn't completely match the user entry. For instance: if the user types \"aj\" and the first suggestion is \"ajax\", a true setting for this option would select that first entry even though it doesn't completely match the user's entry; defaults to false";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter']['0'] = "filtr";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter']['1'] = "(function) if defined it will replace the default filter that is applied to the values returned as suggestion items. By default this method constructs a regular expression based on the following filterCase and filterSubset options.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_case']['0'] = "filtr przypadku";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_case']['1'] = "(boolean) if filter is not defined (and therefore the filter used is the default one) this setting will, if true, filter results using a case sensitive regex; defaults to false.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_subset']['0'] = "filtr podzbioru";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_filter_subset']['1'] = "(boolean) whether to hide the suggestion dropdown only if the user selects a suggestion item or enters a value that is an exact match from the suggestion items; defaults to false.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_force_select']['0'] = "Wybór wymuszony";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_force_select']['1'] = "(boolean) whether to hide the suggestion dropdown only if the user selects a suggestion item or enters a value that is an exact match from the suggestion items; defaults to false.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_mode']['0'] = "tryb wyboru";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_select_mode']['1'] = "więcej informacji na http://www.clientcide.com/docs/3rdParty/Autocompleter";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_choices_match']['0'] = "Wybór sygestii";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_choices_match']['1'] = "(string) if defined, this string will be used to select for the choice element objects; defaults to null, which does not apply a filter.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_multiple']['0'] = "Wielokrotny";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_multiple']['1'] = "(boolean) whether to split the user entered text into multiple values; defaults to false; the following two options affect the behavior of the split.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator']['0'] = "Separator";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator']['1'] = "(string) if multiple is true, this is the delemiter that will be used to seperate values; defaults to ', ' (comma space)";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator_split']['0'] = "połącz Separatory";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_separator_split']['1'] = "(RegExp) if multiple is true, this regular expression will split the value into multiple values";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_trim']['0'] = "Automatyczy wybór";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_auto_trim']['1'] = "(boolean) whether to remove leading and trailing spaces from the user entered text when the input loses or gains focus; defaults to true; (if multiple is true, empty values are also removed; i.e. \"blah, , foo , bar\" is cleaned up to \"blah, foo, bar\")";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_allow_dupes']['0'] = "Zezwalaj na duplikaty";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_allow_dupes']['1'] = "(boolean) whether to allow duplicate suggestion items; defaults to false.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_cache']['0'] = "cache";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_cache']['1'] = "(boolean) do not recompute (or re-fetch) suggestions for a value that was previously typed; defaults to true.";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_relative']['0'] = "pokrewny";
$GLOBALS['TL_LANG']['tl_settings']['auto_completer_relative']['1'] = "(Logiczna) Jeśli aktywny, sugestie wprowadzone bezpośrednio po wpisaniu zostaną automatycznie dodane. Pozwala to dominujące wejście do poruszamy się i rozwijanej sugestie przesuwa się z nią; domyślnie false.";
 
?>
