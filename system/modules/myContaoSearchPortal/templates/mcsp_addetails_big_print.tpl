<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
       <h1><?php echo $this->title; ?></h1>
       <p class="inforow">
	   <span>Anzeigen-Nr.: <?php echo $this->adid; ?></span><br />
	   <span>Preis: <?php echo $this->price; ?></span>
       </p>       
       <?php if($this->isPicture):?>
	   <div class="imgbox">
	         <?php 
	         $c=0;
	         foreach($this->bicpics as $k => $bicpic): 
	         $c++;
	         if($c > 3) continue;
	         ?>
		    <img src="<?php echo $bicpic; ?>" alt="" width="<?php echo $this->bicpicWidth; ?>" height="<?php echo $this->bicpicHeight; ?>" />
	         <?php endforeach; ?>  
	   </div><!--.imgbox-->
       <?php endif; ?>                     
	<h3>Beschreibung</h3><?php echo $this->text; ?><?php if($this->isLink):?><p><strong>Website:</strong>&nbsp;<?php echo $this->linkUrl; ?></p><?php endif; ?>  	
</div>



		       
