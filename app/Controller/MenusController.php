<?php 
class MenusController extends AppController{

	function getMenu($name){
		$menu = $this->Menu->find('all',array(
			'fields'=>	array('Menu.id','Post.id','Post.name','Post.slug','Post.type'),
			'joins'	=>	array(
				array(
					'table'	=>	'menu_posts',
					'alias'	=>	'Menu_posts',
					'type'	=>	'INNER',
					'conditions'=>array('Menu_posts.menu_id=Menu.id')
				),
				array(
					'table'	=>	'posts',
					'alias'	=>	'Post',
					'type'	=>	'INNER',
					'conditions'	=>	array('Menu_posts.post_id=Post.id')
				)
			),
			'conditions'	=>	array('Menu.name'=>$name,'Post.status'=>'publish','Post.type'=>'page'),
			'order'			=>	array('Menu_posts.position')	
		));
		return $menu;
	}
}
 ?>