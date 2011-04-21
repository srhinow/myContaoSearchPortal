
<div class="event block<?php echo $this->class; ?>">

<h1><?php echo $this->title; ?></h1>

<p class="info"><?php echo $this->date; ?></p>
<?php if ($this->recurring): ?>

<p class="recurring"><?php echo $this->recurring; if ($this->until): ?> <?php echo $this->until; endif; ?>.</p>
<?php endif; ?>

<div class="ce_text">
<?php if ($this->addImage): ?>
<div class="image_container"<?php if ($this->margin || $this->float): ?> style="<?php echo $this->margin . $this->float; ?>"<?php endif; ?>>
<?php if ($this->fullsize): ?><a href="<?php echo $this->href; ?>" title="<?php echo $this->alt; ?>" rel="lightbox"><?php endif; ?>
<img src="<?php echo $this->src; ?>"<?php echo $this->imgSize; ?> alt="<?php echo $this->alt; ?>" /><?php if ($this->fullsize): ?></a><?php endif; ?> 
<?php if ($this->caption): ?>
<div class="caption"><?php echo $this->caption; ?></div>
<?php endif; ?>
</div>
<?php endif; ?>
<?php echo $this->details; ?>
</div>
<?php if ($this->enclosure): ?>

<div class="enclosure">
<?php foreach ($this->enclosure as $enclosure): ?>
<p><img src="<?php echo $enclosure['icon']; ?>"<?php echo $enclosure['size']; ?> alt="<?php echo $enclosure['title']; ?>" class="mime_icon" /> <a href="<?php echo $enclosure['href']; ?>" title="<?php echo $enclosure['title']; ?>"><?php echo $enclosure['link']; ?></a></p>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ($this->showTags): ?>

<?php if (count($this->tags)): ?>
<ul class="tag-chain">
<?php $counter = 0; foreach ($this->tags as $tag): ?>
<li class="tag-chain-item<?php if ($counter == 0) echo ' first'; ?><?php if ($counter == count($this->tags)-1) echo ' last'; ?>"><?php echo $tag; ?></li>
<?php $counter++; endforeach; ?>
</ul>
<?php endif; ?>
<?php endif; ?>
</div>
