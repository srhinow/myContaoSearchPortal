<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?><?php echo $this->headline.' '; ?><?php endif; ?>
    <ul>
    <?php foreach ($this->items as $item):?>       
       <li class="item">
	    <div class="imgbox"><a href="<?php echo $item['detailurl']; ?>" title="zu den Details der Anzeige <?php echo $item['title']; ?>"><img src='<?php echo $item['picture'];?>' alt=''></a></div>
	    <h3><a href="<?php echo $item['detailurl']; ?>" title="zu den Details der Anzeige <?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></h3>
	    <div class="date"><?php echo $item['humandate']; ?></div>
	    <div class="where"><?php echo $item['city']; ?></div>
	    <div class="price"><?php echo $item['price']; ?></div>
	    <div class="categories">Kategorie: <a href="<?php echo $item['caturl']; ?>"><?php echo $item['category'];?></a></div>
       </li>
    <?php endforeach; ?>
    </ul>
</div>
<!-- indexer::continue -->
		       
