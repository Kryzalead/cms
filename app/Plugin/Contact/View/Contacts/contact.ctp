<style type="text/css">.teletubies{visibility: hidden;}</style>
<div id="formContact">
	<?php echo $this->Form->create('Contact',array('class'=>'formulaire')) ?>
		<fieldset>
			<legend>Formulaire de contact</legend>
			<?php echo $this->Form->input('Contact.name',array('label'=>false,'placeholder'=>'Votre nom')); ?>
			<?php echo $this->Form->input('Contact.email',array('label'=>false,'placeholder'=>'Votre @-mail')); ?>
			<?php echo $this->Form->input('Contact.message',array('label'=>false,'placeholder'=>'Votre message','type'=>'textarea','cols'=>3,'rows'=>3)); ?>
			<?php echo $this->Form->input('Contact.site',array('label'=>false,'class'=>'teletubies')); ?>
		</fieldset>
	<?php echo $this->Form->end(array('label'=>false,'div'=>array('class'=>'envoyer'))) ?>
	<div id="reseauxSociaux">
		<!--<a href="#"><img class="sociaux" src="images/reseaux_sociaux/twitter.png" alt="twitter"/></a>-->
		<a href="#"><?php echo $this->Html->image('reseaux_sociaux/facebook.png') ?></a>
	</div>
</div><!--formContact-->

<div id="planGoogle">
	<iframe width="500" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.fr/maps/ms?msa=0&amp;msid=216061209910840039180.0004bbf8dc82272208d9c&amp;ie=UTF8&amp;t=m&amp;ll=45.978594,-0.647163&amp;spn=0.107363,0.171318&amp;z=12&amp;iwloc=0004bbf8ecebc644e9a56&amp;output=embed"></iframe>
</div>

<section id="bandeau"> <!-- Début bandeau -->
	<ul>
		<li class="titre">Aux Mariées de Christèle</li>
		<li>15a, rte de Faillant</li>
		<li>17380 Les Nouillers</li>
		<li>Tél. 06 20 98 53 87</li>
	</ul>
	<?php echo $this->Html->image('etiquette.png',array('width'=>197,'height'=>86,'alt'=>"Étiquette fabrication 100% française")) ?>
	<ul class="horaires">
		<li class="titre">Horaires</li>
		<li>Mardi au vendredi: 14h à19h</li>
		<li>Samedi et lundi: sur rendez-vous</li>
		<li>Dimanche fermé</li>
	</ul>
</section> <!-- Fin bandeau -->