<div id="contain">
	<h1>
	    <?php echo $this->Html->image('icone-posts-add.png',array('width'=>72,'height'=>72)); ?>
	    <?php echo $title_for_layout ?>
	</h1>
	<div id="contain-left" class="bloc_gauche">
		<div>
			<p><?php echo $text_form ?></p>
			<div>
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
	<div id="contain-right" class="bloc_droit">
		<div>
			<table class="liste_table terms">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('Term.name','Nom'); ?></th>
						<th><?php echo $this->Paginator->sort('Term.slug','Identifiant'); ?></th>
					</tr>
				</thead>
				<tbody style="color: gray;">
					<?php foreach ($list_term as $k => $v): ?>
						<tr id="post_<?php echo $v['Term']['id'] ?>">
							<td>
								<?php echo $v['Term']['name'] ?>
								<?php if ($v['Term']['id'] != 1): ?>
									<div class="action_admin">
										<?php echo $this->Html->link('Modifier',array('action'=>'edit','?'=>array('type'=>$v['Term']['type'],'id'=>$v['Term']['id'])),array('class'=>'upd')) ?> |
										<?php echo $this->Html->link('Supprimer définitivement',array('action'=>'delete','?'=>array('type'=>$v['Term']['type'],'id'=>$v['Term']['id'])),array('class'=>'del'),'Voulez vous vraiment supprimer cet élément ?') ?>			
									</div>
								<?php endif ?>
							</td>
							<td><?php echo $v['Term']['slug'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<th><?php echo $this->Paginator->sort('Term.name','Nom'); ?></th>
						<th><?php echo $this->Paginator->sort('Term.slug','Identifiant'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php if ($type_term == 'category'): ?>
			<p style="margin-top: 20px">
				À savoir : supprimer une catégorie ne supprime pas les articles qu’elle contient. Les articles affectés uniquement à la catégorie supprimée seront affectés à celle par défaut  : Non classé.
			</p>
		<?php endif ?>
	</div>
</div>


