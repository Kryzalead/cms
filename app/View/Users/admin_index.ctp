<h1>
	<?php echo $this->Html->image('icone-users.png',array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
	<?php echo $this->Html->link('Ajouter un utilisateur',array('action'=>'edit'),array('class'=>'button button-add')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span style="color: #777">Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

<?php echo $this->element('admin-search',array('model'=>'user','text_for_submit_search'=>'Chercher un utilisateur')) ?>

<div>
	<?php echo $this->element('admin-list-top-table',array('model'=>'user','options'=>$data_for_top_table)) ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
</div>
<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'doaction'))) ?>
	<?php echo $this->element('admin-action-groupees',array('list'=>$list_action)) ?>
	<table class="liste_table users">
		<thead>
			<tr>
				<th><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('User.username','Identifiant'); ?></th>
				<th>Nom</th>
				<th><?php echo $this->Paginator->sort('User.email','E-mail'); ?></th>
				<th>Rôle</th>
				<th>Pages</th>
				<th>Articles</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($users)): ?>
				<?php foreach ($users as $k => $v):?>
				<tr id="post_<?php echo $v['User']['id'] ?>">
					<td><?php echo $this->Form->input($v['User']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
					<td>
						<?php 
						$gravatar = md5( strtolower( trim($v['User']['email'])));
						?>
						<?php echo $this->Html->image('http://www.gravatar.com/avatar/'.$gravatar.'?s=40') ?>	
						<?php echo $this->Html->link($v['User']['username'],array('action'=>'edit','?'=>array('id'=>$v['User']['id'])),array('class'=>'upd')) ?>
						
						<div class="action_admin">
							<?php echo $this->Html->link('Modifier',array('action'=>'edit','?'=>array('id'=>$v['User']['id'])),array('class'=>'upd')) ?>
							<?php if ($v['User']['role'] != 'admin'): ?>
								| <?php echo $this->Html->link("Supprimer définitivement",array('action'=>'delete','?'=>array('id'=>$v['User']['id'],'token'=>$this->Session->read('Security.token'))),array('class'=>'del')); ?>	
							<?php endif ?>
									
						</div>
					</td>
					<td>
						<?php echo (!empty($v['User_meta']['first_name'])) ? $v['User_meta']['first_name'] : ' '?>
						<?php echo (!empty($v['User_meta']['last_name'])) ? $v['User_meta']['last_name'] : ' '?>
					</td>
					<td><?php echo $v['User']['email']; ?></td>
					<td>
						<?php echo ($v['User']['role'] == 'admin') ? 'Administrateur' : ''?>
						<?php echo ($v['User']['role'] == 'user') ? 'Abonné' : ''?>
					</td>
					<td>
						<?php echo ($v['User']['page_count'] != 0) ? $this->Html->link($v['User']['page_count'],array('controller'=>'posts','action'=>'index','?'=>array('type'=>'page','author'=>$v['User']['id']))) : 0; ?>
					</td>
					<td>
						<?php echo ($v['User']['post_count'] != 0) ? $this->Html->link($v['User']['post_count'],array('controller'=>'posts','action'=>'index','?'=>array('type'=>'post','author'=>$v['User']['id']))) : 0; ?>
					</td>
				</tr>
			<?php endforeach ?>
			<?php else: ?>
				<td></td>
				<td>Aucun utilisateur à afficher</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			<?php endif ?>
		</tbody>
		<tfoot>
			<tr>
				<th><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('User.username','Identifiant'); ?></th>
				<th>Nom</th>
				<th><?php echo $this->Paginator->sort('User.email','E-mail'); ?></th>
				<th>Rôle</th>
				<th>Pages</th>
				<th>Articles</th>
			</tr>
		</tfoot>
	</table>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
<?php echo $this->Paginator->numbers(); ?>
