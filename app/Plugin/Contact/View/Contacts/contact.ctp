<style type="text/css">.teletubies{visibility: hidden;}</style>
<?php echo $this->Form->create('Contact') ?>
<?php echo $this->Form->input('Contact.name',array('label'=>"Votre nom : ")); ?>
<?php echo $this->Form->input('Contact.email',array('label'=>"Votre email : ")); ?>
<?php echo $this->Form->input('Contact.message',array('label'=>"Votre message : ",'type'=>'textarea')); ?>
<?php echo $this->Form->input('Contact.site',array('label'=>false,'class'=>'teletubies')); ?>
<?php echo $this->Form->end('Envoyer') ?>