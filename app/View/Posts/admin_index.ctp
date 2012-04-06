<style type="text/css">
	#content .comment-post span {background-color: #BBB;display: inline-block;text-align: center;border-radius: 5px;color: #fff;font-weight: bold;cursor: pointer}
	#content .comment-post span.comment-waiting{background-color: #21759B}
	#content .comment-post span:hover{background-color: #D74E21}
	#content .comment-post span a{text-decoration: none;color: #fff;display: block;padding: 0 6px;height: 1.4em;line-height:1.4em;}
	#content .comment-post span a:hover{color: #fff}
</style>
<h1>
	<?php echo $this->Html->image($icon_for_layout,array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php echo $this->Html->link($text_for_add_post,array('action'=>'edit','?'=>array('type'=>$type)),array('class'=>'button button-add')) ?>
<?php if (!empty($search)): ?>
	<span>Résultats de recherche pour "<?php echo $search ?>"
<?php endif ?>
<?php echo $this->element('admin-search',array('model'=>'post','options'=>array('type'=>$type,'status'=>$status),'text_for_submit_search'=>$text_for_submit_search)) ?>
<div>
	<?php echo $this->element('admin-list-top-table',array('model'=>'post','options'=>$data_for_top_table)) ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
</div>
<?php echo $this->Form->create('Post',array('url'=>array('controller'=>'posts','action'=>'doaction'))) ?>
	<?php echo $this->element('admin-action-groupees',array('list'=>$list_action,'options'=>array('type'=>$type))) ?>
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
							<th><?php echo $this->Html->image('comment-grey-bubble.png') ?></th>
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
							<td class="comment-post">
								<?php $class = (!empty($v['Post']['totalWaiting'])) ? 'class="comment-waiting"'  : ''?>
								<span <?php echo $class ?>>
									<?php echo $this->Html->link($v['Post']['comment_count'],array('controller'=>'comments','action'=>'index','?'=>array('post_id'=>$v['Post']['id'])),array('title'=>$v['Post']['totalWaiting'].' en attente')); ?>
								</span>
							</td>
							<?php endif ?>
							<td><?php echo $this->date->format($v['Post']['created'],'STR',true); ?></td>
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
							<th><?php echo $this->Html->image('comment-grey-bubble.png') ?></th>
						<?php endif ?>
						<th><?php echo $this->Paginator->sort('created','Date'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
<?php echo $this->Paginator->numbers(); ?>

