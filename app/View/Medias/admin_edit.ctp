<style type="text/css">
	#sidemenu{list-style-type: none;padding-left: 10px;font-size: 12px;margin: 0 5px;overflow:hidden;background-color: #F9F9F9;border-bottom-color: #DFDFDF;};
	#sidemenu li{display: inline;line-height: 200%;list-style: none;text-align: center;white-space: nowrap;margin: 0;padding: 0;}
	#sidemenu a{color: #21759B;;background-color: #F9F9F9;border-color: #F9F9F9;border-bottom-color: #DFDFDF;padding: 0 7px;display: block;float: left;line-height: 28px;border-top-width: 1px;border-top-style: solid;border-bottom-width: 1px;border-bottom-style: solid;text-decoration: none}
	#sidemenu a:hover{color: #D54E21}
	#sidemenu a.current {background-color: white;border-color: #DFDFDF #DFDFDF white;color: #D54E21;font-weight: normal;padding-left: 6px;padding-right: 6px;-webkit-border-top-left-radius: 3px;-webkit-border-top-right-radius: 3px;border-top-left-radius: 3px;border-top-right-radius: 3px;border-width: 1px;border-style: solid;}
	#form_media{margin-top: 20px}
    #form_media label{display: inline-block;width: 100px}
    #form_media .input{margin-top: 10px}
    #form_media input[type="file"]{margin-left: 100px}
    #form_media input[type="submit"]{margin-left: 100px;margin-top: 10px}
    #form_media p{margin-top: 10px}
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
				<?php echo $this->Html->link("Depuis le web",array('action'=>'tinymce','controller'=>'medias','url'),array('class'=>'current')); ?>
			<?php else: ?>
				<?php echo $this->Html->link("Depuis le web",array('action'=>'tinymce','controller'=>'medias','url')); ?>
			<?php endif ?>
		<li>
			<?php if ($current_tabs == 'library'): ?>
				<?php echo $this->Html->link("Bibliothèque",array('action'=>'tinymce','controller'=>'medias','library'),array('class'=>'current')); ?>
			<?php else: ?>
				<?php echo $this->Html->link("Bibliothèque",array('action'=>'tinymce','controller'=>'medias','library')); ?>
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
	<div id="form_media">
		<?php echo $this->Form->create('Media',array('type'=>'file')) ?>
			<?php echo $this->Form->input('name',array('label'=>"Nom du média")); ?>
			<?php echo $this->Form->input('file',array('label'=>false,'type'=>'file')); ?>
			<?php echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->input('type',array('label'=>false,'type'=>'hidden','value'=>'attachment')); ?>
			<?php echo ($this->request->action == 'admin_tinymce') ? $this->Form->input('method',array('label'=>false,'type'=>'hidden','value'=>'upload')) : '' ?>
			<?php echo $this->Form->input('status',array('label'=>false,'type'=>'hidden','value'=>'inherit')); ?>
		<?php echo $this->Form->end('Envoyer') ?>
		<p>
			Taille maximale des fichiers : 2MB. Une fois le fichier envoyé, vous pourrez lui ajouter titre et descriptions
		</p>
	</div>
<?php elseif($action == 'upd'): ?>
	<div id="media-<?php echo $media['Media']['id'] ?>">
		<div id="media_thumb">
			<?php 
			$dimension = getimagesize ($media['Media']['guid']); 
			$ratio = $dimension[1]/$dimension[0];
			$width = $dimension[0];
			$height = $dimension[1];
			
			$largeur = 128;$hauteur = 128;
			if ($dimension[1] > $hauteur OR $dimension[0] > $largeur) { 
			// X plus grand que Y 
				if ($dimension[1] < $dimension[0]) { 
				     $width = $hauteur; 
				     $y = floor($width * ($dimension[1]/$dimension[0])); 
				} 
				// Y plus grand que X 
				else{ 
				     $height = $largeur; 
				     $width = floor($height * ($dimension[0]/$dimension[1])); 
				} 
			} 
			else { 
			     $width = $dimension[0]; 
			     $height = $dimension[1]; 
			} 
			?>
			<?php echo $this->Html->image($media['Media']['guid'],array('width'=>$width,'height'=>$height,'alt'=>$media['Media']['alt'],'title'=>$media['Media']['name'])); ?>
		</div>
		<div id="media_data">
			<p><span style="color: #000">Nom du fichier :</span><?php echo $media['Media']['name']; ?></p>
			<p><span style="color: #000">Type du fichier :</span><?php echo $media['Media']['mime_type'] ?></p>
			<p><span style="color: #000">Date de mise en ligne :</span><?php echo $this->date->format($media['Media']['created'],'FR') ?></p>
			<p><span style="color: #000">Taille :</span><?php echo $media['Media']['size'] ?></p>
		</div>
	</div>
	<div style="clear: both"></div>
	<div id="form_media">
		<?php echo $this->Form->create('Media') ?>
			<?php echo $this->Form->input('Media.name',array('label'=>'Titre : <span style="color:red">*</span>')); ?> <br>
			<?php echo $this->Form->input('Media.alt',array('label'=>'Texte alternatif : ')); ?> <br>
			<?php echo $this->Form->input('Media.content',array('label'=>'Description : ','rows'=>3)); ?> <br>
			<?php echo $this->Form->input('Media.guid',array('label'=>'Emplacement web du fichier','readonly'=>'readonly')); ?>
			<?php echo $this->Form->input('Media.id'); ?>
			<?php echo $this->Form->input('Media.user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
		<?php echo $this->Form->end('Mettre à jour'); ?>
	</div>
<?php elseif($action == 'url'): ?>
	<div id="form_media">
		<h3>Insérer un média depuis un autre site</h3>
		<?php echo $this->Form->create('Media') ?>
			<?php echo $this->Form->input('Media.src',array('label'=>"Adresse web : ")); ?>
			<?php echo $this->Form->input('Media.title',array('label'=>"Titre : ")); ?>
			<?php echo $this->Form->input('Media.alt',array('label'=>"Texte alternatif")); ?>
			<?php echo $this->Form->input('Media.method',array('label'=>false,'type'=>'hidden','value'=>'url')); ?>
			<?php echo $this->Form->input('class',array('legend'=>"Alignement : ",'options'=>$alignement,'type'=>'radio')); ?>
		<?php echo $this->Form->end('Insérer') ?>
	</div>
<?php endif ?>

