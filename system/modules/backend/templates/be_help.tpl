<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
<base href="<?php echo $this->base; ?>"></base>
<title><?php echo $this->title; ?> :: Contao Open Source CMS <?php echo VERSION; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->charset; ?>" />
<link rel="stylesheet" type="text/css" href="system/themes/<?php echo $this->theme; ?>/basic.css?<?php echo VERSION .'.'. BUILD; ?>" media="screen" />
<link rel="stylesheet" type="text/css" href="system/themes/<?php echo $this->theme; ?>/help.css?<?php echo VERSION .'.'. BUILD; ?>" media="screen" />
<!--[if lte IE 7]><link type="text/css" rel="stylesheet" href="system/themes/<?php echo $this->theme; ?>/iefixes.css?<?php echo VERSION .'.'. BUILD; ?>" media="screen" /><![endif]-->
<!--[if IE 8]><link type="text/css" rel="stylesheet" href="system/themes/<?php echo $this->theme; ?>/ie8fixes.css?<?php echo VERSION .'.'. BUILD; ?>" media="screen" /><![endif]-->
</head>
<body>

<div id="container">
<div id="main">

<h1><?php echo $this->helpWizard; ?></h1>

<h2><?php echo $this->headline; ?></h2>

<?php echo $this->explanation; ?>
<?php if (count($this->rows)): ?>
<table cellspacing="0" cellpadding="0" class="tl_help_table" summary="Table explains the current field">
<?php foreach ($this->rows as $row): ?>
  <tr>
<?php if ($row[0] == 'colspan'): ?>
    <td colspan="2"><?php echo $row[1]; ?></td>
<?php else: ?>
    <td class="tl_label"><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?></td>
<?php endif; ?>
  </tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

</div>
</div>

</body>
</html>