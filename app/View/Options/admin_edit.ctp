<h1>
	<?php echo $this->Html->image('icone-config.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<div>
	<?php echo $this->Form->create('Options') ?>
		<?php if ($action == 'general'): ?>
			<?php echo $this->Form->input('Option.site_name',array('label'=>"Titre du site")); ?>
			<?php echo $this->Form->input('Option.slogan',array('label'=>"Slogan du site")); ?>
			<?php echo $this->Form->input('Option.admin_email',array('label'=>"Adresse de messagerie")); ?>
			<p>Cette adresse n’est utilisée que pour l’administration du site ; par exemple, la notification de l’inscription d’un nouvel utilisateur.</p>
			<?php echo $this->Form->input('Option.default_role',array('label'=>'Role par defaut de tout nouvel utilisateur','type'=>'select','options'=>$list_user_roles)) ?>
		<?php elseif($action == 'write'): ?>
			
		<?php endif ?>
	<?php echo $this->Form->end('Enregistrer les modifications') ?>
</div>