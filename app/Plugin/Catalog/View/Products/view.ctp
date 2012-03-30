<h2><?php echo $product['Product']['name'] ?></h2>
<div style="display: inline-block;float: left">
	<?php echo $this->Html->image($product['Product']['url'],array('width'=>160,'height'=>200)) ?>
	<?php foreach ($product['Meta']['attachment'] as $k => $v): ?>
		<?php echo $this->Html->image($v['origin'],array('width'=>60,'height'=>70)) ?>
	<?php endforeach ?>
</div>
<div style="margin-left: 150px;width: 500px">
	<p><?php echo $product['Product']['description'] ?></p>
	<p>Prix : <?php echo $product['Product']['price'] ?>€</p>
	<?php if (!empty($product['Meta']['valeur_achat'])): ?>
		<p>Prix réel : <?php echo $product['Meta']['valeur_achat'] ?>€ soit <?php echo $product['Meta']['reduction'] ?>%</p>
	<?php endif ?>
	<p class="meta">
		<?php if (!empty($product['Taxonomy'])): ?>
			<?php foreach ($product['Taxonomy'] as $k => $v): ?>
				<?php foreach ($v as $k1 => $v1): ?>
					<?php echo $v1['type'] == 'product_taille' ? '<span style="font-weight: bold">Taille : </span>' : '<span style="font-weight: bold">Créateur : </span>' ?>
					<?php if ($v1['type'] == 'product_creator'): ?>
						<?php if (!empty($product['Meta']['product_creator_site'])): ?>
							<?php echo $this->Html->link($v1['name'],$product['Meta']['product_creator_site'],array('title'=>'Voir le site de '.$v1['name'],'target'=>'blank')); ?>
						<?php else: ?>
							<?php echo $v1['name']; ?>
						<?php endif ?>
					<?php else: ?>
						<?php echo $v1['name']; ?>
					<?php endif ?>
					<?php echo "<br />" ?>
				<?php endforeach ?>	
			<?php endforeach ?>
		<?php endif ?>
	</p>
</div>

