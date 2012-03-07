<style type="text/css">
	#sidemenu{list-style-type: none;padding-left: 10px;font-size: 12px;margin: 0 5px;overflow:hidden;background-color: #F9F9F9;border-bottom-color: #DFDFDF;};
	#sidemenu li{display: inline;line-height: 200%;list-style: none;text-align: center;white-space: nowrap;margin: 0;padding: 0;}
	#sidemenu a{color: #21759B;;background-color: #F9F9F9;border-color: #F9F9F9;border-bottom-color: #DFDFDF;padding: 0 7px;display: block;float: left;line-height: 28px;border-top-width: 1px;border-top-style: solid;border-bottom-width: 1px;border-bottom-style: solid;text-decoration: none}
	#sidemenu a:hover{color: #D54E21}
	#sidemenu a.current {background-color: white;border-color: #DFDFDF #DFDFDF white;color: #D54E21;font-weight: normal;padding-left: 6px;padding-right: 6px;-webkit-border-top-left-radius: 3px;-webkit-border-top-right-radius: 3px;border-top-left-radius: 3px;border-top-right-radius: 3px;border-width: 1px;border-style: solid;}

</style>

<?php if ($this->request->action == 'admin_tinymce'): ?>
	<ul id="sidemenu">
		<li>
			<?php if ($current_tabs == 'upload'): ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','upload'),array('class'=>'current')); ?>
			<?php else: ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','upload')); ?>
			<?php endif ?>
		</li>
		<li>
			<?php if ($current_tabs == 'url'): ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','url'),array('class'=>'current')); ?>
			<?php else: ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','url')); ?>
			<?php endif ?>
		<li>
			<?php if ($current_tabs == 'library'): ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','library'),array('class'=>'current')); ?>
			<?php else: ?>
				<?php echo $this->Html->link("Depuis votre ordinateur",array('action'=>'tinymce','controller'=>'medias','library')); ?>
			<?php endif ?>
		</li>
	</ul>
<?php endif ?>

<?php if ($this->request->action != 'admin_tinymce'): ?>
	<h1>
		<?php echo $this->Html->image('icone-medias.png',array('width'=>62,'height'=>62)); ?>
		<?php echo $title_for_layout ?>
	</h1>
<?php endif; ?>			

<?php if ($action == 'add'): ?>
	<div>
		<?php echo $this->Form->create('Media',array('type'=>'file')) ?>
			<?php echo $this->Form->input('name',array('label'=>"Nom du média")); ?>
			<?php echo $this->Form->input('file',array('label'=>false,'type'=>'file')); ?>
			<?php echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->input('type',array('label'=>false,'type'=>'hidden','value'=>'attachment')); ?>
			<?php echo $this->Form->input('status',array('label'=>false,'type'=>'hidden','value'=>'inherit')); ?>
		<?php echo $this->Form->end('Envoyer') ?>
		<p>
			Taille maximale des fichiers : 2MB. Une fois le fichier envoyé, vous pourrez lui ajouter titre et descriptions
		</p>
	</div>
<?php elseif($action == 'upd'): ?>
	<div>
		<div style="float:left;margin-right: 20px">
			<?php echo $this->Html->image($media['Media']['thumbnail'],array('width'=>128,'height'=>128,'alt'=>$media['Media']['alt'],'title'=>$media['Media']['name'])); ?>
		</div>
		<div style="float: left">
			<p><span style="color: #000">Nom du fichier :</span><?php echo $media['Media']['name']; ?></p>
			<p><span style="color: #000">Type du fichier :</span><?php echo $media['Media']['mime_type'] ?></p>
			<p><span style="color: #000">Date de mise en ligne :</span><?php echo $this->date->format($media['Media']['created'],'FR') ?></p>
			<p><span style="color: #000">Taille :</span><?php echo $media['Media']['size'] ?></p>
		</div>
	</div>
	<div style="clear: both"></div>
		<div style="margin-top: 20px;">
			<?php echo $this->Form->create('Media') ?>
				<?php echo $this->Form->input('Media.name',array('label'=>'Titre : <span style="color:red">*</span>')); ?> <br>
				<?php echo $this->Form->input('Media.alt',array('label'=>'Texte alternatif : ')); ?> <br>
				<?php echo $this->Form->input('Media.content',array('label'=>'Description : ','rows'=>3)); ?> <br>
				<?php echo $this->Form->input('Media.guid',array('label'=>'Emplacement web du fichier','readonly'=>'readonly','style'=>'width:300px')); ?>
				<?php echo $this->Form->input('Media.id'); ?>
				<?php echo $this->Form->input('Media.user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->end('Mettre à jour'); ?>
		</div>
<?php elseif($action == 'url'): ?>
	<h3>Insérer un média depuis un autre site</h3>
	<?php echo $this->Form->create('Media') ?>
		<?php echo $this->Form->input('Media.src',array('label'=>"Adresse web : ")); ?>
		<?php echo $this->Form->input('Media.title',array('label'=>"Titre : ")); ?>
		<?php echo $this->Form->input('Media.alt',array('label'=>"Texte alternatif")); ?>
		<?php echo $this->Form->input('Media.type',array('label'=>false,'type'=>'hidden','value'=>'url')); ?>
		<?php echo $this->Form->input('class',array('legend'=>"Alignement : ",'options'=>$alignement,'type'=>'radio')); ?>
	<?php echo $this->Form->end('Insérer') ?>	
<?php endif ?>

