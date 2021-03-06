<!-- indexer::stop -->

<div class="catnav">
   <h3><?php echo $this->headline; ?></h3>
   <ul>
       <?php foreach($this->entries as $entry): ?>
       <li class="catmenutoggler"><span><?php echo $entry['name']; ?></span>
       			  <?php if(count($entry['subdata'])>0): ?>
       			   <ul class="catmenuaccordion">
				<?php foreach($entry['subdata'] as $subdata):?>   
				     <li class="<?php echo $subdata['class']; ?>">
					 <a href="<?php echo $subdata['detailurl']; ?>" title="zu den <?php echo $subdata['linktitle']; ?>-Anzeigen wechseln" class="<?php echo $subdata['class']; ?>"><?php echo $subdata['name']; ?></a>
				     </li>
				<?php endforeach; ?>			       
			   </ul>
			   <?php endif; ?>
       </li>
       <?php endforeach; ?>
   </ul>
</div><!--.catnav-->

<script type="text/javascript">
<!--//--><![CDATA[//><!--
window.addEvent('domready', function() {

    var Toggler = $$('li.catmenutoggler span');
    var Accordeon = $$('ul.catmenuaccordion');


  new Accordion(Toggler, Accordeon, {
    alwaysHide: true,
    display:-1,
    show:<?php echo $this->JSOptionShowActive; ?>,
    opacity: 0.2,

                onActive: function(toggler, i)
                {
                       toggler.addClass('active');

                },

                onBackground: function(toggler, i)
                {
                        toggler.removeClass('active');

                }
  });
});
//--><!]]>
</script>

<!-- indexer::continue -->
