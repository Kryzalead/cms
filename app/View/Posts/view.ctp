
<?php if ($post['Post']['type'] == 'post'): ?>
	<h2><?php echo $post['Post']['name'] ?></h2>
	<div>
		<span>Posté le </span>
		<span><?php echo $this->date->format($post['Post']['created'],'FRS') ?></span>
		<span>par</span>
		<span><?php echo $post['User']['username'] ?></span>
	</div>

<div>
	<span>
	<?php if (!empty($post['Taxonomy']['category'])): ?>
		<span><strong>Categories : </strong></span>
		<?php foreach ($post['Taxonomy']['category'] as $k1 => $v1): ?>
			<span>
				<?php echo $this->Html->link($v1['name'],array('plugin'=>false,'controller'=>'posts','action'=>'viewterm','type'=>'category','slug'=>$v1['slug'])); ?>
			</span>
		<?php endforeach ?>
	<?php endif; ?>	
	<?php if(!empty($post['Taxonomy']['tag'])): ?>
		<span> | </span>
		<span><strong>Tags : </strong></span>
		<?php foreach ($post['Taxonomy']['tag'] as $k1 => $v1): ?>
			<span><?php echo $this->Html->link($v1['name'],array('action'=>'','controller'=>'')); ?></span>
		<?php endforeach ?>				
	<?php endif; ?>	 					
	</span>
</div>	
<?php endif ?>
<?php $id = $post['Post']['slug'] ?>
<div id="<?php echo $id ?>">
	<?php echo $post['Post']['content'];?>
</div>
<div class="cb"></div>
