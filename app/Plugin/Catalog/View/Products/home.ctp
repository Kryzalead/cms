<style type="text/css">
	.random{height: 250px;margin-bottom: 15px;padding: 5px;}
	.product{width: 170px;height: 235px;padding: 5px;display: inline-block}
	.product-img{height: 200px}
	.product-meta{height: 25px}
</style>
<h2><?php echo $this->Html->link("Robe de mariées",array('action'=>'index','controller'=>'products','type'=>'robe-de-mariee')); ?></h2>
<div class="random">
	<?php foreach ($robes as $k => $v): ?>
		<div class="product">
			<div class="product-img">
				<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>'robe-de-mariee','slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
			</div>
			<div class="product-meta">
				<?php echo $v['Product']['name'].', prix : '.$v['Product']['price'].'€' ?><br>
				<?php foreach ($v['Taxonomy'] as $k1 => $v1) {
					foreach ($v1 as $k2 => $v2) {
						echo $v2['type'] == 'product_taille' ? 'Taille : ' : 'Créateur : ';
						$order = $v2['type'] == 'product_taille' ? 'taille' : 'createur';
						echo $this->Html->link($v2['name'],array('plugin'=>'catalog','action'=>'index','controller'=>'products','type'=>'robe-de-mariee','order'=>$order,'slug'=>$v2['slug'])); 
						echo "<br>";
					}
				} ?>
			</div>
		</div>
	<?php endforeach ?>
</div>
<h2><?php echo $this->Html->link("Accessoires",array('action'=>'index','controller'=>'products','type'=>'accessoire')); ?></h2>
<div class="random">
	<?php foreach ($accessoires as $k => $v): ?>
		<div class="product">
			<div class="product-img">
				<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>'accessoire','slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
			</div>
			<div class="product-meta">
				<?php echo $v['Product']['name'].', prix : '.$v['Product']['price'].'€' ?>
			</div>
		</div>
	<?php endforeach ?>
</div>
