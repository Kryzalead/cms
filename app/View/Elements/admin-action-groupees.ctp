<div style="margin-top: 10px">
	<?php echo $this->Form->input('action',array('label'=>false,'type'=>'select','options'=>$list_action)); ?>
	<?php if (!empty($options)): ?>
		<?php foreach ($options as $k => $v): ?>
			<?php echo $this->Form->input($k,array('label'=>false,'type'=>'hidden','value'=>$v)); ?>
		<?php endforeach ?>
	<?php endif ?>
	<?php echo $this->Form->submit('Appliquer') ?>
</div>