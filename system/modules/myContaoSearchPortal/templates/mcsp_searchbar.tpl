  <div class="searchbar">
      <img src="tl_files/mein-anzeigenportal/images/lupe.png" alt="" class="lupe"/>
      <form action="<?php echo $this->formurl; ?>" method="post" class="searchform">
	 <input type="hidden" name="FORM_SUBMIT" value="bigSearchForm"/>
	 <div class="keyword">
	     <?php echo $this->inputKeyword->generateLabel();?>
	     <?php echo $this->inputKeyword->generate();?>	 
	 </div>     
	 <div class="where">
	     <?php echo $this->inputWhere->generateLabel();?>
	     <?php echo $this->inputWhere->generate();?>
	 </div> 
	 <div class="radius">
	     <?php echo $this->inputRadius->generateLabel();?>
	     <?php echo $this->inputRadius->generate();?>
	 </div>
	 <div class="categories">
	     <?php echo $this->inputCategories->generateLabel();?>
	     <?php echo $this->inputCategories->generate();?>
	 </div>
	 <input type="submit" name="submit" value="Suchen" class="submit"/>
	 
  </form>
  </div>