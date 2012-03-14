<style type="text/css">
	#content a:hover{color: #ff4b33}
	#content #post-status .current{color: #000;font-weight : bold;}
</style>
<h1>
	<?php echo $this->Html->image($icon_for_layout,array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
	<?php echo $this->Html->link($text_for_add_post,array('action'=>'edit','?'=>array('type'=>$type)),array('class'=>'button button-add')) ?>
	<?php if (!empty($search)): ?>
		<span>Résultats de recherche pour "<?php echo $search ?>"
	<?php endif ?>

<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create('Post',array('type'=>'get')); ?>
	<?php echo $this->Form->input('s',array('label'=>'')) ?>
	<?php echo $this->Form->input('type',array('label'=>null,'type'=>'hidden','value'=>$type)); ?>
	<?php echo $this->Form->input('status',array('label'=>null,'type'=>'hidden','value'=>$status)); ?>
	<?php echo $this->Form->end($text_for_submit_search); ?>
</div>

<div>
	<p style="display: inline-block;float: left" id="post-status">
		<?php if ($status == 'all'): ?>
			<?php echo $this->Html->link("Tous",array('?'=>array('type'=>$type)),array('class'=>'current')); ?>
		<?php else: ?>
			<?php echo $this->Html->link("Tous",array('?'=>array('type'=>$type))); ?>
		<?php endif ?>
		
		(<span class="total"><?php echo $total ?></span>)
		<?php if ($totalPublish != 0): ?>
			<?php if ($status == 'publish'): ?>
				 | <?php echo $this->Html->link("Publiés",array('?'=>array('type'=>$type,'status'=>'publish')),array('class'=>'current')); ?>
			<?php else: ?>
				 | <?php echo $this->Html->link("Publiés",array('?'=>array('type'=>$type,'status'=>'publish'))); ?>
			<?php endif ?> 
			(<span class="totalPublished"><?php echo $totalPublish ?></span>) 	
		<?php endif ?> 
		<?php if ($totalDraft != 0): ?>
			<?php if ($status == 'draft'): ?>
				 | <?php echo $this->Html->link("Brouillons",array('?'=>array('type'=>$type,'status'=>'draft')),array('class'=>'current')); ?>
			<?php else: ?>
				 | <?php echo $this->Html->link("Brouillons",array('?'=>array('type'=>$type,'status'=>'draft'))); ?>
			<?php endif ?> 
			(<span class="totalDraft"><?php echo $totalDraft ?></span>)	
		<?php endif ?>
		<?php if ($totalTrash != 0): ?>
			<?php if ($status == 'trash'): ?>
				 | <?php echo $this->Html->link("Corbeille",array('?'=>array('type'=>$type,'status'=>'trash')),array('class'=>'current')); ?>
			<?php else: ?>
				 | <?php echo $this->Html->link("Corbeille",array('?'=>array('type'=>$type,'status'=>'trash'))); ?>
			<?php endif ?> 
			(<span class="totalTrash"><?php echo $totalTrash ?></span>) 	
		<?php endif ?>
	</p>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>
<?php echo $this->Form->create('Post',array('url'=>array('controller'=>'posts','action'=>'doaction'))) ?>
	<div style="margin-top: 10px">
		<?php echo $this->Form->input('action',array('label'=>false,'type'=>'select','options'=>$list_action)); ?>
		<?php echo $this->Form->input('type',array('label'=>false,'type'=>'hidden','value'=>$type)); ?>
		<?php echo $this->Form->submit('Appliquer') ?>
	</div>
	<div class="bloc">
		<div class="content">
			<table class="classicTable posts">
				<thead>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('name','Titre'); ?></th>
						<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
						<?php if ($type == 'post'): ?>
						<th>Catégories</th>
						<th>Mots-clefs</th>
						<?php endif ?>
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
									<?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit','?'=>array('type'=>$type,'id'=>$v['Post']['id'])),array('class'=>'upd')) ?>
									<span> -- Brouillon</span>
								<?php else: ?>
									<?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit','?'=>array('type'=>$type,'id'=>$v['Post']['id'])),array('class'=>'upd')) ?>
								<?php endif ?>
								<div class="action_admin">
									<?php if ($v['Post']['status'] == 'trash'): ?>
										<?php echo $this->Html->link("Restaurer",array('action'=>'post','?'=>array('action'=>'untrash','id'=>$v['Post']['id'])),array('class'=>'del')); ?>
										<?php echo $this->Html->link("Supprimer définitivement",array('action'=>'post','?'=>array('action'=>'delete','id'=>$v['Post']['id'],'token'=>$this->Session->read('Security.token')))); ?>
									<?php else: ?>
										<?php echo $this->Html->link('Modifier',array('action'=>'edit','?'=>array('type'=>$type,'id'=>$v['Post']['id'])),array('class'=>'upd')) ?> |
										<?php echo $this->Html->link("Mettre à la corbeille",array('action'=>'post','?'=>array('action'=>'trash','id'=>$v['Post']['id'])),array('class'=>'del')); ?>
										<?php if ($v['Post']['status'] == 'draft'): ?>
											preview
										<?php else: ?>
											<?php if ($type == 'post'): ?>
												<?php echo $this->Html->link("Afficher",array('action'=>'view','admin'=>false,'type'=>'post','id'=>$v['Post']['id'],'slug'=>$v['Post']['slug']),array('target'=>'_blank')); ?>
											<?php else: ?>
												<?php echo $this->Html->link("Afficher",array('action'=>'view','admin'=>false,'type'=>'page','slug'=>$v['Post']['slug']),array('target'=>'_blank')); ?>
											<?php endif ?>
										<?php endif ?>
									<?php endif ?>
								</div>
							</td>
							<td><?php echo $this->Html->link($v['User']['username'],array('action'=>'index','?'=>array('type'=>$type,'author'=>$v['User']['id']))); ?></td>
							<?php if ($type == 'post'): ?>
							<td>
								<?php foreach ($v['Taxonomy']['category'] as $k1 => $v1): ?>
									<?php echo $this->Html->link($v1['name'],array('?'=>array('type'=>$type,'category'=>$v1['slug']))); ?>
								<?php endforeach ?>
							</td>
							<td>
								<?php if(!empty($v['Taxonomy']['tag'])): ?>
									<?php foreach ($v['Taxonomy']['tag'] as $k1 => $v1): ?>
										<?php echo $v1['name'] ?>
									<?php endforeach ?>
								<?php else: ?>
									Aucun mot-clef				
								<?php endif; ?>	
							</td>
							<?php endif ?>
							<td><?php echo $this->date->format($v['Post']['created'],'FR'); ?></td>
						</tr>
					<?php endforeach ?>
					<?php else: ?>
						<td></td>
						<td>Aucun article à afficher</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					<?php endif ?>
				</tbody>
				<tfoot>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('name','Titre'); ?></th>
						<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
						<?php if ($type == 'post'): ?>
						<th>Catégories</th>
						<th>Mots-clefs</th>
						<?php endif ?>
						<th><?php echo $this->Paginator->sort('created','Date'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
<div class="elements">
	<p>
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Élément<?php echo $terminaison ?>
	</p>
</div>

<?php echo $this->Paginator->numbers(); ?>

