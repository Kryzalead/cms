
<div class="catalogue">
	<h1><?php echo $type_product == 'robe-de-mariee' ? 'Robe de mariées' : 'Accessoires' ?></h1>
	<?php $class = (!empty($show_filter)) ? 'active' : '' ?>
	<span id="show_filter">
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

					<div class="produit_metas">
						<p><?php echo ' Prix : <span class="prix">'.$v['Product']['price'].' €' ?></span></p>
						<?php if ($type_product == 'robe-de-mariee'): ?>
							<p>Taille : 
							<?php foreach ($v['Taxonomy']['product_taille'] as $k => $v1): ?>
								<?php echo $v1['name'] ?></p>
							<?php endforeach ?>
							<p>Créateur :
							<?php foreach ($v['Taxonomy']['product_creator'] as $k => $v1): ?>
								<?php echo $v1['name']?></p>
							<?php endforeach ?>
						<?php endif ?>	
					</div>
				</div>
			<?php endforeach ?>
		</nav>
	<?php else: ?>
		Aucun produit
	<?php endif ?>
</div>
<?php echo $this->Paginator->numbers() ?>


<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
	
	$('.dynamic-select').bind('change',function(){
	var url = $(this).val();
	window.location = url;
	});

	if($('#show_filter').hasClass('active')){
		$("#filtre_produit").show();
		$('#show_filter_text').html('Masquer les filtres');
		$('#show_filter_arrow').addClass('active_arrow');
	}
	else
		$("#filtre_produit").hide();

	$('#show_filter a').click(function(){
		var a = $('#show_filter_text');
		var active = a.parent('span').attr('class');

		if(active){
			a.html('Afficher les filtres');
			$('#filtre_produit').stop().slideUp(300);
			a.parent('span').removeClass('active');
			$('#show_filter_arrow').removeClass('active_arrow');
		}
		else{
			a.html('Masquer les filtres');
			$('#filtre_produit').stop().slideDown(300);
			a.parent('span').addClass('active');
			$('#show_filter_arrow').addClass('active_arrow');
		}
	});
<?php echo $this->Html->scriptEnd() ?>