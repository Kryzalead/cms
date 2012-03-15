<h1>
	<?php echo $this->Html->image('icone-menus.png',array('width'=>62,'height'=>62)); ?>
	<?php echo $title_for_layout ?>
</h1>
<div id="contain">
	<div id="contain-left" style="width: 25%;float: left">
		<div id="block-post" style="border: 1px solid #DFDFDF;background-color: whiteSmoke">
			<div class="block-title" style="background-color: #F1F1F1;border-bottom: 1px solid #DFDFDF;">
				<h3 style="margin-left: 5px;height: 30px;line-height: 30px;">Pages</h3>
			</div>
			<div class="inside" style="padding: 5px">
				<?php echo $this->Form->create('Menu',array('action'=>'addItem')); ?>
				<?php $disabled = ($menu_id == 0) ? 'disabled' : ''; ?>
				<?php foreach ($listPages as $k => $v):?>
					<div>
						<?php echo $this->Form->checkbox('Post.'.$k,array('style'=>'height: 20px',$disabled)); ?> 
						<?php echo $this->Form->label('Post.'.$k,$v,array('style'=>'width: 200px')) ?>
					</div>
				<?php endforeach?>
				<div style="clear:both"></div>
				<?php echo $this->Form->input('Menu.id',array('type'=>'hidden','value'=>$menu_id)); ?>
				<?php echo $this->Form->submit('Ajouter au menu',array($disabled));?>
				<?php echo $this->Form->end() ?>
			</div>
		</div>
	</div>
	<div id="contain-right" style="float: left;margin-left: 5%;width: 65%">
		<div id="block-menus" >
			<div id="block-menu-list" >
				<ul style="list-style-type: none">
					<?php foreach ($listMenus as $k => $v): ?>
						<li style="width: 124px;display: inline-block;background: #F9F9F9;border: 1px solid #DFDFDF;text-align: center;height: 28px;line-height: 28px">
							<?php echo $this->Html->link($v,array('action'=>'index','?'=>array('id'=>$k)),array('style'=>'color: #464646;')); ?>
						</li>
					<?php endforeach ?>
					<li style="width: 40px;display: inline-block;background: #F9F9F9;border: 1px solid #DFDFDF;text-align: center;height: 28px;line-height: 28px">
							<?php echo $this->Html->link('+',array('action'=>'index','?'=>array('id'=>0)),array('style'=>'color: #464646;','title'=>'Ajouter un menu')); ?>
						</li>
				</ul>
			</div>
			<div class="block-menu-block" >
				<div style="padding: 0px">
					<div id="block-menu-title" style="margin: 5px">
						<div style="margin-left: 0px">
							<?php echo $this->Form->create('Menu',array('action'=>'edit')); ?>
							<?php echo $this->Form->input('Menu.name',array('label'=>"Nom du menu : ")); ?>
							<?php echo $this->Form->input('Menu.id'); ?>
							<?php echo $this->Form->end($texte_for_submit) ?>
						</div>
					</div>
					<?php if ($menu_id != 0): ?>
						<div id="menu-action" style="margin: 5px">
							<?php echo $this->Html->link("Supprimer le menu",array('action'=>'delete','?'=>array('id'=>$menu_id,'token'=>$this->Session->read('Security.token'))),array('style'=>'color: red')); ?>
						</div>	
					<?php endif ?>
					<div id="block-menu-items" style="background-color: #fff;margin-top: 20px;border-top: 1px solid #DFDFDF;border-bottom: 1px solid #DFDFDF">
					<?php if($menu_id != 0): ?>
						<?php if (!empty($menu_posts)): ?>
							<ul style="list-style-type: none; padding-top: 20px;padding-bottom: 20px" id="sortable">
								<?php foreach ($menu_posts as $k => $v): ?>
									<li class="menu-item" id="item_<?php echo $v['Menu_post']['id'] ?>" style="border: 1px solid red;width: 500px;border:1px solid #DFDFDF;margin-top: 20px;background-color: #F1F1F1">
										<div class="menu-item-title" style="padding: 5px;height: 20px;line-height: 20px;border-bottom: 1px solid #DFDFDF">
											<span style="display: inline-block;width: 90%"><?php echo $v['Post']['name'] ?></span>
											<span><?php echo ucfirst($v['Post']['type']) ?></span>
										</div>
										<div class="menu-item-action" style="background-colo: whiteSmoke;padding: 5px">
											<span>
											<?php echo $this->Html->link("Supprimer",array('action'=>'deleteItem','?'=>array('id'=>$v['Menu_post']['id'])),array('style="color: red;font-size: 12px"'),'Voulez vous vraiment supprimer cet élement'); ?>
											</span> |
											<span>
											<?php echo $this->Html->link("Editer",array('action'=>'edit','controller'=>'posts','?'=>array('type'=>$v['Post']['type'],'id'=>$v['Post']['id'])),array('style'=>'color: #257EA8;font-size: 12px')); ?>
											</span>
										</div>
									</li>
								<?php endforeach ?>	
							</ul>
						<?php else: ?>
						<p>Sélectionner les entrées du menu (pages) depuis les blocs situés à gauche pour commencer à construire votre menu personnalisé.</p>	
						<?php endif ?>
					<?php else: ?>
						<p>
							Pour créer un menu personnalisé, donnez-lui un nom ci-dessus et cliquez sur « Créer un menu ». Ensuite, ajoutez-y des entrées (des pages, des catégories ou des liens personnalisés) depuis la colonne de gauche.
						</p>	
						<p>
							Après avoir ajouté vos entrées, vous pouvez les glisser/déposer afin de les ordonner. Cliquez sur chacune des entrées pour afficher ses options de configuration.
						</p>
						<p>	
							Une fois que vous avez terminé de construire votre menu, n’oubliez pas de cliquer sur le bouton « Enregister le menu ».
						</p>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
jQuery(function($){
	$('#sortable').sortable({
		axis: 'y',
		//containment: '#sortable',
		handle: ".menu-item-title",
		distance: 10,
 		placeholder: 'highlight', // classe à ajouter à l'élément fantome,
 		update: function(){
 			var order = $(this).sortable("serialize");
 			$.post("<?php echo $this->Html->url(array('action'=>'move')) ?>",order,function(data){});
 		}
	});
	$( "#sortable" ).disableSelection();  	
});
<?php echo $this->Html->scriptEnd(); ?>

