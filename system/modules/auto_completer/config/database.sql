-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `use_auto_completer` char(1) NOT NULL default '',
  `auto_completer_override_global` char(1) NOT NULL default '',
  `auto_completer_expert_settings` char(1) NOT NULL default '',
  `auto_completer_language` varchar(250) NOT NULL default '',
  `auto_completer_min_length` int(5) NOT NULL default '0',
  `auto_completer_mark_query` varchar(10) NOT NULL default 'true',
  `auto_completer_width` varchar(250) NOT NULL default '',
  `auto_completer_max_choises` int(5) NOT NULL default '0',
  `auto_completer_inject_choice` varchar(250) NOT NULL default '',
  `auto_completer_custom_choices` varchar(250) NOT NULL default '',
  `auto_completer_empty_choises` varchar(250) NOT NULL default '',
  `auto_completer_visible_choises` varchar(10) NOT NULL default 'true',
  `auto_completer_class_name` varchar(250) NOT NULL default '',
  `auto_completer_z_index` int(5) NOT NULL default '0',
  `auto_completer_delay` int(10) NOT NULL default '0',
  `auto_completer_observer_options` text NOT NULL,
  `auto_completer_fx_options` text NOT NULL,
  `auto_completer_auto_submit` varchar(10) NOT NULL default 'false',
  `auto_completer_overflow` varchar(10) NOT NULL default 'false',
  `auto_completer_overflow_margin` int(10) NOT NULL default '0',
  `auto_completer_select_first` varchar(10) NOT NULL default 'false',
  `auto_completer_filter` text NOT NULL,
  `auto_completer_filter_case` varchar(10) NOT NULL default 'false',
  `auto_completer_filter_subset` varchar(10) NOT NULL default 'false',
  `auto_completer_force_select` varchar(10) NOT NULL default 'false',
  `auto_completer_select_mode` varchar(10) NOT NULL default 'true',
  `auto_completer_choices_match` text NOT NULL,
  `auto_completer_multiple` varchar(10) NOT NULL default 'true',
  `auto_completer_auto_trim` varchar(10) NOT NULL default 'false',
  `auto_completer_allow_dupes` varchar(10) NOT NULL default 'false',
  `auto_completer_cache` varchar(10) NOT NULL default 'true',
  `auto_completer_relative` varchar(10) NOT NULL default 'false',
  `auto_complete_ignore_words` blob NULL,
  `auto_complete_template` varchar(64) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;