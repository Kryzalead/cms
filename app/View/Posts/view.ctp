<?php $this->set('title_for_layout',$post['Post']['name'].' | '.Configure::read('site_name')); ?>
<div class="hentry">
    <h2 class="entry-title"><?php echo $post['Post']['name'];?></h2>
    <div class="entry-meta">
		<span>Posté le </span>
		<span class="entry-date"><?php echo $this->date->format($post['Post']['created'],'FR') ?></span>
		<span>par</span>
		<span class="entry-author"><?php echo $post['User']['username'] ?></span>
	</div>
    <div class="entry-content">
		<?php echo $post['Post']['content'];?>
	</div>
</div>