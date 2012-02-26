<div class="page-header">
	<?php echo $this->Html->image('icone-medias.png',array('width'=>50,'height'=>50)); ?>
	<h1 style="display: inline-block;margin-right: 30px">
		<?php echo (!empty($action) && $action == 'add') ? 'Ajouter un média' : 'Editer un média'?>
	</h1>
</div>
<?php if (!empty($action) && $action == 'add'): ?>
	<?php echo $this->Form->create('Media',array('type'=>'file')) ?>
		<?php echo $this->Form->input('file',array('type'=>'file','label'=>false)) ?>
		<?php echo $this->Form->input('user_id',array('label'=>false,'type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
	<?php echo $this->Form->end('Envoyer'); ?>
	<p>
		Taille maximale des fichiers : 2MB. Une fois le fichier envoyé, vous pourrez lui ajouter titre et descriptions
	</p>
<?php else: ?>
	<?php $media = $media['Media']; ?>
	<div>
		<div style="float:left;margin-right: 20px">
			<?php $alt  = (!empty($media['alt'])) ? $media['alt'] : ''?>
			<?php echo $this->Html->image($media['file'],array('width'=>128,'height'=>128,'alt'=>$media,'title'=>$media['name'])); ?>
		</div>
		<div style="float: left">
			<p><span style="color: #000">Nom du fichier :</span><?php echo $media['name']; ?></p>
			<p><span style="color: #000">Type du fichier :</span><?php echo $media['mime_type'] ?></p>
			<p><span style="color: #000">Date de mise en ligne :</span><?php echo $this->date->format($media['created'],'FR') ?></p>
			<p><span style="color: #000">Taille :</span><?php echo $media['size'] ?></p>
		</div>
	</div>
	<div style="clear: both"></div>
		<div style="margin-top: 20px;">
			<?php echo $this->Form->create('Media') ?>
				<?php echo $this->Form->input('name',array('label'=>'Titre : <span style="color:red">*</span>')); ?> <br>
				<?php echo $this->Form->input('alt',array('label'=>'Texte alternatif : ')); ?> <br>
				<?php echo $this->Form->input('content',array('label'=>'Description : ','rows'=>3)); ?> <br>
				<?php echo $this->Form->input('guid',array('label'=>'Emplacement web du fichier','readonly'=>'readonly','style'=>'width:300px')); ?>
				<?php echo $this->Form->input('id'); ?>
				<?php echo $this->Form->input('user_id',array('type'=>'hidden')); ?>
			<?php echo $this->Form->end('Mettre à jour'); ?>
		</div>	
<?php endif ?>
