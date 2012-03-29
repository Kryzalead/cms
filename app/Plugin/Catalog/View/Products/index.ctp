<style type="text/css">
	.product{width: 170px;height: 235px;padding: 5px;display: inline-block}
	.product-img{height: 200px}
	.product-meta{height: 25px}
</style>
<h2><?php echo $type_product == 'robe-de-mariee' ? 'Robe de mariées' : 'Accessoires' ?></h2>
<div>
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
							<?php echo $this->Html->link($v1['name'],array('plugin'=>'catalog','action'=>'index','controller'=>'products','type'=>$type_product,'order'=>'taille','slug'=>$v1['slug'])); ?>
						<?php endforeach ?>
						<br>Créateur :
						<?php foreach ($v['Taxonomy']['product_creator'] as $k => $v1): ?>
							<?php echo $this->Html->link($v1['name'],array('plugin'=>'catalog','action'=>'index','controller'=>'products','type'=>$type_product,'order'=>'createur','slug'=>$v1['slug'])); ?>
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