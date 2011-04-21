<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>
<<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>>
<?php endif; ?>
<form action="<?php echo $this->action; ?>" method="get">
<div class="formbody"><?php if ($this->id): ?> 
<input type="hidden" value="<?php echo $this->id; ?>" /><?php endif; ?> 
<input type="text" name="keywords" id="<?php echo $this->ac_scriptid; ?>" class="ac_keywords text" value="" />
<input type="submit" class="submit" value="<?php echo $this->search; ?>" />
</div>
</form>
<?php if ($this->header): ?>
<p class="header"><?php echo $this->header; ?> (<?php echo $this->duration; ?>)</p>
<?php endif; ?>
<?php echo $this->results . $this->pagination; ?>
</div>
<!-- indexer::continue -->