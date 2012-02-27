<h1>
	<?php echo $this->Html->image('icone-users.png',array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
	<?php echo $this->Html->link('Ajouter un utilisateur',array('action'=>'edit'),array('class'=>'btn primary')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span style="color: #777">Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create('User',array('type'=>'get')); ?>
	<?php echo $this->Form->input('search',array('label'=>'')) ?>
	<?php echo $this->Form->end('Rechercher dans les utilisateurs'); ?>
</div>
<div>
	<p style="display: inline-block;float: left">
		<?php echo $this->Html->link("Tous",array('action'=>'index','all')); ?>
		(<span class="total"><?php echo $total ?></span>)
		<?php if ($totalAdmin != 0): ?>
			| <?php echo $this->Html->link("Administateur",array('action'=>'index','admin')); ?>
			(<span class="total"><?php echo $totalAdmin ?></span>)
		<?php endif ?>
		<?php if ($totalUser != 0): ?>
			| <?php echo $this->Html->link("Utilisateurs",array('action'=>'index','user')); ?>
			(<span class="total"><?php echo $totalUser ?></span>)
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
					<?php echo $this->Html->link(ucfirst($v['User']['username']),array('action'=>'edit',$v['User']['id']),array('class'=>'upd')) ?>
					
					<div class="action_admin">
						<?php echo $this->Html->link('Modifier',array('action'=>'edit',$v['User']['id']),array('class'=>'upd')) ?> |
						<?php echo $this->Form->postLink('Supprimer définitivement',array('action'=>'delete',$v['User']['id']),array('class'=>'del'),'Voulez vous vraiment supprimer cet utilisateur ?') ?>			
					</div>
				</td>
				<td>
					<?php echo (!empty($v['User_meta']['first_name'])) ? $v['User_meta']['first_name'] : ' '?>
					<?php echo (!empty($v['User_meta']['last_name'])) ? $v['User_meta']['last_name'] : ' '?>

				</td>
				<td><?php echo $v['User']['email']; ?></td>
				<td><?php echo ucfirst($v['User']['role']); ?></td>
				<td>
					<?php echo ($v['User']['page_count'] != 0) ? $this->Html->link($v['User']['page_count'],array('action'=>'author','controller'=>'pages',$v['User']['username'])) : 0; ?>
				</td>
				<td>
					<?php echo ($v['User']['post_count'] != 0) ? $this->Html->link($v['User']['post_count'],array('action'=>'author','controller'=>'posts',$v['User']['username'])) : 0; ?>
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
			<th><input type="checkbox"></th>
			<th><?php echo $this->Paginator->sort('User.username','Identifiant'); ?></th>
			<th>Nom</th>
			<th><?php echo $this->Paginator->sort('User.email','E-mail'); ?></th>
			<th>Rôle</th>
			<th>Pages</th>
			<th>Articles</th>
		</tr>
	</tfoot>
</table>
<div>
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>	
	</p>
</div>

<?php echo $this->Paginator->numbers(); ?>
