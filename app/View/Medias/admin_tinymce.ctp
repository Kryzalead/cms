<div id="ConteneurPrincipal" class="ui-widget-content">
	<ul>
		<li <?php echo ($tabs == 'upload') ? 'class="ui-tabs-selected"' : ''; ?>><a href="#upload">Depuis votre ordinateur</a></li>
		<li <?php echo ($tabs == 'url') ? 'class="ui-tabs-selected"' : ''; ?>><a href="#url">Depuis le web</a></li>
		<li <?php echo ($tabs == 'library') ? 'class="ui-tabs-selected"' : ''; ?>><a href="#library">Bibilothèque</a></li>
	</ul>
	<div id="upload">
		<h3>Ajouter un fichier média depuis votre ordinateur</h3>
		<?php echo $this->Form->create('Media',array('type'=>'file')) ?>
			<?php echo $this->Form->input('file',array('type'=>'file','label'=>false)) ?>
			<?php echo $this->Form->input('user_id',array('label'=>false,'type'=>'hidden','value'=>$this->Session->read('Auth.User.id'))); ?>
			<?php echo $this->Form->input('type',array('type'=>'hidden','value'=>'upload')) ?>
		<?php echo $this->Form->end('Envoyer'); ?>
		<p>
			Taille maximale des fichiers : 2MB. Une fois le fichier envoyé, vous pourrez lui ajouter titre et descriptions
		</p>
	</div> 

   	<div id="url">  
   		<h3>Insérer un média depuis un autre site</h3>
   		<?php 
   			if(!empty($query)){
   				$src = $query['src'];
   				$title = !empty($query['title']) ? $query['title'] : '';
   				$alt = !empty($query['alt']) ? $query['alt'] : '';
   				$class = !empty($query['class']) ? $query['class'] : 'alignLeft';
   			}
   			else{
   				$src = $title = $alt = '';
   				$class = 'alignLeft';
   			}
   		 ?>
   		<?php echo $this->Form->create('Media'); ?>
   			<?php echo $this->Form->input('src',array('label'=>'Adresse web : ','value'=>$src)) ?>
   			<?php echo $this->Form->input('title',array('label'=>'Titre : ','value'=>$title)) ?>
   			<?php echo $this->Form->input('alt',array('label'=>'Texte alternatif : ','value'=>$alt)) ?>
   			<?php echo $this->Form->input('class',array(
	   			'legend'=>'Alignement : ',
	   			'options'=>array(
		   			'alignLeft'		=>	'Gauche',
		   			'alignCenter'	=>	'Centrer',
		   			'alignRight'	=>	'Droite'
		   		),
		   		'type'=>'radio',
		   		'value'=>$class
		   		)); ?>
		   	<?php echo $this->Form->input('type',array('type'=>'hidden','value'=>'url')) ?>	
   		<?php echo $this->Form->end('Insérer') ?>
  	</div>
  	<div id="library">  
   		<p>
			<?php echo $this->Html->link("Tous",array('action'=>'tinymce','library','all')); ?>
			(<span class="total"><?php echo $totalImages ?></span>)
			<?php if ($totalImages > 0): ?>
			| <?php echo $this->Html->link("Images",array('action'=>'tinymce','library','images')); ?>
			(<span class="total"><?php echo $totalImages ?></span>)
			<?php endif ?>
		</p>
		
		<div class="medias_tinymce" style="width: 650px;margin-top: 30px;">
			<?php foreach ($medias as $k => $v): ?>
				<div id="media_"<?php echo $v['Media']['id'];?> style="border: 1px solid #DFDFDF;">
					<?php $alt  = (!empty($v['Media']['alt'])) ? $v['Media']['alt'] : ''?>
					<div class="media_thumbnail">
						<?php echo $this->Html->image($v['Media']['file'],array('width'=>60,'height'=>60,'style'=>'display: inline-block','title'=>$v['Media']['name'])) ?>
						<div>
							<?php echo $v['Media']['name']; ?>
						</div>
						<a href="#" class="toggle on">Afficher</a>
						<a href="#" class="toggle off" style="display: none">Masquer</a>
						<div class="media_form" style="display: none">
							<div style="float:left;margin-right: 20px">
							<?php echo $this->Html->image($v['Media']['file'],array('width'=>128,'height'=>128,'alt'=>$alt,'title'=>$v['Media']['name'])); ?>
							</div>
							<div style="float: left">
								<p><span style="color: #000">Nom du fichier :</span><?php echo $v['Media']['name']; ?></p>
								<p><span style="color: #000">Type du fichier :</span><?php echo $v['Media']['mime_type'] ?></p>
								<p><span style="color: #000">Date de mise en ligne :</span><?php echo $this->date->format($v['Media']['created'],'FR') ?></p>
								<p><span style="color: #000">Taille :</span><?php echo $v['Media']['size'] ?></p>
							</div>
							<div style="clear: both"></div>
							<?php echo $this->Form->create('Media'); ?>
				   			<?php echo $this->Form->input('title',array('label'=>'Titre : ','value'=>$v['Media']['name'])) ?>
				   			<?php echo $this->Form->input('alt',array('label'=>'Texte alternatif : ','value'=>$alt)) ?>
				   			<?php echo $this->Form->input('class',array(
					   			'legend'=>'Alignement : ',
					   			'options'=>array(
						   			'alignLeft'		=>	'Gauche',
						   			'alignCenter'	=>	'Centrer',
						   			'alignRight'	=>	'Droite'
						   		),
						   		'type'=>'radio'
						   		)); ?>
						   		<?php echo $this->Form->input('size',array(
					   			'legend'=>'Taille : ',
					   			'options'=>array(
						   			'thumbnail'		=>	'Petite',
						   			'medium'		=>	'Moyenne',
						   			'large'			=>	'Grande'
						   		),
						   		'type'=>'radio'
						   		)); ?>
						   	<?php echo $this->Form->input('type',array('type'=>'hidden','value'=>'library')) ?>
						   	<?php echo $this->Form->input('guid',array('value'=>$v['Media']['guid'],'type'=>'hidden')) ?>
				   		<?php echo $this->Form->end('Insérer') ?>	
						</div>
					</div>
				</div>
				<div style="clear: both"></div>
			<?php endforeach ?>
		</div>
  	</div>
</div>  	
<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
jQuery(function($){
// On transforme notre conteneur principal en un conteneur d'onglets
  $("#ConteneurPrincipal").tabs();
  	$('.on').click(function(){
  		object = $(this);
  		$(object).siblings('img').fadeOut(200);
  		$(object).fadeOut(200);
  		$(object).next('.off').fadeIn(250);
  		$(this).siblings('.media_form').fadeIn(250);
  	});
  	
  	$('.off').click(function(){
  		object = $(this);
  		$(object).fadeOut(200);
  		$(object).prev('.on').fadeIn(250);
  		$(object).siblings('img').fadeIn(250);
  		$(this).siblings('.media_form').stop().fadeOut(200);
  	});
  	
});
<?php echo $this->Html->scriptEnd(); ?>