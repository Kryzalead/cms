<?php if (!empty($posts)): ?>
	<?php foreach($posts as $k => $v):?>
		<div class="hentry">
			<h2 class="entry-title"><?php echo $this->Html->link($v['Post']['name'],$v['Post']['link'],array('title'=>$v['Post']['name'])); ?></h2>
			<div class="entry-meta">
				<span>Posté le </span>
				<span class="entry-date"><?php echo $this->date->format($v['Post']['created'],'FRS') ?></span>
				<span>par</span>
				<span class="entry-author"><?php echo $v['User']['username'] ?></span>
			</div>
			<div class="entry-content">
				<p><?php  echo $this->Text->truncate($v['Post']['content'],600,array('exact'=>false,'html'=>true));?></p>
			</div>
			<p><?php echo $this->Html->link("Voir la suite",$v['Post']['link']); ?></p>	
			<?php if(!empty($v['Taxonomy'])): ?>
			<div class="entry-utility">
				<span class="cat-links">
				<?php if (!empty($v['Taxonomy']['category'])): ?>
					<span><strong>Categories : </strong></span>
					<?php foreach ($v['Taxonomy']['category'] as $k1 => $v1): ?>
						<span class="entry-category">
							<?php echo $this->Html->link($v1['name'],array('plugin'=>false,'controller'=>'posts','action'=>'viewterm','type'=>'category','slug'=>$v1['slug'])); ?>
						</span>
					<?php endforeach ?>
				<?php endif; ?>	
				<?php if(!empty($v['Taxonomy']['tag'])): ?>
					<span> | </span>
					<span><strong>Tags : </strong></span>
					<?php foreach ($v['Taxonomy']['tag'] as $k1 => $v1): ?>
						<span class="entry-category">
							<?php echo $this->Html->link($v1['name'],array('plugin'=>false,'controller'=>'posts','action'=>'viewterm','type'=>'tag','slug'=>$v1['slug'])); ?>
						</span>
					<?php endforeach ?>				
				<?php endif; ?>	 					
				</span>
				<span>
					<?php 
					$count = $v['Post']['comment_count'];
					if($count > 0){
						$terminaison = ($count>1) ? 's' : '';
						$v['Post']['link']['#'] = 'comments';
						echo $this->Html->link($count." commentaire".$terminaison,$v['Post']['link'],array('title'=>"Voir le".$terminaison." commentaire".$terminaison)); 
					}
					?>
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
	<p>Aucune actualitées</p>
<?php endif ?>
