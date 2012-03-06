<?php if (empty($erreur_taxo)): ?>
	<div id="contain">
	<h1>
	    <?php echo $this->Html->image('icone-posts-add.png',array('width'=>72,'height'=>72)); ?>
	    <?php echo $title_for_layout ?>
	</h1>
	<div id="contain-left" style="width: 35%;float: left;">
		<div>
			<p><?php echo $text_form ?></p>
			<div style="margin-top: 20px">
				<?php echo $this->Form->create('Term') ?>
				<?php echo $this->Form->input('Term.name',array('label'=>"Nom : ")); ?>
				<p>Ce nom est utilisé un peu partout sur votre site.</p>
				<?php echo $this->Form->input('Term.slug',array('label'=>"Identifiant : ")); ?>
				<p>L’identifiant est la version normalisée du nom. Il ne contient généralement que des lettres minuscules non accentuées, des chiffres et des traits d’union.</p>
				<?php echo $this->Form->input('Term.id',array('label'=>false)); ?>
				<?php echo $this->Form->input('Term.type',array('label'=>false,'type'=>'hidden','value'=>$type_term)); ?>
				<?php echo $this->Form->submit($text_for_submit); ?>
				<?php echo $this->Form->end(); ?>
			</div>				
		</div>
	</div>
	<div id="contain-right" style="float: left;margin-left: 5%;width: 55%;">
		<div>
			<table class="classicTable posts" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;display: table;border-spacing: 2px;border-color: gray;margin-top: 10px">
				<thead style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
					<tr style="color: #21759B">
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('Term.name','Nom'); ?></th>
						<th><?php echo $this->Paginator->sort('Term.slug','Identifiant'); ?></th>
					</tr>
				</thead>
				<tbody style="color: gray;">
					<?php foreach ($list_term as $k => $v): ?>
						<tr id="post_<?php echo $v['Term']['id'] ?>">
							<td><?php echo $this->Form->input($v['Term']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
							<td>
								<?php echo $v['Term']['name'] ?>
								<?php if ($v['Term']['id'] != 1): ?>
									<div class="action_admin">
										<?php echo $this->Html->link('Modifier',array('action'=>'edit',$v['Term']['type'],$v['Term']['id']),array('class'=>'upd')) ?> |
										<?php echo $this->Html->link('Supprimer définitivement',array('action'=>'delete',$v['Term']['type'],$v['Term']['id']),array('class'=>'del'),'Voulez vous vraiment supprimer cet élément ?') ?>			
									</div>
								<?php endif ?>
							</td>
							<td><?php echo $v['Term']['slug'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
					<tr style="color: #21759B">
						<th><input type="checkbox" class="checkall"></th>
						<th><?php echo $this->Paginator->sort('Term.name','Nom'); ?></th>
						<th><?php echo $this->Paginator->sort('Term.slug','Identifiant'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<p style="margin-top: 20px">
			À savoir : supprimer une catégorie ne supprime pas les articles qu’elle contient. Les articles affectés uniquement à la catégorie supprimée seront affectés à celle par défaut  : Non classé.
		</p>
	</div>
</div>
<?php else: ?>
	<?php echo $erreur_taxo ?>
<?php endif; ?>


