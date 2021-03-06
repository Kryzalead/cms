<style type="text/css">
	#sidemenu{list-style-type: none;padding-left: 10px;font-size: 12px;margin: 0 5px;overflow:hidden;background-color: #F9F9F9;border-bottom-color: #DFDFDF;};
	#sidemenu li{display: inline;line-height: 200%;list-style: none;text-align: center;white-space: nowrap;margin: 0;padding: 0;}
	#sidemenu a{color: #21759B;;background-color: #F9F9F9;border-color: #F9F9F9;border-bottom-color: #DFDFDF;padding: 0 7px;display: block;float: left;line-height: 28px;border-top-width: 1px;border-top-style: solid;border-bottom-width: 1px;border-bottom-style: solid;text-decoration: none}
	#sidemenu a:hover{color: #D54E21}
	#sidemenu a.current {background-color: white;border-color: #DFDFDF #DFDFDF white;color: #D54E21;font-weight: normal;padding-left: 6px;padding-right: 6px;-webkit-border-top-left-radius: 3px;-webkit-border-top-right-radius: 3px;border-top-left-radius: 3px;border-top-right-radius: 3px;border-width: 1px;border-style: solid;}


	#medias_tinymce{margin-top: 20px;}
	.media_tinymce{padding: 2px}
	
	.toggle_media{padding: 2px;border: 1px solid #DFDFDF;}
	.toggle_thumbnail{float: left}
	.toggle_action_media{text-align: right;height: 20px;line-height:20px}

	.media_tinymce .media_form{border: 1px solid #DFDFDF;display: none;padding: 20px}
</style>
<?php if ($this->request->action == 'admin_tinymce'): ?>
	<div id="upload_tinymce">
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
	</div>
<?php endif ?>

<?php if ($this->request->action != 'admin_tinymce'): ?>
	<h1>
		<?php echo $this->Html->image('icone-medias.png',array('width'=>62,'height'=>62)); ?>
		<?php echo $title_for_layout ?>
	</h1>
	<?php echo $this->Html->link('Ajouter un média',array('action'=>'edit'),array('class'=>'button button-add')) ?>
	<?php if (!empty($this->request->query['search'])): ?>
		<span style="color: #777">Résultats de recherche pour "<?php echo $this->request->query['search'] ?>"
	<?php endif ?>

	<?php echo $this->element('admin-search',array('model'=>'media','text_for_submit_search'=>'Chercher parmi les médias')) ?>
	<div>
		<?php echo $this->element('admin-list-top-table',array('model'=>'media','options'=>$data_for_top_table)) ?>
		<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
	</div>
	<?php echo $this->Form->create('Media',array('url'=>array('controller'=>'medias','action'=>'doaction'))) ?>
	<?php echo $this->element('admin-action-groupees',array('list'=>$list_action)) ?>
	<table class="liste_table medias">
		<thead>
			<tr>
				<th class="colonne_check"><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('Post.name','Fichier'); ?></th>
				<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
				<th><?php echo $this->Paginator->sort('Post.created','Date'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($medias)): ?>
				<?php foreach ($medias as $k => $v):?>
				<tr id="post_<?php echo $v['Media']['id'] ?>">
					<td class="colonne_check"><?php echo $this->Form->input($v['Media']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
					<td class="colonne_medias">
						<div class="thumb">
							<?php $alt = !empty($v['Media']['alt']) ? $v['Media']['alt'] : ''; ?>
							<?php 
								$dimension = getimagesize ($v['Media']['guid']); 
								$largeur = 80;$hauteur = 60;
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
								<?php echo $this->Html->image($v['Media']['guid'],array('title'=>$v['Media']['name'],'alt'=>$alt,'width'=>$width,'height'=>$height)) ?>
						</div>
						<div class="thumb_meta">
							<?php echo $this->Html->link($v['Media']['name'],array('action'=>'edit','?'=>array('attachment_id'=>$v['Media']['id']))); ?>
							<?php echo strtoupper(substr($v['Media']['thumbnail'],-3,3));?>
						</div>
						<div class="action_admin">
							<?php echo $this->Html->link("Modifier",array('action'=>'edit','?'=>array('attachment_id'=>$v['Media']['id'])),array('class'=>'upd')); ?> |
							<?php echo $this->Html->link("Supprimer définitivement",array('controller'=>'medias','action'=>'delete','?'=>array('id'=>$v['Media']['id'],'token'=>$this->Session->read('Security.token'))),array('class'=>'del'),'Voulez vous vraiment supprimer ce contenu ?'); ?>
						</div>
					</td>
					<td><?php echo $v['User']['username'] ?></td>
					<td><?php echo $this->date->format($v['Media']['created'],'FR') ?></td>
				</tr>
			<?php endforeach ?>
			<?php else: ?>
				<td></td>
				<td>Aucun média à afficher</td>
				<td></td>
				<td></td>
				<td></td>
			<?php endif ?>
		</tbody>
		<tfoot>
			<tr>
				<th class="colonne_check"><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('Post.name','Fichier'); ?></th>
				<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
				<th><?php echo $this->Paginator->sort('Post.created','Date'); ?></th>
			</tr>
		</tfoot>
	</table>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->element('admin-total-element',array('total'=>$totalElement)) ?>
	<?php echo $this->Paginator->numbers(); ?>
<?php else: ?>
	<div id="medias_tinymce">
		<?php if (!empty($medias)): ?>
			<?php foreach ($medias as $k => $v): ?>
				<div id="media_<?php echo $v['Media']['id'];?>" class="media_tinymce">
					<?php $alt  = (!empty($v['Media']['alt'])) ? $v['Media']['alt'] : ''?>
					<div class="toggle_media">
						<div class="toggle_thumbnail">
							<?php echo $this->Html->image($v['Media']['guid'],array('width'=>60,'height'=>60,'title'=>$v['Media']['name'])) ?>
						</div>
						<div class="toggle_name">
							<?php echo $v['Media']['name']; ?>
						</div>
						<div class="toggle_action_media">
							<a href="#" class="toggle on">Afficher</a>
							<a href="#" class="toggle off" style="display: none">Masquer</a>
						</div>
						<div class="clear"></div>
					</div>	
					<div class="media_form">
						<div style="float:left;margin-right: 20px">
							<?php echo $this->Html->image($v['Media']['guid'],array('width'=>128,'height'=>128,'alt'=>$alt,'title'=>$v['Media']['name'])); ?>
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
							<?php echo $this->Form->input('class',array('legend'=>"Alignement : ",'options'=>$alignement,'type'=>'radio')); ?>
							<div style="margin-bottom: 5px"></div>
							<?php echo $this->Form->input('size',array('legend'=>"Taille : ",'options'=>$taille,'type'=>'radio')); ?>
						   	<?php echo $this->Form->input('method',array('type'=>'hidden','value'=>'library')) ?>
						   	<?php echo $this->Form->input('guid',array('value'=>$v['Media']['guid'],'type'=>'hidden')) ?>
			   			<?php echo $this->Form->end('Insérer') ?>	
					</div>
				</div>
			<?php endforeach ?>
		<?php else: ?>
			<div style="padding: 2px;border: 1px solid #DFDFDF;">Pas de médias à afficher</div>	
		<?php endif ?>
	</div>
	
	<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
		jQuery(function($){
		  	$('.on').click(function(){
		  		object = $(this);
		  		$(object).parent().parent().children('.toggle_thumbnail').fadeOut(200);
		  		$(object).fadeOut(200);
		  		$(object).next('.off').fadeIn(250);
		  		$(this).parent().parent().siblings('.media_form').fadeIn(250);
		  	});
		  	
		  	$('.off').click(function(){
		  		object = $(this);
		  		$(object).fadeOut(200);
		  		$(object).prev('.on').fadeIn(250);
		  		$(object).parent().parent().children('.toggle_thumbnail').fadeIn(200);
		  		$(this).parent().parent().siblings('.media_form').fadeOut(250);
		  	});
		});
	<?php echo $this->Html->scriptEnd(); ?>
<?php endif; ?>	