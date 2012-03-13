<div class="hentry">
    <h2 class="entry-title"><?php echo $post['Post']['name'];?></h2>
    <?php if ($post['Post']['type'] == 'post'): ?>
    	<div class="entry-meta">
			<span>Posté le </span>
			<span class="entry-date"><?php echo $this->date->format($post['Post']['created'],'FR') ?></span>
			<span>par</span>
			<span class="entry-author"><?php echo $post['User']['username'] ?></span>
		</div>
    <?php endif ?>
	<div class="entry-utility">
		<span class="cat-links">
		<?php if (!empty($post['Taxonomy']['category'])): ?>
			<span><strong>Categories : </strong></span>
			<?php foreach ($post['Taxonomy']['category'] as $k1 => $v1): ?>
				<span class="entry-category"><?php echo $this->Html->link($v1['name'],array('action'=>'','controller'=>'')); ?></span>
			<?php endforeach ?>
		<?php endif; ?>	
		<?php if(!empty($post['Taxonomy']['tag'])): ?>
			<span> | </span>
			<span><strong>Tags : </strong></span>
			<?php foreach ($post['Taxonomy']['tag'] as $k1 => $v1): ?>
				<span class="entry-category"><?php echo $this->Html->link($v1['name'],array('action'=>'','controller'=>'')); ?></span>
			<?php endforeach ?>				
		<?php endif; ?>	 					
		</span>
	</div>	
    <div class="entry-content">
		<?php echo $post['Post']['content'];?>
	</div>
</div>