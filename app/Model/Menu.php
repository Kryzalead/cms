<?php 
class Menu extends AppModel{
	
	public $actsAs = array('Containable');
    
    public $hasMany = array('Menu_post');

    public function getMenu($name){
		
		// on passe la recursivité à -1
		$this->recursive = -1;

		// on crée nos jointures
		$menu = $this->find('all',array(
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

		// on renvois le résultat
		return $menu;
	}
}

 ?>