<?php $this->set('title_for_layout','Partenariats | '.Configure::read('site_name')) ?>
<section id="partenaires"> <!-- Début bloc -->
<h1>Les partenaires qui nous font confiances</h1>
	<ul class="ligne1">
		<li>
			<?php echo $this->Html->image('cartes-de-visites/helcoud.jpg') ?>
			<h3>Hel'Coud</h3>
			<ul>
				<li>Couturière</li>
				<li>Retouche, Ourlet, Confection</li>
				<li>17380 - Les Nouillers</li>
				<li>42, grande rue</li>
				<li>Tél. 05 46 90 46 21</li>
			</ul>
		</li>
		<li>
			<?php echo $this->Html->image('cartes-de-visites/citrus.jpg') ?>
			<h3>Citrus Aurantium</h3>
			<ul>
				<li>Virginie Drahonnet - Gafiste Freelance</li>
				<li>Inscrite a la Maison des Artistes</li>
				<li>Carte de visite, Affiche, etc</li>
				<li>42, grande rue</li>
				<li>Port. 06.18.97.20.50</li>
				<li class="site_web"><?php echo $this->Html->link("www.citrus-a.fr",'http://www.citrus-a.fr'); ?></li>
			</ul>
		</li>
		<li>
			<?php echo $this->Html->image('cartes-de-visites/la-roseraie-de-la-devise.jpg') ?>
			
			<h3>La Roseraie de la Devise</h3>
			<ul>
				<li>Le spécialiste de la rose</li>
				<li>Décoration de voiture de salle</li>
				<li>Bouquet, Gerbe, Pétales, ect</li>
				<li>1770 Surgères</li>
				<li>Route de Tonnay-Boutonne</li>
				<li>Tél. 05 46 68 87 18</li>
				<li class="site_web"><?php echo $this->Html->link("www.roseraiedeladevise.com",'http://www.roseraiedeladevise.com'); ?></li>
			</ul>
		</li>
	</ul>
</section> <!-- fin partenaires -->