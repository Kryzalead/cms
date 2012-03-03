<?php $this->set('title_for_layout','Blog | '.Configure::read('site_name')); ?>
<?php foreach($posts as $k => $v):?>
	<div class="hentry">
		<h2 class="entry-title"><?php echo $this->Html->link($v['Post']['name'],$v['Post']['link'],array('title'=>$v['Post']['name'])); ?></h2>
		<div class="entry-meta">
			<span>Posté le </span>
			<span class="entry-date"><?php echo $this->date->format($v['Post']['created'],'FR') ?></span>
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
					<span class="entry-category"><?php echo $this->Html->link($v1['name'],array('action'=>'','controller'=>'')); ?></span>
				<?php endforeach ?>
			<?php endif; ?>	
			<?php if(!empty($v['Taxonomy']['tag'])): ?>
				<span> | </span>
				<span><strong>Tags : </strong></span>
				<?php foreach ($v['Taxonomy']['tag'] as $k1 => $v1): ?>
					<span class="entry-category"><?php echo $this->Html->link($v1['name'],array('action'=>'','controller'=>'')); ?></span>
				<?php endforeach ?>				
			<?php endif; ?>	 					
			</span>
		</div>
		<?php endif; ?>		
	</div>
<?php endforeach;?>
<?php echo $this->Paginator->numbers() ?>