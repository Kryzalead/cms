<h1>
	<?php echo $this->Html->image('icone-pages.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php echo $this->Html->link('Ajouter une page',array('action'=>'edit'),array('class'=>'button button-add')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span>Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

<div class="search-box">
	<?php echo $this->Form->create('Post',array('type'=>'get','url' => array('controller' => 'pages', 'action' => 'index'))); ?>
	<?php echo $this->Form->input('search',array('label'=>'')) ?>
	<?php echo $this->Form->end('Rechercher dans les pages'); ?>
</div>
<div class="list-type-posts">
	<p class="list">
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
	<p class="totalElement">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>
<div class="bloc">
	<div class="content">
		<table class="classicTable">
			<thead>
				<tr>
					<th><input type="checkbox" class="checkall"></th>
					<th>Titre</th>
					<th>Auteur</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($pages)): ?>
					<?php foreach ($pages as $k => $v):?>
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
					<td>Aucune page à afficher</td>
					<td></td>
					<td></td>
				<?php endif ?>
			</tbody>
		</table>
	</div>
</div>
<div style="margin-top: 5px">
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>

