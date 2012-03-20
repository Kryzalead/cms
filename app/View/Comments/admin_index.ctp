<style type="text/css">
	#content table tbody tr:nth-child(2n+1) td {background: none}
	#content table tr.unapproved{background-color: lightYellow}
	
	#content .comment-post span {background-color: #BBB;display: inline-block;text-align: center;border-radius: 5px;color: #fff;font-weight: bold;cursor: pointer}
	#content .comment-post span.comment-waiting{background-color: #21759B}
	#content .comment-post span:hover{background-color: #D74E21}
	#content .comment-post span a{text-decoration: none;color: #fff;display: block;padding: 0 6px;height: 1.4em;line-height:1.4em;}
	#content .comment-post span a:hover{color: #fff}
</style>
<h1>
	<?php echo $this->Html->image('icone-comments.png',array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php if (!empty($search)): ?>
	<span>Résultats de recherche pour "<?php echo $search ?>"
<?php endif ?>
<?php if ($show_form_search): ?>
	<?php echo $this->element('admin-search',array('model'=>'comment','options' => $data_for_search,'text_for_submit_search'=>'Rechercher dans les commentaires')) ?>
<?php endif ?>
<div>
	<?php echo $this->element('admin-list-top-table',array('model'=>'comment','options'=>$data_for_top_table)) ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
</div>
<?php echo $this->Form->create('Comment',array('url'=>array('controller'=>'comments','action'=>'doaction'))) ?>
	<?php echo $this->element('admin-action-groupees',array('list'=>$list_action)) ?>
	<div class="bloc">
		<div class="content">
			<table class="classicTable posts">
				<thead>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('author','Auteur'); ?></th>
						<th>Commentaire</th>
						<?php if ($show_form_search): ?>
							<th><?php echo $this->Paginator->sort('post_id','En réponse à'); ?></th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($comments)): ?>
						<?php foreach ($comments as $k => $v):?>
						<?php $class = ($v['Comment']['approved'] == '0' ) ? 'class="unapproved"' : ''?>
						<tr id="post_<?php echo $v['Comment']['id'] ?>" <?php echo $class ?>>
							<td><?php echo $this->Form->input($v['Comment']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
							<td>
								<?php echo $v['Comment']['author'] ?> <br>
								<?php echo $this->Html->link($v['Comment']['author_email'],'mailto:'.$v['Comment']['author_email']); ?> <br>
								<?php echo $this->Html->link($v['Comment']['author_ip'],array('?'=>array('ip'=>$v['Comment']['author_ip']))); ?>
							</td>
							<td>
								<?php 
								$v['Post']['link']['admin'] = false;
								$v['Post']['link']['#'] = 'comment-'.$v['Comment']['id'];
								?>
								<?php if ($v['Comment']['approved'] == '1'): ?>
									Envoyé le <?php echo $this->Html->link($this->date->format($v['Comment']['created'],'FRS',true),$v['Post']['link']); ?> <br>
								<?php else: ?>
									Envoyé le <?php echo $this->date->format($v['Comment']['created'],'FRS',true)?> <br>
								<?php endif ?>
								<?php echo $v['Comment']['content'] ?>
								<div class="action_admin">
									<?php if ($v['Comment']['approved'] == '1'): ?>
										<?php echo $this->Html->link("Désapprouver",array('action'=>'action','?'=>array('action'=>'unapprove','id'=>$v['Comment']['id'])),array('style'=>'color: #D98500')); ?>
										| <?php echo $this->Html->link("Modifier",array('action'=>'edit','?'=>array('id'=>$v['Comment']['id'])),array('style'=>'color: #21759B')); ?>
										| <?php echo $this->Html->link("Indésirable",array('action'=>'action','?'=>array('action'=>'spam','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
										| <?php echo $this->Html->link("Corbeille",array('action'=>'action','?'=>array('action'=>'trash','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
									<?php endif ?>
									<?php if ($v['Comment']['approved'] == '0'): ?>
										<?php echo $this->Html->link("Approuver",array('action'=>'action','?'=>array('action'=>'approve','id'=>$v['Comment']['id'])),array('style'=>'color: #006505')); ?>
										| <?php echo $this->Html->link("Modifier",array('action'=>'edit','?'=>array('id'=>$v['Comment']['id'])),array('style'=>'color: #21759B')); ?>
										| <?php echo $this->Html->link("Indésirable",array('action'=>'action','?'=>array('action'=>'spam','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
										| <?php echo $this->Html->link("Corbeille",array('action'=>'action','?'=>array('action'=>'trash','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
									<?php endif ?>
									<?php if ($v['Comment']['approved'] == 'spam'): ?>
										<?php echo $this->Html->link("N'est pas un indésirable",array('action'=>'action','?'=>array('action'=>'unspam','id'=>$v['Comment']['id'])),array('style'=>'color: #D98500')); ?>  
										| <?php echo $this->Html->link("Supprimer définitivement",array('action'=>'action','?'=>array('action'=>'delete','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
									<?php endif ?>
									<?php if ($v['Comment']['approved'] == 'trash'): ?>
										<?php echo $this->Html->link("Restaurer",array('action'=>'action','?'=>array('action'=>'untrash','id'=>$v['Comment']['id'])),array('style'=>'color: #D98500')); ?>
										| <?php echo $this->Html->link("Supprimer définitivement",array('action'=>'action','?'=>array('action'=>'delete','id'=>$v['Comment']['id'])),array('style'=>'color: #BC0B0B')); ?>
									<?php endif ?>
								</div>
							</td>
							<?php if ($show_form_search): ?>
								<td class="comment-post">
									<?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit','controller'=>'posts','?'=>array('type'=>'post','id'=>$v['Post']['id']))); ?> <br>
									<?php $post_id = $v['Post']['id']; ?>
									<?php 
									$totalWaitingComments[$post_id] = (!empty($totalWaitingComments[$post_id])) ? $totalWaitingComments[$post_id] : 0;
									$class = ($totalWaitingComments[$post_id] > 0) ? 'class="comment-waiting"'  : '';
									?>
									<span <?php echo $class ?>>
										<?php echo $this->Html->link($v['Post']['comment_count'],array('?'=>array('post_id'=>$v['Comment']['post_id'])),array('title'=>$totalWaitingComments[$post_id].' en attente')); ?>
									</span>
									<br>
									<?php echo $this->Html->link("Afficher l'article",array('action'=>'view','controller'=>'posts','admin'=>false,'type'=>'post','id'=>$v['Post']['id'],'slug'=>$v['Post']['slug']),array('target'=>'_blank')); ?>
								</td>
							<?php endif ?>
							
						</tr>
					<?php endforeach ?>
					<?php else: ?>
						<td></td>
						<td>Aucun commentaire à afficher</td>
						<?php if ($show_form_search): ?>
							<th>En réponse à</th>
						<?php endif ?>
						<td></td>
					<?php endif ?>
				</tbody>
				<tfoot>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('author','Auteur'); ?></th>
						<th>Commentaire</th>
						<?php if ($show_form_search): ?>
							<th><?php echo $this->Paginator->sort('post_id','En réponse à'); ?></th>
						<?php endif ?>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
<?php echo $this->Paginator->numbers(); ?>