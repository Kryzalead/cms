<section class="bloc">
	<h1><?php echo $product['Product']['product_type'] == 'robe-de-mariee' ? 'Modèle' : ''?> <?php echo $product['Product']['name'] ?></h1>
	<div class="gallerie"> <!-- Début gallerie -->
		<div class="blanc fiche"> <!-- Début blanc fiche -->
			<div class="produit-gauche">
				<?php 
					$dimension = getimagesize ($product['Product']['url']); 
					$largeur = 375;$hauteur = 275;
					if ($dimension[1] > $hauteur OR $dimension[0] > $largeur) { 
					// X plus grand que Y 
						if ($dimension[1] < $dimension[0]) { 
						     $width = $hauteur; 
						     $height = floor($width * ($dimension[1]/$dimension[0])); 
						} 
						// Y plus grand que X 
						else{ 
						     $height = $largeur; 
						     $width = floor($height * ($dimension[0]/$dimension[1])); 
						} 
					} 
					else { 
					     $width = $dimension[0]; 
					     $height = $dimension[1]; 
					} 
				?>
				<?php echo $this->Html->link($this->Html->image($product['Product']['url'],array('width'=>$width,'height'=>$height,'alt'=>"Photo ".$product['Product']['name'],'class'=>'photos')),$product['Product']['url'],array('title'=>$product['Product']['name'],'class'=>'product-zoom zoombox zgallery1','escape'=>false)); ?>
				<?php if (!empty($product['Product_attachement'])): ?>
					<ul class="miniatures">
						<?php foreach ($product['Product_attachement'] as $k => $v): ?>
							<li>
								<?php echo $this->Html->link($this->Html->image($v['url_min']),'/img/'.$v['url'],array('class'=>'product-zoom zoombox zgallery1','escape'=>false,'title'=>$v['name'])); ?>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
				<div class="cb"></div>
				<div class="produit-partage"> <!-- Début Produit-partage -->
					<h4>Partager</h4>
						<a href="#" title="Partager sur Facebook" target="_tab">
							<?php echo $this->Html->image('reseaux_sociaux/facebook-icone.png') ?>
						</a>
						<a href="#" title="Partager sur Twitter" target="_tab">
							<?php echo $this->Html->image('reseaux_sociaux/twitter-icone.png') ?>
						</a>
						<g:plusone size="standard" href="<?php echo $this->Html->url('/') ?>"></g:plusone><!-- bouton google +1 -->
				</div> <!-- Fin Produit-partage -->
			</div>
			<div class="produit-droit"><!-- Début produit-droit -->
				<?php if ($product['Product']['prix'] != 0): ?>
					<p class="prix"><?php echo $product['Product']['prix']?> €</p>
				<?php endif ?>
				
				<?php if (!empty($product['Meta']['valeur_achat'])): ?>
					<p class="ancien-prix"><?php echo $product['Meta']['valeur_achat'] ?> €</p>
					<span class="currency" style="display:none;">EUR</span>
					<div class="promo"> <!-- Début promo -->
						<p class="pourcentage-reduction"><?php echo $product['Meta']['reduction'] ?> % de réduction</p>
					</div> <!-- Fin promo -->
				<?php endif ?>
				<div class="description"> <!-- Début description -->
					<ul>
						<li class="titre">Modèle</li>
						<?php if (!empty($product['Meta']['product_creator_site'])): ?>
							<li>Créateur : 
							<?php echo $this->Html->link($product['Meta']['product_creator'],$product['Meta']['product_creator_site'],array('title'=>"Voir le site de ".$product['Meta']['product_creator'])); ?>
						<?php elseif(!empty($product['Meta']['product_creator'])): ?>
							<li>Créateur : 
							<?php echo $product['Meta']['product_creator'] ?>
							</li>
						<?php endif ?>
						<li><?php echo $product['Product']['product_type'] == 'robe-de-mariee'  ? 'Nom de la robe : ' : 'Accessoire : ';?><?php echo $product['Product']['name'] ?></li>
					</ul>
					<?php if (!empty($product['Product']['description'])): ?>
					<ul>
						
						<li class="titre">Description</li>
						<li><?php echo $product['Product']['description'] ?></li>
						<?php if (!empty($product['Taxonomy']['product_taille'])): ?>
							<li><span class="gras">Taille :</span> 
								<?php sort($product['Taxonomy']['product_taille']) ?>
								<?php foreach ($product['Taxonomy']['product_taille'] as $k => $v): ?>
									<?php echo $v['name'].' '; ?>
								<?php endforeach ?>
							</li>
						<?php endif ?>
					</ul>
					<?php endif ?>
				</div>
			</div><!-- Fin produit-droit -->
		</div>
	</div><!-- Fin gallerie -->
</section>
<aside id="image-accessoires">
	<?php echo $this->Html->link($this->Html->image('accessoires.png'),array('action'=>'index','controller'=>'products','type'=>'accessoire'),array('escape'=>false)); ?>
</aside>
<?php echo $this->Html->script('zoombox/zoombox',array('inline'=>false)); ?>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
		{lang: 'fr'}
	</script><!-- script google +1 -->
<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
	$(function(){
		$('a.zoombox').zoombox();
	});
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->Html->css('zoombox.css') ?>


