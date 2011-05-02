<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
    <<?php echo $this->hl; ?>><?php printf($this->headline,$this->group);?></<?php echo $this->hl; ?>>
    <p class="address"><?php echo $this->address;?><br/><?php echo $this->plz;?> <?php echo $this->ort;?></p>
    <?php if($this->isPhone): ?><p class="phonenumber">Telefon: <?php echo $this->number; ?></p><?php endif;?>
    <div class="questbutton">Nachricht schreiben</div>
    <?php if(strlen($this->sendFormSuccessText)): 
     echo $this->sendFormSuccessText;
     else: ?>
    <form action="<?php echo $this->action; ?>" id="ad_contact_form" method="post" class="contactform">
	<input type="hidden" name="FORM_SUBMIT" value="<?php echo $this->form_submit; ?>" />
	<?php if($this->inputEmail->hasErrors()): ?><p class="error"><?php echo $this->inputEmail->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputEmail->generateLabel();?>
	<?php echo $this->inputEmail->generate();?>
	<?php if($this->inputNotice->hasErrors()): ?><p class="error"><?php echo $this->inputNotice->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputNotice->generateLabel();?>
	<?php echo $this->inputNotice->generate();?> 
	<?php if($this->inputCaptcha->hasErrors()): ?><p class="error"><?php echo $this->inputCaptcha->getErrorAsString();?></p><?php endif; ?>
	<?php echo $this->inputCaptcha->generateQuestion();?>
	<?php echo $this->inputCaptcha->generate();?><br />
	<input  type="submit" name="submit" class="submit" value="Nachricht senden"/>			    			    
    </form> 
    <?php endif; ?>
</div>
<!-- indexer::continue -->




		       
