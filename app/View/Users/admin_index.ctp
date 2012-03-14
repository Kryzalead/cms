<h1>
	<?php echo $this->Html->image('icone-users.png',array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
	<?php echo $this->Html->link('Ajouter un utilisateur',array('action'=>'edit'),array('class'=>'button button-add')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span style="color: #777">Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create('User',array('type'=>'get')); ?>
	<?php echo $this->Form->input('search',array('label'=>'')) ?>
	<?php echo $this->Form->end('Rechercher dans les utilisateurs'); ?>
</div>
<div>
	<?php echo $this->element('list-top-table',array('model'=>'user','options'=>$data_for_top_table)) ?>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>	
	</p>
</div>
<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'doaction'))) ?>
	<div style="margin-top: 10px">
		<?php echo $this->Form->input('action',array('label'=>false,'type'=>'select','options'=>$list_action)); ?>
		<?php echo $this->Form->submit('Appliquer') ?>
	</div>
	<table class="classicTable posts" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;display: table;border-color: gray;margin-top: 10px">
		<thead style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
			<tr style="color: #21759B">
				<th><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('User.username','Identifiant'); ?></th>
				<th>Nom</th>
				<th><?php echo $this->Paginator->sort('User.email','E-mail'); ?></th>
				<th>Rôle</th>
				<th>Pages</th>
				<th>Articles</th>
			</tr>
		</thead>
		<tbody style="color: gray;">
			<?php if (!empty($users)): ?>
				<?php foreach ($users as $k => $v):?>
				<tr id="post_<?php echo $v['User']['id'] ?>">
					<td><?php echo $this->Form->input($v['User']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
					<td>
						<?php 
						$gravatar = md5( strtolower( trim($v['User']['email'])));
						?>
						<?php echo $this->Html->image('http://www.gravatar.com/avatar/'.$gravatar.'?s=40') ?>	
						<?php echo $this->Html->link(ucfirst($v['User']['username']),array('action'=>'edit','?'=>array('id'=>$v['User']['id'])),array('class'=>'upd')) ?>
						
						<div class="action_admin">
							<?php echo $this->Html->link('Modifier',array('action'=>'edit','?'=>array('id'=>$v['User']['id'])),array('class'=>'upd')) ?> |
							<?php echo $this->Html->link("Supprimer définitivement",array('action'=>'delete','?'=>array('id'=>$v['User']['id'],'token'=>$this->Session->read('Security.token'))),array('class'=>'del')); ?>			
						</div>
					</td>
					<td>
						<?php echo (!empty($v['User_meta']['first_name'])) ? $v['User_meta']['first_name'] : ' '?>
						<?php echo (!empty($v['User_meta']['last_name'])) ? $v['User_meta']['last_name'] : ' '?>

					</td>
					<td><?php echo $v['User']['email']; ?></td>
					<td><?php echo ucfirst($v['User']['role']); ?></td>
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
		<tfoot style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
			<tr style="color: #21759B">
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
<div>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>	
	</p>
</div>

<?php echo $this->Paginator->numbers(); ?>
