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
	           <li><div class="imgitem" style="width:<?php echo $this->bicpicWidth; ?>px; height:<?php echo $this->bicpicHeight; ?>px;">
		       <a href="<?php echo  $this->layer_imgsrc[$k]; ?>" class="img normal" rel="lightbox[<?php echo $this->moduleId; ?>]"><img src="<?php echo $bicpic; ?>" alt="" width="<?php echo $this->bicpicWidth; ?>" height="<?php echo $this->bicpicHeight; ?>" /></a>
		       <a href="<?php echo  $this->layer_imgsrc[$k]; ?>" class="detail_glas" rel="lightbox[<?php echo $this->moduleId; ?>]"><img src="tl_files/mein-anzeigenportal/images/plus_glas.png" alt=""/></a>
		       </div>
	           </li>
	         <?php endforeach; ?>  
	         </ul>
	         
	      </div>
	      
	      <?php 
	      $nr=0;
	      foreach($this->thumbpics as $thumb): 
	      $nr++;
	      ?>
		  <a href="" class="img thumbs" data-value="<?php echo $nr; ?>"><img src="<?php echo $thumb; ?>" alt="" width="<?php echo $this->thumbpicsWidth; ?>" height="<?php echo $this->thumbpicsHeight; ?>" /></a>		          
	      <?php endforeach; ?>
	   </div><!--.imgbox-->
       <?php endif; ?>
       
       <?php if($this->isVideo):?>
        <div class="videolayer_link">
	   <a href='<?php echo $this->videopath; ?>' rel="lightbox[set <?php echo $this->layerWidth;?> <?php echo $this->layerHeight;?>]" title="" class="video_playlink">Video abspielen</a> 
        </div><!--.videolayer_link-->
       <?php endif; ?>
       
       <div class="description">
	   <h3>Beschreibung</h3>
	    <?php echo $this->text; ?>
	</div><!--.description--> 
	  
	<a href="<?php echo $this->backlink; ?>" class="backlink">Zurück zur Liste</a>
</div>
<!-- indexer::continue -->



		       
