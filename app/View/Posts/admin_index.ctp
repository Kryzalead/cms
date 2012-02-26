<h1><?php echo $this->Html->image('icone-posts.png',array('width'=>72,'height'=>72)); ?>Articles</h1>
	<?php echo $this->Html->link('Ajouter un article',array('action'=>'edit'),array('class'=>'button button-add')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span>Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create('Post',array('type'=>'get')); ?>
	<?php echo $this->Form->input('search',array('label'=>'')) ?>
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

<div class="bloc">
	<div class="content">
		<table class="classicTable posts">
			<thead>
				<tr>
					<th><input type="checkbox"></th>
					<th><?php echo $this->Paginator->sort('name','Titre'); ?></th>
					<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Date'); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($posts)): ?>
					<?php foreach ($posts as $k => $v):?>
					<tr id="post_<?php echo $v['Post']['id'] ?>">
						<td><?php echo $this->Form->input($v['Post']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
						<td>
							<?php if ($v['Post']['status'] == 'trash'): ?>
								<span><?php echo $v['Post']['name'] ?></span>
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
						<td><?php echo $this->Html->link($v['User']['username'],array('action'=>'author',$v['User']['username'])); ?></td>
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
			<tfoot>
				<tr>
					<th><input type="checkbox"></th>
					<th><?php echo $this->Paginator->sort('name','Titre'); ?></th>
					<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Date'); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="elements">
	<p>
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Élément<?php echo $terminaison ?>
	</p>
</div>

<?php echo $this->Paginator->numbers(); ?>

