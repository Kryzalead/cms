<style type="text/css">
	div.radio input{opacity: 1;
	-moz-opacity: 1;
	filter:alpha(opacity=1);}
</style>
<h1>
	<?php echo $this->Html->image('icone-config.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<?php echo $this->Form->create('Option') ?>
<?php echo $this->Form->input('Option.site_offline',array('label'=>"Mettre le site en maintenance",'type'=>'checkbox')); ?>
<br>
<?php echo $this->Form->input('Option.content_site_offline',array('label'=>array('style'=>'display: block','text'=>"Contenu du site en maintenance"),'type'=>'textarea')); ?>
<?php echo $this->Form->end('Enregistrer les modifications') ?>