<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
    <strong><?php printf($this->headline,$this->group);?></strong><p class="address"><?php echo $this->address;?><br/><?php echo $this->plz;?> <?php echo $this->ort;?></p><?php if($this->isPhone): ?><p class="phonenumber">Telefon: <?php echo $this->number; ?></p><?php endif;?>
</div>
<!-- indexer::continue -->




		       
