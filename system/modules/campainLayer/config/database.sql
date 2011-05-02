-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
 `cl_template` varchar(255) NOT NULL default '', 
 `cl_substr` varchar(55) NOT NULL default '', 
 `cl_css_file` varchar(255) NOT NULL default '',
 `cl_no_param` char(1) NOT NULL default '',
 `cl_content` text NULL,
 `cl_set_cookie` char(1) NOT NULL default '',
 `cl_cookie_name` varchar(55) NOT NULL default '',
 `cl_cookie_dauer` varchar(55) NOT NULL default '',
 `cl_framework` varchar(55) NOT NULL default '',
 `cl_option_layerwidth` varchar(55) NOT NULL default '',
 `cl_option_layerheight` varchar(55) NOT NULL default '',
 `cl_option_other` text NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
