<!-- indexer::stop -->

<div class="selectcat">
   <?php if($this->headline):?><<?php echo $this->hl;?>><?php echo $this->headline; ?></<?php echo $this->hl;?>><?php endif; ?>
    <form action="<?php echo $this->action; ?>" id="ad_share_form" method="post" class="form">
    
    <input type="hidden" name="FORM_SUBMIT" value="<?php echo $this->form_submit; ?>" />
   
   <?php if($this->isError): echo $this->errorText; endif; ?>
   
   <ul class="catlist">
       <?php foreach($this->entries as $entry): ?>
       <li class="parentcat"><span><?php echo $entry['name']; ?></span>
       			  <?php if(count($entry['subdata'])>0): ?>
       			   <ul class="catmenuaccordion">
				<?php foreach($entry['subdata'] as $k => $subdata):
				#print_r($subdata);
				?>   
				     <li class="<?php echo $subdata['class']; ?>">
					 <input type="radio" name="category" id="cat_<?php echo $subdata['id']; ?>" value="<?php echo $subdata['id']; ?>" <?php if($subdata['class']=='active') echo 'checked="checked"'; ?>/><label for="cat_<?php echo $subdata['id']; ?>"><?php echo $subdata['name']; ?></label>
				     </li>
				<?php endforeach; ?>			       
			   </ul>
			   <?php endif; ?>
       </li>
       <?php endforeach; ?>
   </ul>
   <div class="clear"></div>
   <div class="prevnext_row"><input type="submit" name="submit" value="weiter" class="submit next"/></div>
   </form>
</div><!--.selectcat-->


<!-- indexer::continue -->
