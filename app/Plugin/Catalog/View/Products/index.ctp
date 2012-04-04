<style type="text/css">
	.product{width: 170px;height: 235px;padding: 5px;display: inline-block}
	.product-img{height: 200px}
	.product-meta{height: 25px}
	#product_filter{height: 50px}
</style>
<h2><?php echo $type_product == 'robe-de-mariee' ? 'Robe de mariées' : 'Accessoires' ?></h2>
<div>
	<?php $class = (!empty($show_filter)) ? 'active' : '' ?>
	<?php echo $this->Html->link("Afficher les filtres",'#',array('id'=>'show_filter','class'=>$class)); ?>
	<div id="product_filter">
		<span style="float: left">Filter par :</span>
		<?php echo $this->Form->create('Product') ?>
		<?php if ($type_product == 'robe-de-mariee'): ?>
			<?php echo $this->Form->input('Product.taille',array('label'=>false,'type'=>'select','options'=>$list_taille,'class'=>'dynamic-select','style'=>'float: left')); ?>
			<?php echo $this->Form->input('Product.creator',array('label'=>false,'type'=>'select','options'=>$list_creator,'class'=>'dynamic-select')); ?>
		<?php elseif($type_product == 'accessoire'): ?>
			<?php echo $this->Form->input('Product.categorie',array('label'=>false,'type'=>'select','options'=>$list_category,'class'=>'dynamic-select','style'=>'float: left')); ?>
		<?php endif ?>
	<?php echo $this->Form->end() ?>
	</div>
	<div style="clear: both"></div>
	<?php if (!empty($products)): ?>	
		<?php foreach ($products as $k => $v): ?>
			<div class="product">
				<div class="product-img">
					<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>$type_product,'slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
				</div>
				<div class="product-meta">
					<?php echo $v['Product']['name'].', prix : '.$v['Product']['price'].'€' ?>
					<?php if ($type_product == 'robe-de-mariee'): ?>
						<br>Taille : 
						<?php foreach ($v['Taxonomy']['product_taille'] as $k => $v1): ?>
							<?php echo $v1['name'] ?>
						<?php endforeach ?>
						<br>Créateur :
						<?php foreach ($v['Taxonomy']['product_creator'] as $k => $v1): ?>
							<?php echo $v1['name']?>
						<?php endforeach ?>
					<?php endif ?>	
				</div>
			</div>
		<?php endforeach ?>
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
	$("#product_filter").show();
	$('#show_filter').html('Masquer les filtres');
}
else
	$("#product_filter").hide();

$('#show_filter').click(function(){
	var a = $(this);
	var active = a.attr('class');

	if(active){
		a.html('Afficher les filtres');
		$('#product_filter').stop().slideUp(300);
		a.removeClass('active');
	}
	else{
		a.html('Masquer les filtres');
		$('#product_filter').stop().slideDown(300);
		a.addClass('active');
	}
});
<?php echo $this->Html->scriptEnd() ?>