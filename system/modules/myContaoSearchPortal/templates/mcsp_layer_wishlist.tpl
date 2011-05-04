<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> tablelist"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
    <?php if ($this->headline): ?><<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>><?php endif; ?>    
<?php if(count($this->items)>0): ?>
       <div class="wishlist_overflow_content">
       <table>
           <?php foreach ($this->items as $item):?>
	    <tr class="item<?php echo $item['hightlightClass'];?>">
		<td class="imgbox"><a href="<?php echo $item['detailurl']; ?>" title="zu den Details der Anzeige <?php echo $item['title']; ?>" target="_parent"><?php if($item['picture']):?><img src='<?php echo $item['picture'];?>' alt=''><?php endif; ?></a></td>
		<td class="text">
		    <h3><a href="<?php echo $item['detailurl']; ?>" target="_parent"><?php echo $item['title']; ?></a></h3>
		    <p><a href="<?php echo $item['detailurl']; ?>" target="_parent"><?php echo $item['text']; ?></a></p>
		    <div class="date"><a href="<?php echo $item['detailurl']; ?>" target="_parent"><?php echo $item['humandate']; ?></a></div>				
		</td>
		<td class="address">
		    <a href="<?php echo $item['detailurl']; ?>" target="_parent"><?php echo $item['plz']; ?><br />
		    <?php echo $item['city']; ?><br />
		    <?php echo $item['distance'];?></a>
		</td>
		<td class="price">
		    <div>
			<a href="<?php echo $item['detailurl']; ?>" target="_parent"><?php echo $item['price']; ?></a>
			<a href="<?php echo $item['delLink']; ?>" class="dellink">aus Liste löschen</a>
		    </div>
		</td>
	   </tr>
	    <?php endforeach; ?>	   
	   </table>
	   </div><!--.wishlist_overflow_content-->
<?php else: ?>
<p>es sind im Moment keine Einträge auf dem Merkliste vorhanden</p>
<?php endif; ?>		       
</div><!--.tablelist-->
<!-- indexer::continue -->
