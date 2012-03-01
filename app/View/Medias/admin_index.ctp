<h1>
	<?php echo $this->Html->image('icone-medias.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php echo $this->Html->link('Ajouter un média',array('action'=>'edit'),array('class'=>'btn primary')) ?>
<?php if (!empty($this->request->query['search'])): ?>
	<span style="color: #777">Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
<?php endif ?>

<div class="search-box">
	<?php echo $this->Form->create('Media',array('type'=>'get')); ?>
	<?php echo $this->Form->input('search',array('label'=>'')) ?>
	<?php echo $this->Form->end('Rechercher dans les medias'); ?>
</div>
<div class="list-type-posts">
	<p class="list">
		<?php echo $this->Html->link("Tous",array('action'=>'index')); ?>
		(<span class="total"><?php echo $total ?></span>)
		<?php if ($totalImages != 0): ?>
			| <?php echo $this->Html->link("Images",array('action'=>'index','images')); ?>
			(<span class="totalImages"><?php echo $totalImages ?></span>) 	
		<?php endif ?> 
		<?php if ($totalVideos != 0): ?>
			| <?php echo $this->Html->link("Vidéos",array('action'=>'index','videos')); ?>
			(<span class="totalVideos"><?php echo $totalVideos ?></span>)	
		<?php endif ?>
	</p>
	<p class="totalElement">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>

<table class="classicTable posts" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;display: table;border-spacing: 2px;border-color: gray;margin-top: 10px">
	<thead style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
		<tr style="color: #21759B">
			<th><input type="checkbox"></th>
			<th>Fichier</th>
			<th>Auteur</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody style="color: gray;">
		<?php if (!empty($medias)): ?>
			<?php foreach ($medias as $k => $v):?>
			<tr id="post_<?php echo $v['Media']['id'] ?>">
				<td><?php echo $this->Form->input($v['Media']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
				<td>
					<div style="float: left;width: 70px;">
						<?php $alt = !empty($v['Media']['alt']) ? $v['Media']['alt'] : ''; ?>
						<?php echo $this->Html->image($v['Media']['thumbnail'],array('title'=>$v['Media']['name'],'alt'=>$alt,'width'=>60,'height'=>60)) ?>
					</div>
					<div>
						<?php echo $this->Html->link($v['Media']['name'],array('action'=>'edit',$v['Media']['id'])); ?>
						<p style="margin-top: 5px;color: #333;margin-bottom: 5px">
							<?php echo strtoupper(substr($v['Media']['thumbnail'],-3,3));?>
						</p>
						<div class="action_admin">
							<?php echo $this->Html->link("Modifier",array('action'=>'edit',$v['Media']['id']),array('class'=>'upd')); ?> |
							<?php echo $this->Html->link("Supprimer définitivement",array('action'=>'delete',$v['Media']['id'],$this->Session->read('Security.token')),array('class'=>'del'),'Voulez vous vraiment supprimer ce contenu ?'); ?>
						</div>
					</div>
				</td>
				<td><?php echo $v['User']['username'] ?></td>
				<td><?php echo $this->date->format($v['Media']['created'],'FR') ?></td>
			</tr>
		<?php endforeach ?>
		<?php else: ?>
			<td></td>
			<td>Aucun média à afficher</td>
			<td></td>
			<td></td>
			<td></td>
		<?php endif ?>
	</tbody>
	<tfoot style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
		<tr style="color: #21759B">
			<th><input type="checkbox"></th>
			<th>Fichier</th>
			<th>Auteur</th>
			<th>Date</th>
		</tr>
	</tfoot>
</table>
<div style="margin-top: 5px">
	<p style="text-align: right">
		<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
		<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
	</p>
</div>
<?php echo $this->Paginator->numbers(); ?>