<style type="text/css">
	div.radio input{opacity: 1;
	-moz-opacity: 1;
	filter:alpha(opacity=1);}
</style>
<h1>
	<?php echo $this->Html->image('icone-config.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<div id="options_generales" class="bloc degrader">
	<div class="image-option" id="option-<?php echo $action ?>"></div>
	<?php echo $this->Html->image('option-'.$action.'.png') ?>
	<?php echo $this->Form->create('Options') ?>
		<?php if ($action == 'general'): ?>
			<?php echo $this->Form->input('Option.site_name',array('label'=>"Titre du site")); ?>
			<?php echo $this->Form->input('Option.site_slogan',array('label'=>"Slogan du site",'after'=>"En quelques mots, décrivez la raison d’être de ce site.")); ?>
			<?php echo $this->Form->input('Option.admin_email',array('label'=>"Adresse de messagerie",'after'=>'Cette adresse n’est utilisée que pour l’administration du site.<br/> <span class="souligner">Par exemple</span> : la notification de l’inscription d’un nouvel utilisateur.')); ?>
			<?php echo $this->Form->input('Option.default_role',array('label'=>'Rôle par defaut de tout nouvel utilisateur','type'=>'select','options'=>$list_user_roles)) ?>
		<?php elseif($action == 'write'): ?>
			<?php echo $this->Form->input('Option.default_post_edit_rows',array('label'=>"Taille du champ de saisie : ",'after'=>' lignes')); ?>
			<?php echo $this->Form->input('Option.default_post_category',array('label'=>"Catégorie par défaut des articles : ",'options'=>$list_category)); ?>
		<?php elseif($action == 'read'): ?>
			<table class="form_table">
				<tbody>
					<tr>
						<th>La page d'accueil affiche</th>
							<td>
								<?php echo $this->Form->input('Option.show_on_front',array('legend'=>false,'type'=>'radio','options'=>$list_show_on_front)); ?>
							</td>	
					</tr>
					<tr>
						<?php echo $this->Form->input('Option.page_on_front',array('label'=>"Page d'acceuil",'type'=>'select','options'=>$list_page_on_show,'id'=>'page_on_front',$is_disabled)); ?>
					</tr>
					<tr>
						<?php echo $this->Form->input('Option.posts_per_page',array('label'=>"Les pages du site doivent afficher au plus",'after'=>' articles')); ?>
					</tr>
				</tbody>
			</table>
		<?php elseif($action == 'media'): ?>
			<h3>Taille des images</h3>
			<p>Les tailles précisées ci-dessous déterminent les dimensions maximales (en pixels) à utiliser lors de l’insertion d’une image dans le corps d’un article.</p>

			<table style="margin-top: 20px">
				<tbody>
					<tr>
						<th style="width: 200px;height: 50px;line-height: 50px">Taille des miniatures</th>
						<td style="background: none;border: none">
							<?php echo $this->Form->input('Option.thumbnail_size_w',array('label'=>"Largeur",'div'=>array('style'=>'float: left;margin-right: 10px'),'style'=>'margin-left: 5px;width: 50px')); ?>
							<?php echo $this->Form->input('Option.thumbnail_size_h',array('label'=>"Longueur",'style'=>'margin-left: 5px;width: 50px')); ?>
						</td>
					</tr>
					<tr>
						<th style="width: 200px;height: 50px;line-height: 50px">Taille moyenne</th>
						<td style="background: none;border: none">
							<?php echo $this->Form->input('Option.medium_size_w',array('label'=>"Largeur",'div'=>array('style'=>'float: left;margin-right: 10px'),'style'=>'margin-left: 5px;width: 50px')); ?>
							<?php echo $this->Form->input('Option.medium_size_h',array('label'=>"Longueur",'style'=>'margin-left: 5px;width: 50px')); ?>
						</td>
					</tr>
					<tr>
						<th style="width: 200px;height: 50px;line-height: 50px">Grande taille</th>
						<td style="background: none;border: none">
							<?php echo $this->Form->input('Option.large_size_w',array('label'=>"Largeur",'div'=>array('style'=>'float: left;margin-right: 10px'),'style'=>'margin-left: 5px;width: 50px')); ?>
							<?php echo $this->Form->input('Option.large_size_h',array('label'=>"Longueur",'style'=>'margin-left: 5px;width: 50px')); ?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php elseif($action == 'discussion'): ?>
			<table style="margin-top: 20px">
				<tbody>
					<tr>
						<td style="background: none;border: none">Réglages par défault des articles</td>
						<td style="background: none;border: none"><?php echo $this->Form->input('Option.default_comment_status',array('label'=>"Autoriser les visiteurs à publier des commentaires sur les derniers articles ",'type'=>'checkbox','style'=>'margin-right: 10px')); ?></td>
					</tr>
				</tbody>
			</table>	
		<?php endif ?>
	<?php echo $this->Form->end('Enregistrer les modifications') ?>
</div>