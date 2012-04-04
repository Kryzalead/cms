<div id="bgBlanc">
	<section class="bloc">
		<h1>Modèle <?php echo $product['Product']['name'] ?></h1>
		<div class="gallerie"> <!-- Début gallerie -->
			<div class="blanc fiche"> <!-- Début blanc fiche -->
				<div class="produit-gauche">
					<?php echo $this->Html->link($this->Html->image($product['Product']['url_min'],array('alt'=>"Photo ".$product['Product']['name'],'class'=>'photos')),$product['Product']['url'],array('title'=>$product['Product']['name'],'class'=>'product-zoom zoombox zgallery1','escape'=>false)); ?>
					<?php if (!empty($product['Meta']['attachment'])): ?>
						<ul class="miniatures">
							<?php foreach ($product['Meta']['attachment'] as $k => $v): ?>
								<li>
									<?php echo $this->Html->link($this->Html->image($v['thumb']),$this->Html->url('/').$v['origin'],array('escape'=>false)); ?>
								</li>
							<?php endforeach ?>
						</ul>
					<?php endif ?>
				</div>
				<div class="produit-droit">
					
				</div>
			</div>
		</div><!-- Fin gallerie -->
	</section>
	<aside id="image-accessoires">
		<?php echo $this->Html->link($this->Html->image('accessoires.png'),array('action'=>'index','controller'=>'products','type'=>'accessoire'),array('escape'=>false)); ?>
	</aside>
</div>

