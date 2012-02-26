<div class="menu">
	<ul class="nav">
		<?php foreach ($menu as $k => $v): $v = $v['Post'];?>
			<li><?php echo $this->Html->link($v['name'],array('controller'=>Inflector::pluralize($v['type']),'action'=>'view','id'=>$v['id'],'slug'=>$v['slug']));?></li>                       	
		<?php endforeach ?>
	</ul>
</div>
