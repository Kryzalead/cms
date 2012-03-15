<div class="search-box" style="text-align: right">
	<?php echo $this->Form->create(ucfirst($model),array('type'=>'get')); ?>
	<?php echo $this->Form->input('s',array('label'=>'')) ?>
	<?php if (!empty($options)): ?>
		<?php foreach ($options as $k => $v): ?>
			<?php echo $this->Form->input($k,array('label'=>null,'type'=>'hidden','value'=>$v)); ?>
		<?php endforeach ?>	
	<?php endif ?>
	<?php echo $this->Form->end($text_for_submit_search); ?>
</div>