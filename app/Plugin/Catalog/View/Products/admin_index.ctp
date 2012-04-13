<h1>
	<?php echo $this->Html->image($icon_for_layout,array('width'=>72,'height'=>72)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php echo $this->Html->link($text_for_add_product,array('action'=>'add','?'=>array('type'=>$type)),array('class'=>'button button-add')) ?>
<?php if (!empty($search)): ?>
	<span>Résultats de recherche pour "<?php echo $search ?>"
<?php endif ?>
<?php echo $this->element('admin-search',array('model'=>'product','options'=>array('type'=>$type),'text_for_submit_search'=>$text_for_submit_search)) ?>
<div>
	<?php echo $this->element('admin-list-top-table',array('model'=>'product','options'=>$data_for_top_table)) ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
</div>
<?php $this->Paginator->options(array('url' => array('?'=>array('type'=>$type)))); ?>
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Form->create('Product',array('url'=>array('controller'=>'products','action'=>'doaction'))) ?>
	<?php echo $this->element('admin-action-groupees',array('list'=>$list_action,'options'=>array('type'=>$type))) ?>
	<div class="cb"></div>
	<div class="content">
		<table class="liste_table produits">
			<thead>
				<tr>
					<th class="colonne_check"><input type="checkbox" class="checkall"></th>
					<th>Photo</th>
					<th><?php echo $this->Paginator->sort('Product.name','Titre'); ?></th>
					<th>Description</th>
					<th><?php echo $this->Paginator->sort('Product.prix','Prix') ?></th>
					<?php if ($type == 'robe-de-mariee'): ?>
						<th>Taille</th>
						<th>Créateur</th>
					<?php endif ?>
					<?php if ($type == 'accessoire'): ?>
						<th>Catégorie</th>
					<?php endif ?>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($products)): ?>
					<?php foreach ($products as $k => $v):?>
						<tr id="product_<?php echo $v['Product']['id'];?>">
							<td class="colonne_check"><?php echo $this->Form->input($v['Product']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
							<td>
								<?php 
								if($type == 'robe-de-mariee'){
									 $width = 85;$height = 120;
								}
								else{
									$width = 100;$height = 80;
								}	
								?>
								<?php echo $this->Html->image($v['Product']['url_min'],array('width'=>$width,'height'=>$height)) ?>
							</td>
							<td>
								<?php if ($v['Product']['status'] == 'trash'): ?>
									<span><?php echo $v['Product']['name'] ?></span>
								<?php elseif($v['Product']['status'] == 'draft' && $status != 'draft'): ?>
									<?php echo $this->Html->link($v['Product']['name'],array('action'=>'edit','?'=>array('id'=>$v['Product']['id'],'action'=>'edit')),array('class'=>'upd')) ?>
									<span> -- Brouillon</span>
								<?php else: ?>
									<?php echo $this->Html->link($v['Product']['name'],array('action'=>'edit','?'=>array('id'=>$v['Product']['id'],'action'=>'edit')),array('class'=>'upd')) ?>
								<?php endif ?>
								<div class="action_admin">
									<?php if ($v['Product']['status'] == 'trash'): ?>
										<?php echo $this->Html->link("Restaurer",array('action'=>'product','?'=>array('action'=>'untrash','id'=>$v['Product']['id'])),array('class'=>'del')); ?>
										<?php echo $this->Html->link("Supprimer définitivement",array('action'=>'product','?'=>array('action'=>'delete','id'=>$v['Product']['id'],'token'=>$this->Session->read('Security.token')))); ?>
									<?php else: ?>
										<?php echo $this->Html->link('Modifier',array('action'=>'edit','?'=>array('id'=>$v['Product']['id'],'action'=>'edit')),array('class'=>'upd')) ?> |
										<?php echo $this->Html->link("Mettre à la corbeille",array('action'=>'product','?'=>array('action'=>'trash','id'=>$v['Product']['id'])),array('class'=>'del')); ?>
										<?php if ($v['Product']['status'] == 'draft'): ?>
											preview
										<?php else: ?>
											<?php echo $this->Html->link("Afficher",array('plugin'=>'catalog','action'=>'view','admin'=>false,'type'=>$v['Product']['product_type'],'slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('target'=>'_blank')); ?>
										<?php endif ?>
									<?php endif ?>
								</div>
							</td>
							<td><?php echo $v['Product']['description'] ?></td>
							<td><?php echo $v['Product']['prix'] == 0 ? 'Non communiqué' : $v['Product']['prix'].' €' ?></td>
							<?php if ($type == 'robe-de-mariee'): ?>
								<td>
									<?php if (!empty($v['Taxonomy']['product_taille'])): ?>
										<?php foreach ($v['Taxonomy']['product_taille'] as $k1 => $v1): ?>
											<?php echo $this->Html->link($v1['name'],array('action'=>'index','controller'=>'products','?'=>array('type'=>$type,'taille'=>$v1['slug']))); ?>
										<?php endforeach ?>
									<?php endif ?>
								</td>
								<td>
									<?php if (!empty($v['Taxonomy']['product_creator'])): ?>
										<?php foreach ($v['Taxonomy']['product_creator'] as $k1 => $v1): ?>
											<?php echo $this->Html->link($v1['name'],array('action'=>'index','controller'=>'products','?'=>array('type'=>$type,'createur'=>$v1['slug']))); ?>
										<?php endforeach ?>
									<?php endif ?>
								</td>	
							<?php endif ?>
							<?php if ($type == 'accessoire'): ?>
								<td>
									<?php if (!empty($v['Taxonomy']['product_category'])): ?>
										<?php foreach ($v['Taxonomy']['product_category'] as $k1 => $v1): ?>
											<?php echo $this->Html->link($v1['name'],array('action'=>'index','controller'=>'products','?'=>array('type'=>$type,'taille'=>$v1['slug']))); ?>
										<?php endforeach ?>
									<?php endif ?>
								</td>	
							<?php endif ?>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
					<td></td>
					<td></td>
					<td>Aucun produits à afficher</td>
					<td></td>
					<td></td>
					<?php if ($type == 'robe-de-mariee'): ?>
						<td></td>
						<td></td>
					<?php endif ?>
					<?php if ($type == 'accessoire'): ?>
						<td></td>
					<?php endif ?>
					</tr>
				<?php endif ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="colonne_check"><input type="checkbox" class="checkall"></th>
					<th>Photo</th>
					<th><?php echo $this->Paginator->sort('Product.name','Titre'); ?></th>
					<th>Description</th>
					<th><?php echo $this->Paginator->sort('Product.prix','Prix') ?></th>
					<?php if ($type == 'robe-de-mariee'): ?>
						<th>Taille</th>
						<th>Créateur</th>
					<?php endif ?>
					<?php if ($type == 'accessoire'): ?>
						<th>Catégorie</th>
					<?php endif ?>
				</tr>
			</tfoot>
		</table>
	</div>
	
<?php echo $this->Form->end(); ?>
<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
<?php echo $this->Paginator->numbers(); ?>