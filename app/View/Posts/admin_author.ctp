<h1><?php echo $this->Html->image('icone-posts.png',array('width'=>32,'height'=>32)); ?> Articles</h1>
<?php echo $this->Html->link('Ajouter un article',array('action'=>'edit'),array('class'=>'btn primary')) ?>
<?php if (!empty($this->request->query['search'])): ?>
	<span>Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
<?php endif ?>

<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create('Post',array('type'=>'get','url' => array('action' => 'index'))); ?>
	<?php echo $this->Form->input('search',array('label'=>false)) ?>
	<?php echo $this->Form->end('Rechercher dans les articles'); ?>
</div>
<div>
	<p style="display: inline-block;float: left">
		<?php echo $this->Html->link("Tous",array('action'=>'index')); ?>
		(<span class="total"><?php echo $total ?></span>)
		<?php if ($totalPublish != 0): ?>
			| <?php echo $this->Html->link("Publié",array('action'=>'index','publish')); ?>
			(<span class="totalPublished"><?php echo $totalPublish ?></span>) 	
		<?php endif ?> 
		<?php if ($totalDraft != 0): ?>
			| <?php echo $this->Html->link("Brouillon",array('action'=>'index','draft')); ?>
			(<span class="totalDraft"><?php echo $totalDraft ?></span>)	
		<?php endif ?>
		<?php if ($totalTrash != 0): ?>
			| <?php echo $this->Html->link("Corbeille",array('action'=>'index','trash')); ?>
			(<span class="totalTrash"><?php echo $totalTrash ?></span>) 	
		<?php endif ?>
	</p>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>
<table class="classicTable posts" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;display: table;border-spacing: 2px;border-color: gray;margin-top: 10px">
	<thead style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
		<tr style="color: #21759B">
			<th><input type="checkbox"></th>
			<th>Titre</th>
			<th>Auteur</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody style="color: gray;">
		<?php if (!empty($posts)): ?>
			<?php foreach ($posts as $k => $v):?>
			<tr id="post_<?php echo $v['Post']['id'] ?>">
				<td><?php echo $this->Form->input($v['Post']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
				<td>
					<?php if ($v['Post']['status'] == 'trash'): ?>
						<span style="color: #333"><?php echo $v['Post']['name'] ?></span>
					<?php elseif($v['Post']['status'] == 'draft' && $status != 'draft'): ?>
						<?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit',$v['Post']['id']),array('class'=>'upd')) ?>
						<span> -- Brouillon</span>
					<?php else: ?>
						<?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit',$v['Post']['id']),array('class'=>'upd')) ?>
					<?php endif ?>
					<div class="action_admin">
						<?php if ($v['Post']['status'] == 'trash'): ?>
							<?php echo $this->Form->postLink('Restaurer',array('action'=>'untrash',$v['Post']['id']),array('class'=>'del')) ?>
							<span>|</span>
							<?php echo $this->Form->postLink('Supprimer définitivement',array('action'=>'delete',$v['Post']['id']),array('class'=>'del'),'Voulez vous vraiment supprimer ce contenu ?') ?>
						<?php else: ?>
							<?php echo $this->Html->link('Modifier',array('action'=>'edit',$v['Post']['id']),array('class'=>'upd')) ?> 
							<span>|</span>
							<?php echo $this->Form->postLink('Mettre à la corbeille',array('action'=>'trash',$v['Post']['id']),array('class'=>'del')) ?>
							<span>|</span>
							<?php if ($v['Post']['status'] == 'draft'): ?>
								<?php echo $this->Html->link('Aperçu',array('action'=>'preview',$v['Post']['id']),array('class'=>'upd','target'=>'_blank')) ?>
							<?php else: ?>
								<?php echo $this->Html->link('Afficher',array_merge($v['Post']['link'],array('admin'=>false)),array('class'=>'upd','target'=>'_blank')) ?>
							<?php endif ?>
						<?php endif ?>
					</div>
				</td>
				<td><?php echo $v['User']['username']; ?></td>
				<td><?php echo $this->date->format($v['Post']['created'],'FR'); ?></td>
			</tr>
		<?php endforeach ?>
		<?php else: ?>
			<td></td>
			<td>Aucun article à afficher</td>
			<td></td>
			<td></td>
		<?php endif ?>
	</tbody>
</table>
<div>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>

