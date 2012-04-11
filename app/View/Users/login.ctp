<div id="pancarte"></div>

<section id="form_connexion">
	<h1><?php echo $this->Html->link('Aux Mariées de Christèle','http://www.aux-mariees-de-christele.fr'); ?></h1>
		<p>
			<span class="couleur_bleu">Vous essayez d'acceder à un espace privé</span>, merci de remplir les champs suivant : <br/>
			(Si vous vous êtes perdu, vous pouvez revenir à l'accueil en cliquant <?php echo $this->Html->link('ICI','/',array('title'=>"Revenir à l'accueil")); ?>)
		</p>

	<div id="login">
		<?php echo $this->Form->create('User',array('id'=>'loginform')); ?>
		<?php echo $this->Session->flash() ?>
		<?php echo $this->Form->input('username',array('label'=>"Identifiant : ", 'id'=>"identifiant")); ?>
		<?php echo $this ->Form->input('password',array('label'=>"Mot de passe : ")) ?>
		<p class="submit"><?php echo $this->Form->submit('Se connecter',array('div' => false));?></p>
		<?php echo $this->Form->end(); ?>
	</div>
</section>