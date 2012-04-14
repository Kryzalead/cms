<div id="actus">
	<?php if (!empty($posts)): ?>
		<?php foreach($posts as $k => $v):?>
			<div class="article" id="post-<?php echo $v['Post']['id'];?>">
				<img src="img/actualite.png" width=90 height=90 alt="actualité" />
					<h2 class="titre_article"><?php echo $this->Html->link($v['Post']['name'],$v['Post']['link'],array('title'=>$v['Post']['name'])); ?></h2>
						<div class="meta_article">
							<span>Posté le</span>
							<span class="date_article"><?php echo $this->date->format($v['Post']['created'],'FRS') ?></span>
							<span>par</span>
							<span class="auteur_article"><?php echo $v['User']['username'] ?></span>
						</div>
						<div class="contenu_article">
							<?php  echo $this->Text->truncate($v['Post']['content'],600,array('exact'=>false,'html'=>true));?>
						</div>
						<img src="img/fleche.png" width=7 height=11 alt="flèche voir la suite" class="image_fleche_suite"/>
						<p><?php echo $this->Html->link("Voir la suite",$v['Post']['link']); ?></p>
				<?php if(!empty($v['Taxonomy'])): ?>
				<div class="taxo_article">
					<span class="cat_article">
					<?php if (!empty($v['Taxonomy']['category'])): ?>
						<span><strong>Categories : </strong></span>
						<?php foreach ($v['Taxonomy']['category'] as $k1 => $v1): ?>
							<span class="category_article">
								<?php echo $this->Html->link($v1['name'],array('plugin'=>false,'controller'=>'posts','action'=>'viewterm','type'=>'category','slug'=>$v1['slug'])); ?>
							</span>
						<?php endforeach ?>
					<?php endif; ?>	
					<?php if(!empty($v['Taxonomy']['tag'])): ?>
						<span> | </span>
						<span><strong>Tags : </strong></span>
						<?php foreach ($v['Taxonomy']['tag'] as $k1 => $v1): ?>
							<span class="tags_article">
								<?php echo $this->Html->link($v1['name'],array('plugin'=>false,'controller'=>'posts','action'=>'viewterm','type'=>'tag','slug'=>$v1['slug'])); ?>
							</span>
						<?php endforeach ?>				
					<?php endif; ?>	 					
					</span>
				</div>
				<?php endif; ?>		
			</div>
		<?php endforeach;?>
		<?php 
		$this->Paginator->options(array('url'=>array('controller'=>'posts','action'=>'index','page'=>$this->params['page']))) ;
		 ?>
		<?php echo $this->Paginator->numbers() ?>
	<?php else: ?>
		<p>Aucune actualité</p>
	<?php endif ?>
</div>