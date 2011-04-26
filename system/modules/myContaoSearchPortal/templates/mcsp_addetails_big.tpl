<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
       <h1><?php echo $this->title; ?></h1>
       <div class="inforow">
	   <div class="article_number">Anzeigen-Nr.: <?php echo $this->adid; ?></div>
	   <div class="price">Preis: <span><?php echo $this->price; ?></span></div>

       </div>
       
       <?php if($this->isPicture):?>
	   <div class="imgbox">
	      <div id="bigpic" style="width:<?php echo $this->bicpicWidth; ?>px; height:<?php echo $this->bicpicHeight; ?>px;">
	         <ul>
	         <?php foreach($this->bicpics as $k => $bicpic): ?>
	           <li><a href="<?php echo  $this->layer_imgsrc[$k]; ?>" class="img normal" rel="lightbox[<?php echo $this->moduleId; ?>]"><img src="<?php echo $bicpic; ?>" alt="" width="<?php echo $this->bicpicWidth; ?>" height="<?php echo $this->bicpicHeight; ?>" /></a></li>
	         <?php endforeach; ?>  
	         </ul>
	      </div>
	      
	      <?php foreach($this->thumbpics as $thumb): ?>
		  <a href="" class="img small"><img src="<?php echo $thumb; ?>" alt="" width="<?php echo $this->thumbpicsWidth; ?>" height="<?php echo $this->thumbpicsHeight; ?>" /></a>		          
	      <?php endforeach; ?>
	   </div><!--.imgbox-->
       <?php endif; ?>
       
       <div class="description">
	   <h3>Beschreibung</h3>
	    <?php echo $this->text; ?>
	</div><!--.description--> 
	  
	<a href="<?php echo $this->backlink; ?>" class="backlink">Zurück zur Liste</a>
</div>
<!-- indexer::continue -->



		       
