<p>Insérer l'adresse de votre lien</p>
<?php echo $this->Form->create('Page') ?>
	<?php echo $this->Form->input('Post.link-src',array('label'=>'Adresse web','id'=>'post-link-src')); ?>
	<?php echo $this->Form->input('Post.link-title',array('label'=>'Titre','id'=>'post-link-title')); ?>
	<?php echo $this->Form->input('Post.content',array('type'=>'hidden')); ?>
<?php echo $this->Form->end('Ajouter un lien') ?>
<p>Ou insérer un lien vers l'un des contenu de votre site</p>
<?php if (!empty($posts)): ?>
	<ul style="list-style-type: none;width: 600px">
	<?php foreach ($posts as $k => $v): ?>
		<li class="post-link" style="border: 1px solid grey;height: 30px;line-height: 30px;padding-left:10px">
			<?php echo $this->Form->input('Post.guid',array('type'=>'hidden','value'=>$v['Post']['guid'])); ?>
			<span class="post-title" style="display: inline-block;width: 85%"><?php echo $v['Post']['name'] ?></span>
			<span><?php echo $v['Post']['type'] ?></span>
		</li>
	<?php endforeach ?>
	</ul>
<?php else: ?>
	<ul style="list-style-type: none">
		<li>Aucun contenu à afficher</li>
	</ul>	
<?php endif ?>
<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
	jQuery(function($){
		$('.post-link').click(function(){
			var guid = $(this).children('input').val();
			var title = $(this).children('.post-title').text();
			$('#post-link-src').val(guid);
			$('#post-link-title').val(title);
		})
	});
<?php echo $this->Html->scriptEnd() ?>