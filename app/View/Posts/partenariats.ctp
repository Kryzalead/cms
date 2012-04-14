<?php $this->set('title_for_layout','Partenariats | '.Configure::read('site_name')) ?>
<section id="partenaires"> <!-- Début bloc -->
	<h1>Les partenaires qui nous font confiances</h1>
		<ul class="cartes_gauche">
			<li>
				<?php echo $this->Html->image('cartes-de-visites/helcoud.jpg') ?>
				<h3>Hel'Coud</h3>
					<ul>
						<li>Hélène Femolant</li>
						<li>Couturière - Retouches et Repassage</li>
						<li>42 grande rue</li>
						<li>17380 Les Nouillers</li>
						<li>Tél. 05 46 90 46 21</li>
						<li>helene_17_v@yahoo.fr</li>
					</ul>
			</li>
			<li>
				<?php echo $this->Html->image('cartes-de-visites/citrus.jpg') ?>
				<h3>Citrus Aurantium</h3>
					<ul>
						<li>Virginie Drahonnet</li>
						<li>Graphiste Freelance</li>
						<li>Port. 06 18 97 20 50</li>
						<li class="site_web"><?php echo $this->Html->link("www.citrus-a.fr",'http://www.citrus-a.fr'); ?></li>
					</ul>
			</li>
			<li class="bordure_droite">
				<?php echo $this->Html->image('cartes-de-visites/bougie-parfumees.jpg') ?>
				<h3>Partylite</h3>
					<ul>
						<li>2 impasse Des lilas</li>
						<li>Puymoreau</li>
						<li>La Benate</li>
						<li>Tél. 05 46 24 67 76</li>
						<li>Port. 06 10 50 00 09</li>
						<li>jehanno.gyslaine@orange.fr</li>
					</ul>
			</li>
			<li>
				<?php echo $this->Html->image('cartes-de-visites/coiffeuse.jpg') ?>
				<h3>Coiffeuse à domicile</h3>
					<ul>
						<li>Elodie</li>
						<li>Saint Savinien et ses alentours</li>
						<li>Du Lundi au Samedi de 9h à 19h</li>
						<li>Port. 06 11 51 21 72</li>
						<li>elodiecoif@gmail.com</li>
					</ul>
			</li>
			<li class="bordure_droite">
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
			<li>
				<?php echo $this->Html->image('cartes-de-visites/wedding.jpg') ?>
				<h3>Wedding Concept</h3>
					<ul>
						<li>Organise votre Mariage et d'Evenements</li>
						<li>Mélanie Pournin</li>
						<li>Port. 06 77 36 94 37</li>
						<li class="site_web"><?php echo $this->Html->link("www.weddingconcept.fr",'http://www.weddingconcept.fr'); ?></li>
					</ul>
			</li>
		</ul>

		<ul class="cartes_droite">
			<li>
				<?php echo $this->Html->image('cartes-de-visites/rev-esthetique.jpg') ?>
				<h3>Rév'esthétique</h3>
					<ul>
						<li>Nadine Nimetz</li>
						<li>Tél. 05 46 90 63 42</li>
						<li>Port. 06 66 71 30 03</li>
					</ul>
			</li>
		</ul>
</section> <!-- fin partenaires -->