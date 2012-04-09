<div class="catalogue">
	<h1 class="titre_produit"><?php echo $this->Html->link("Robe de mariées",array('action'=>'index','controller'=>'products','type'=>'robe-de-mariee')); ?></h1>

	<nav>
		<?php foreach ($robes as $k => $v): ?>
			<div class="produit">
					<figure>
						<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>'robe-de-mariee','slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
							<figcaption>
								<?php echo $v['Product']['name'];?>
							</figcaption>
					</figure>

				<div class="produit_metas">
					<p><?php echo 'Prix : <span class="prix">'.$v['Product']['price'].' €' ?></span></p>
					<?php foreach ($v['Taxonomy'] as $k1 => $v1) {
						foreach ($v1 as $k2 => $v2) {
							echo $v2['type'] == 'product_taille' ? '<p>Taille : ' : '<p>Créateur : ';
							echo $v2['name'].'</p>';
						}} ?>
				</div>
			</div>
		<?php endforeach ?>
	</nav>
</div>

<div id="catalogue_accessoire" class="catalogue">
	<h1 class="titre_produit"><?php echo $this->Html->link("Accessoires",array('action'=>'index','controller'=>'products','type'=>'accessoire')); ?></h1>

	<nav>
		<?php foreach ($accessoires as $k => $v): ?>
			<div class="produit">
				<figure>
					<?php echo $this->Html->link($this->Html->image($v['Product']['url'],array('width'=>160,'height'=>200)),array('plugin'=>'catalog','action'=>'view','controller'=>'products','type'=>'accessoire','slug'=>$v['Product']['slug'],'id'=>$v['Product']['id']),array('escape'=>false)); ?>
					<figcaption>
						<?php echo $v['Product']['name'];?>
					</figcaption>
				</figure>

				<div class="produit_metas">
					<p><?php echo ' Prix : <span class="prix">'.$v['Product']['price'].' €' ?></span></p>
				</div>
			</div>
		<?php endforeach ?>
	</nav>
</div>