<?php $this->set('title_for_layout',$post['Post']['name']); ?>
<div class="hentry">
    <h2 class="entry-title"><?php echo $post['Post']['name'];?></h2>
    <div class="entry-content">
		<?php echo $post['Post']['content'];?>
	</div>
</div>