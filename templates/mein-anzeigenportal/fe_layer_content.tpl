<?php echo $this->doctype; ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<base href="<?php echo $this->base; ?>"></base>
<title><?php echo $this->pageTitle; ?> - <?php echo $this->mainTitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->charset; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="description" content="<?php echo $this->description; ?>" />
<meta name="keywords" content="<?php echo $this->keywords; ?>" />
<?php echo $this->robots; ?>
<?php echo $this->framework; ?>
<?php echo $this->stylesheets; ?>
<?php echo $this->mooScripts; ?>
<?php echo $this->head; ?>
</head>
<body id="top"<?php if ($this->class): ?> class="<?php echo $this->class; ?>"<?php endif; if ($this->onload): ?> onload="<?php echo $this->onload; ?>"<?php endif; ?>>
   <div id="wrapper">	   	
	  <?php echo $this->main; ?>		                   
   </div><!--#wrapper-->
</body>
</html>
