<h1><?php echo $this->Html->link('Kryzalead','http://www.kryzalead.fr'); ?></h1>
<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('username',array('label'=>"Identifiant")); ?>
<br />

<?php echo $this->Form->input('password',array('label'=>"Mot de passe")); ?>
<p class="submit">
<?php echo $this->Form->submit('Se connecter',array('div' => false,'class' => 'button-primary'));?>
</p>
<?php echo $this->Form->end(); ?>
<p id="backtoblog">
	<?php echo $this->Html->link("Retour au site",'/',array('title'=>'Vous êtes perdu(e) ?')); ?>
</p>

