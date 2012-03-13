<div class="menu">
	<ul class="nav">
		<?php $menu = $this->requestAction(array('controller'=>'menus','action'=>'getMenu','principal')) ?>
		<?php foreach ($menu as $k => $v): $v = $v['Post'];?>
			<li><?php echo $this->Html->link($v['name'],array('controller'=>'posts','action'=>'view','type'=>'page','slug'=>$v['slug']));?></li>
		<?php endforeach ?>
			<li><?php echo $this->Html->link("Articles",array('action'=>'index','controller'=>'posts')); ?></li>
	</ul>
</div>
