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
	#content .media_tinymce .media_form .radio input{width: auto;opacity: 1;
	-moz-opacity: 1;
	filter:alpha(opacity=1);}
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

	<div class="search-box">
		<?php echo $this->Form->create('Media',array('type'=>'get')); ?>
		<?php echo $this->Form->input('search',array('label'=>'')) ?>
		<?php echo $this->Form->end('Rechercher dans les medias'); ?>
	</div>
	<div>
		<?php echo $this->element('list-top-table',array('model'=>'media','options'=>$data_for_top_table)) ?>
		<p style="text-align: right">
			<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
			<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
		</p>
	</div>
	<?php echo $this->Form->create('Media',array('url'=>array('controller'=>'medias','action'=>'doaction'))) ?>
		<div style="margin-top: 10px">
			<?php echo $this->Form->input('action',array('label'=>false,'type'=>'select','options'=>$list_action)); ?>
			<?php echo $this->Form->submit('Appliquer') ?>
		</div>
	<table class="classicTable posts" style="-webkit-border-radius: 3px;border-radius: 3px;border-width: 1px;border-style: solid;display: table;border-spacing: 2px;border-color: gray;margin-top: 10px">
		<thead style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
			<tr style="color: #21759B">
				<th><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('Post.name','Fichier'); ?></th>
				<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
				<th><?php echo $this->Paginator->sort('Post.created','Date'); ?></th>
			</tr>
		</thead>
		<tbody style="color: gray;">
			<?php if (!empty($medias)): ?>
				<?php foreach ($medias as $k => $v):?>
				<tr id="post_<?php echo $v['Media']['id'] ?>">
					<td><?php echo $this->Form->input($v['Media']['id'],array('label'=>false,'type'=>'checkbox')); ?></td>
					<td>
						<div style="float: left;width: 70px;">
							<?php $alt = !empty($v['Media']['alt']) ? $v['Media']['alt'] : ''; ?>
							<?php echo $this->Html->image($v['Media']['thumbnail'],array('title'=>$v['Media']['name'],'alt'=>$alt,'width'=>60,'height'=>60)) ?>
						</div>
						<div>
							<?php echo $this->Html->link($v['Media']['name'],array('action'=>'edit','?'=>array('attachment_id'=>$v['Media']['id']))); ?>
							<p style="margin-top: 5px;color: #333;margin-bottom: 5px">
								<?php echo strtoupper(substr($v['Media']['thumbnail'],-3,3));?>
							</p>
							<div class="action_admin">
								<?php echo $this->Html->link("Modifier",array('action'=>'edit','?'=>array('attachment_id'=>$v['Media']['id'])),array('class'=>'upd')); ?> |
								<?php echo $this->Html->link("Supprimer définitivement",array('controller'=>'medias','action'=>'delete','?'=>array('id'=>$v['Media']['id'],'token'=>$this->Session->read('Security.token'))),array('class'=>'del'),'Voulez vous vraiment supprimer ce contenu ?'); ?>
							</div>
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
		<tfoot style="background-color: #F1F1F1;border-top-color: white;border-bottom-color: #DFDFDF">
			<tr style="color: #21759B">
				<th><input type="checkbox" class="checkall"></th>
				<th><?php echo $this->Paginator->sort('Post.name','Fichier'); ?></th>
				<th><?php echo $this->Paginator->sort('User.username','Auteur'); ?></th>
				<th><?php echo $this->Paginator->sort('Post.created','Date'); ?></th>
			</tr>
		</tfoot>
	</table>
	<?php echo $this->Form->end(); ?>
	<div style="margin-top: 5px">
		<p style="text-align: right">
			<?php $terminaison = ($totalElement > 1) ? 's' : '';?>
			<span class="totalElement"><?php echo $totalElement ?></span> Element<?php echo $terminaison ?>
		</p>
	</div>
	<?php echo $this->Paginator->numbers(); ?>
<?php else: ?>
	<div id="medias_tinymce">
		<?php if (!empty($medias)): ?>
			<?php foreach ($medias as $k => $v): ?>
				<div id="media_<?php echo $v['Media']['id'];?>" class="media_tinymce">
					<?php $alt  = (!empty($v['Media']['alt'])) ? $v['Media']['alt'] : ''?>
					<div class="toggle_media">
						<div class="toggle_thumbnail">
							<?php echo $this->Html->image($v['Media']['thumbnail'],array('width'=>60,'height'=>60,'title'=>$v['Media']['name'])) ?>
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
							<?php echo $this->Html->image($v['Media']['thumbnail'],array('width'=>128,'height'=>128,'alt'=>$alt,'title'=>$v['Media']['name'])); ?>
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