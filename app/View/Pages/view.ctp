<?php $this->set('title_for_layout',$page['Post']['name']); ?>
<div class="hentry">
    <h2 class="entry-title"><?php echo $page['Post']['name'];?></h2>
    <div class="entry-content">
		<?php echo $page['Post']['content'];?>
	</div>
</div>