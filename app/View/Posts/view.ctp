<div class="hentry">
    <h2 class="entry-title"><?php echo $post['Post']['name'];?></h2>
    <?php if ($post['Post']['type'] == 'post'): ?>
    	<div class="entry-meta">
			<span>Posté le </span>
			<span class="entry-date"><?php echo $this->date->format($post['Post']['created'],'FRS') ?></span>
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

<div id="comments">
	<h3 id="comments-title">
		<?php 
		$count = $post['Post']['comment_count'];
		if($count == 0)
			echo "Aucun commentaire";
		else{
			$terminaison = ($count>1) ? 's' : '';
			echo $count.' commentaire'.$terminaison.' pour <span style="font-weight: bold">'.$post['Post']['name'].'</span>';
		}
		?>
	</h3>
	<?php if (!empty($post['Comment'])): ?>
		<ul style="list-style-type: none" id="comment-list">
			<?php foreach ($post['Comment'] as $k => $v): ?>
				<li class="comment">
					<div id="comment-<?php echo $v['id'] ?>">
						<div class="comment-author">
							<?php echo $v['author'] ?> a écrit : 
						</div>
						<div class="comment-meta">
							Posté le <?php echo $this->date->format($v['created'],'FRS',true) ?>
						</div>
						<div class="comment-message">
							<?php echo $v['content'] ?>
						</div>
					</div>
				</li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
	<hr>
	<h2>Laisser un commentaire</h2>
	<div id="form-comment">
		<?php echo $this->Form->create('Comment',array('url'=>array('controller'=>'comments','action'=>'post'))) ?>
		<?php echo $this->Form->input('Comment.author',array('label'=>"Nom")); ?>
		<?php echo $this->Form->input('Comment.author_email',array('label'=>"Adresse de contact")); ?>
		<?php echo $this->Form->input('Comment.author_url',array('label'=>"Site web")); ?>
		<?php echo $this->Form->input('Comment.content',array('label'=>"Votre message")); ?>
		<?php echo $this->Form->input('Comment.post_id',array('label'=>false,'type'=>'hidden','value'=>$post['Post']['id'])); ?>
		<?php echo $this->Form->end('Laisser un commentaire') ?>
	</div>
</div>