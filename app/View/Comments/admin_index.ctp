<h1>
	<?php echo $this->Html->image('icone-comments.png',array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
<div>
	<?php echo $this->element('admin-list-top-table',array('model'=>'comment','options'=>$data_for_top_table)) ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
</div>
<?php echo $this->Form->create('Comment',array('url'=>array('controller'=>'comments','action'=>'doaction'))) ?>
	<?php //echo $this->element('admin-action-groupees',array('list'=>$list_action,'options'=>array('type'=>$type))) ?>
	<div class="bloc">
		<div class="content">
			<table class="classicTable posts">
				<thead>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('author','Auteur'); ?></th>
						<th>Commentaire</th>
						<th>En réponse à</th>
					</tr>
				</thead>

				<tbody>
					<?php if (!empty($comments)): ?>
						<?php foreach ($comments as $k => $v):?>
						<tr id="post_<?php echo $v['Comment']['id'] ?>">
							<td><?php echo $this->Form->input($v['Comment']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
							<td>
								<?php echo $v['Comment']['author'] ?> <br>
								<?php echo $v['Comment']['author_email'] ?> <br>
								<?php echo $v['Comment']['author_ip'] ?>
							</td>
							<td>
								<?php echo $v['Comment']['created'] ?> <br>
								<?php echo $v['Comment']['content'] ?>
								<div class="action_admin">
									
								</div>
							</td>
							<td>
								<?php echo $v['Post']['name'] ?> <br>
								<?php echo $v['Post']['comment_count'] ?>
							</td>
						</tr>
					<?php endforeach ?>
					<?php else: ?>
						<td></td>
						<td>Aucun commentaire à afficher</td>
						<td></td>
						<td></td>
					<?php endif ?>
				</tbody>
				<tfoot>
					<tr>
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('author','Auteur'); ?></th>
						<th>Commentaire</th>
						<th>En réponse à</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
<?php echo $this->Paginator->numbers(); ?>