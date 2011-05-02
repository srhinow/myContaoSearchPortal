<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
    <<?php echo $this->hl; ?>><?php printf($this->headline,$this->group);?></<?php echo $this->hl; ?>>
    <?php if(strlen($this->sendFormSuccessText)): 
     echo '<p>'.$this->sendFormSuccessText.'</p>';
     else: ?>
    <form action="<?php echo $this->action; ?>" id="ad_share_form" method="post" class="form">
	<input type="hidden" name="FORM_SUBMIT" value="<?php echo $this->form_submit; ?>" />
	
	<?php echo $this->inputJustfication->generateLabel();?>
	<?php if($this->inputJustfication->hasErrors()): ?><p class="error"><?php echo $this->inputJustfication->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputJustfication->generate();?>
		
	<?php echo $this->inputNotice->generateLabel();?>
	<?php if($this->inputNotice->hasErrors()): ?><p class="error"><?php echo $this->inputNotice->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputNotice->generate();?> 
	
	<?php echo $this->inputCaptcha->generateLabel();?>
	<?php if($this->inputCaptcha->hasErrors()): ?><p class="error"><?php echo $this->inputCaptcha->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputCaptcha->generateQuestion();?>
	<?php echo $this->inputCaptcha->generate();?><br />
	<input  type="submit" name="submit" class="submit" value="Anzeige melden"/>			    			    
    </form> 
    <?php endif; ?>
</div>
<!-- indexer::continue -->




		       
