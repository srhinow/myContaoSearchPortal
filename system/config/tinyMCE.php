<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 * @copyright  Leo Feyer 2005-2011
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Config
 * @license    LGPL
 * @filesource
 */


/**
 * This is the tinyMCE (rich text editor) configuration file. Please visit
 * http://tinymce.moxiecode.com for more information.
 */
if ($GLOBALS['TL_CONFIG']['useRTE']): ?>
<script type="text/javascript" src="<?php echo $this->base; ?>plugins/tinyMCE/tiny_mce_gzip.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
tinyMCE_GZ.init({
  plugins : "advimage,autosave,directionality,emotions,inlinepopups,paste,save,searchreplace,spellchecker,style,tabfocus,table,template,typolinks,xhtmlxtras",
  themes : "advanced",
  languages : "<?php echo $this->language; ?>",
  disk_cache : false,
  debug : false
});
//--><!]]>
</script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
tinyMCE.init({
  mode : "exact",
  height : "300",
  language : "<?php echo $this->language; ?>",
  elements : "<?php echo $this->rteFields; ?>",
<?php if ($this->brNewLine): ?>
  forced_root_block : false,
  force_p_newlines : false,
  force_br_newlines : true,
<?php endif; ?>
  remove_linebreaks : false,
  force_hex_style_colors : true,
  fix_list_elements : true,
  fix_table_elements : true,
  theme_advanced_font_sizes : "9px,10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px,21px,22px,23px,24px",
  doctype : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
  document_base_url : "<?php echo $this->base; ?>",
  entities : "160,nbsp,60,lt,62,gt,173,shy",
  cleanup_on_startup : true,
  save_enablewhendirty : true,
  save_on_tinymce_forms : true,
  save_callback : "TinyCallback.cleanXHTML",
  init_instance_callback : "TinyCallback.getScrollOffset",
  advimage_update_dimensions_onchange : false,
  external_image_list_url : "<?php echo TL_PATH; ?>/plugins/tinyMCE/plugins/typolinks/typoimages.php",
  template_external_list_url : "<?php echo TL_PATH; ?>/plugins/tinyMCE/plugins/typolinks/typotemplates.php",
  plugins : "advimage,autosave,directionality,emotions,inlinepopups,paste,save,searchreplace,spellchecker,style,tabfocus,table,template,typolinks,xhtmlxtras",
  spellchecker_languages : "<?php echo $this->getSpellcheckerString(); ?>",
  content_css : "<?php echo TL_PATH; ?>/system/themes/tinymce.css,<?php echo TL_PATH .'/'. $this->uploadPath; ?>/tinymce.css",
  event_elements : "a,div,h1,h2,h3,h4,h5,h6,img,p,span",
  extended_valid_elements : "q[cite|class|title]",
  tabfocus_elements : ":prev,:next",
  theme : "advanced",
  theme_advanced_resizing : true,
  theme_advanced_resize_horizontal : false,
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_source_editor_width : "700",
  theme_advanced_blockformats : "div,p,address,pre,h1,h2,h3,h4,h5,h6",
  theme_advanced_buttons1 : "newdocument,save,separator,spellchecker,separator,anchor,separator,typolinks,unlink,separator,image,typobox,separator,sub,sup,separator,abbr,acronym,separator,styleprops,attribs,separator,search,replace,separator,undo,redo,separator,removeformat,cleanup,separator,code",
  theme_advanced_buttons2 : "formatselect,fontsizeselect,styleselect,separator,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,indent,outdent,separator,blockquote,separator,forecolor,backcolor",
  theme_advanced_buttons3 : "tablecontrols,separator,template,separator,charmap,emotions,separator,help"
});
//--><!]]>
</script>
<?php endif; ?>
