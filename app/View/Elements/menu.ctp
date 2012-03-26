<div class="menu">
	<ul class="nav">
		<?php $menu = $this->requestAction(array('controller'=>'menus','action'=>'getMenu','principal','admin'=>false)) ?>
		<?php foreach ($menu as $k => $v): $v = $v['Post'];?>
			<li><?php echo $this->Html->link($v['name'],array('plugin'=>null,'controller'=>'posts','action'=>'view','type'=>'page','slug'=>$v['slug']));?></li>
		<?php endforeach ?>
			<li><?php echo $this->Html->link("Articles",array('plugin'=>null,'action'=>'index','controller'=>'posts')); ?></li>
			<li><?php echo $this->Html->link("Livre d'or",array('plugin'=>'guestbook','action'=>'index','controller'=>'guestbooks')); ?></li>
			<li><?php echo $this->Html->link("Contact",array('plugin'=>'contact','action'=>'contact','controller'=>'contacts')); ?></li>
	</ul>
</div>
