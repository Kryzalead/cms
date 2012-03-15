<style type="text/css">
	.list-top-table{}
	.list-top-table li{display: inline-block;}
	#content a:hover{color: #ff4b33}
	#content .list-top-table .current{color: #000;font-weight : bold;}
</style>
<ul class="list-top-table">
	<?php foreach ($options['list'] as $k => $v): ?>
		<?php if ($model == 'post'): ?>
			<?php $request = array('type'=>$options['params']['type'],'status'=>$k) ?>
		<?php elseif($model == 'media'): ?>
			<?php $request = array('type_mime'=>$k) ?>
		<?php elseif($model == 'user'): ?>
			<?php $request = array('role'=>$k) ?>	
		<?php endif ?>
		<?php if ($k == 'all'): ?>
			<li class="<?php echo $k ?>">
				<?php if (!empty($options['params']['type'])  && $options['params']['type']== 'page'): ?>
					<?php if ($options['current'] == 'all'): ?>
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s','?'=>array('type'=>'page')),array('class'=>'current')); ?>
					<?php else: ?>
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s','?'=>array('type'=>'page'))); ?>
					<?php endif ?>
				<?php else: ?>
					<?php if ($options['current'] == 'all'): ?>
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s'),array('class'=>'current')); ?>
					<?php else: ?>
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s')); ?>
					<?php endif ?>
				<?php endif ?>
				<span class="total">(<?php echo $options['count']['total'] ?>)</span>
			</li>
		<?php else: ?>
			<?php if (!empty($options['count']['total'.ucfirst($k)]) && $options['count']['total'.ucfirst($k)] !=0): ?>
				<li class="<?php echo $k ?>">
					<?php if ($options['current'] == $k): ?>
						<span>|</span> 
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s','?'=>$request),array('class'=>'current')); ?>
						<span class="total<?php echo ucfirst($k);?>">(<?php echo $options['count']['total'.ucfirst($k)] ?>)</span>
					<?php else: ?>
						<span>|</span> 
						<?php echo $this->Html->link($v,array('action'=>$options['action'],'controller'=>$model.'s','?'=>$request)); ?>
						<span class="total<?php echo ucfirst($k);?>">(<?php echo $options['count']['total'.ucfirst($k)] ?>)</span>
					<?php endif ?>
				</li>
			<?php endif ?>
		<?php endif ?>
	<?php endforeach ?>
</ul>
