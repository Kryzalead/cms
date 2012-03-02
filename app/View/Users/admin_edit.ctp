<div class="page-header">
	<h1>
		<?php echo $this->Html->image('icone-users-add.png',array('width'=>62,'height'=>62)); ?>
		<?php echo $title_for_layout ?>
	</h1>
</div>
<?php echo $this->Form->create('User') ?>
	<?php echo $this->Form->input('User.username',array('label'=>"Identifiant : ")); ?>
	<?php echo $this->Form->input('User.email',array('label'=>"E-mail : ")); ?>
	<?php echo $this->Form->input('User_meta.last_name',array('label'=>"Nom : ")); ?>
	<?php echo $this->Form->input('User_meta.first_name',array('label'=>"Prénom : ")); ?>
	<?php echo $this->Form->input('User.siteweb',array('label'=>"Site internet ")); ?>
	<br />
	<p style="font-style: italic;">
		Conseil : votre mot de passe devrait faire au moins 7 caractères de long. Pour le rendre plus sûr, utilisez un mélange de majuscules, de minuscules, de chiffres et de symboles comme ! " ? $ % ^ & ).
	</p>
	<?php echo $this->Form->input('User.password',array('label'=>"Mot de passe")); ?>
	<?php echo $this->Form->input('User.passwordconfirm',array('label'=>"Confirmation : ",'type'=>'password')); ?>
	<div id="pass_strength_result" style="background-color: #EEE;border-color: #DDD!important;border-style: solid;border-width: 1px;margin: 13px 5px 5px 1px;text-align: center;width: 200px;line-height: 20px;height: 20px">
		<span id="strength_text">Indice de sécurité</span>
		<div id="strength_bar" style="border: 1px solid white; width: 0px;";></div>
	</div>
	<?php echo $this->Form->input('User.role',array('label'=>"Role : ")); ?>
	<?php echo $this->Form->input('User.id'); ?>
<?php echo $this->Form->end($texte_submit); ?>
<?php echo $this->Html->script('verif_mdp.js',array('inline'=>false)) ?>