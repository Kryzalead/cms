
<div class="catalogue">
	<h1><?php echo $type_product == 'robe-de-mariee' ? 'Robe de mariées' : 'Accessoires' ?></h1>
	<?php $class = (!empty($show_filter)) ? 'class="active"' : '' ?>
	<span id="show_filter" <?php echo $class ?>>
		<?php echo $this->Html->link("Afficher les filtres",'#',array('id'=>'show_filter_text','class'=>$class,'style'=>'color: black')); ?>
		<a href="#" class="toggle" id="show_filter_arrow"></a>
	</span>
	<div id="filtre_produit">
		<span style="float: left">Filter par :</span>
		<?php echo $this->Form->create('Product') ?>
		<?php if ($type_product == 'robe-de-mariee'): ?>
			<?php echo $this->Form->input('Product.taille',array('label'=>false,'type'=>'select','options'=>$list_taille,'class'=>'dynamic-select')); ?>
			<?php echo $this->Form->input('Product.creator',array('label'=>false,'type'=>'select','options'=>$list_creator,'class'=>'dynamic-select')); ?>
		<?php elseif($type_product == 'accessoire'): ?>
			<?php echo $this->Form->input('Product.categorie',array('label'=>false,'type'=>'select','options'=>$list_category,'class'=>'dynamic-select')); ?>
		<?php endif ?>
	<?php echo $this->Form->end() ?>
	</div>
	<div class="cb"></div>
	<?php if (!empty($products)): ?>
		<nav>
			<?php foreach ($products as $k => $v): ?>
				<div class="produit">
					<figure>
						<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>$type_product,'slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
							<figcaption>
								<?php echo $v['Product']['name'];?>
							</figcaption>
					</figure>
					<p><?php echo $v['Product']['prix'] == 0 ? 'Non communiqué' : 'Prix : <span class="prix">'.$v['Product']['prix'].' €</span>' ?></p>
					<?php if (!empty($v['Taxonomy'])): ?>
						<div class="produit_metas">
							<?php if ($type_product == 'robe-de-mariee'): ?>
								<?php if (!empty($v['Taxonomy']['product_taille'])): ?>
									<p>Taille : 
									<?php sort($v['Taxonomy']['product_taille']) ?>
									<?php foreach ($v['Taxonomy']['product_taille'] as $k => $v1): ?>
										<?php echo $v1['name'] ?>
									<?php endforeach ?>
									</p>
								<?php endif ?>
								<?php if (!empty($v['Taxonomy']['product_creator'])): ?>
									<p>Créateur :
									<?php foreach ($v['Taxonomy']['product_creator'] as $k => $v1): ?>
										<?php echo $v1['name']?>
									<?php endforeach ?>
									</p>
								<?php endif; ?>
							<?php endif ?>	
						</div>
					<?php endif ?>
				</div>
			<?php endforeach ?>
		</nav>
	<?php else: ?>
		Aucun produit
	<?php endif ?>
</div>
<div id="pagination">
	<ul>
		<?php $this->Paginator->options(array('url'=>array('controller'=>'products','action'=>'index','type'=>$type_product,'page'=>$this->params['page']))) ; ?>
		<?php echo $this->Paginator->numbers(array('separator'=>false,'tag'=>'li')) ?>
	</ul>
</div>

