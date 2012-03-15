<?php 
class MenusController extends AppController{

	/*
	*	Fonction qui récupère un menu selon son nom
	*/
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

	/*
	*	Fonction qui permet d'administrer les menus
	*/
	function admin_index(){
		$d['title_for_layout'] = 'Menus';
		$d['texte_for_submit'] = 'Créer le menu';

		$this->loadModel('Post');
		$d['listPages'] = $this->Post->find('list',array(
			'conditions'=>array('Post.type'=>'page','Post.status'=>'publish')
		));

		$d['listMenus'] = $this->Menu->find('list');

		if(empty($d['listMenus'])){
			$d['menu_id'] = 0;
		}
		else{
			if(empty($this->request->query['id'])){
				if($this->request->query['id'] != '0'){
					$temp = current($this->Menu->find('first',array(
						'fields'=>array('id'),
						'order'=>'id ASC'
					)));
					$d['menu_id'] = $temp['id'];	
				}
				else
					$d['menu_id'] = 0;
			}
			else
				$d['menu_id'] = $this->request->query['id'];	
		}

		if($d['menu_id'] == 0){
			$this->request->data = array(
				'Menu'=>array(
					'id'=>0
				)
			);
		}		
		else{
			$d['texte_for_submit'] = 'Enregistrer le menu';
			$this->Menu->id = $d['menu_id'];
			$this->request->data = $this->Menu->read();

			$d['menu_posts'] = $this->Menu->Menu_post->find('all',array(
				'fields'=>	array('Menu_post.id','Menu_post.position','Post.id','Post.name','Post.slug','Post.type'),
				'joins'	=>	array(
					array(
						'table'	=>	'posts',
						'alias'	=>	'Post',
						'type'	=>	'INNER',
						'conditions'	=>	array('Menu_post.post_id=Post.id')
					)
				),
				'conditions'	=>	array('Menu_post.menu_id'=>$d['menu_id']),
				'order'			=>	array('Menu_post.position'=>'ASC')	
			));
		}
			
		$this->set($d);
	}

	/*
	*	Fonction qui permet d'éditer un menu
	*/
	function admin_edit(){
		
		if($this->request->is('post') || $this->request->is('put')){

			if($this->Menu->save($this->request->data)){
				if($this->request->data['Menu']['id'] == 0)
					$this->Session->setFlash("Le menu a bien été créé","notif");
				else
					$this->Session->setFlash("Le menu a bien été modifié","notif");		
			}
			else
				$this->Session->setFlash("Une erreur s'est produite lors de la création du menu","notif",array('type'=>'error'));
		}
		$this->redirect(array('action'=>'index','?'=>array('id'=>$this->Menu->id)));
	}

	/*
	*	Fonction qui permet de supprimer un menu
	*/
	function admin_delete(){

		if(empty($this->request->query['token']))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $this->request->query['token'])
			$this->redirect('/');
		
		$id = $this->request->query['id'];
		$count = $this->Menu->find('count',array(
			'conditions'=>array('Menu.id'=>$id)
		));

		if(!$count){
			$this->error("Le menu ne peut être supprimé car il n'existe pas");
			return;
		}

		$this->Menu->id = $id;
		$this->Menu->delete();
		$this->Session->setFlash("Le menu a bien été supprimé","notif");
		$this->redirect(array('action'=>'index'));
	}

	/*
	*	Fonction qui ajoute un item à un menu
	*/
	function admin_addItem(){
		
		if($this->request->is('post')){
			
			// on initialise le tableau des datas
			$data = array();
			
			// on récupère l'id du menu
			$menu_id = $this->request->data['Menu']['id'];

			// on récupère la position du dernier item du menu
			$position = current($this->Menu->Menu_post->find('first',array(
				'fields'=>array('MAX(position) AS max_position'),
				'conditions'=>array('Menu_post.menu_id'=>$menu_id)
			)));
			
			// on initialise la dernière position
			$last_position = $position['max_position'];

			// on construit le tableau des données
			foreach ($this->request->data['Post'] as $k => $v) {
				if($v == 1){
					$data[] = array(
						'menu_id'=>$menu_id,
						'post_id'=>$k,
						'position'=>++$last_position
					);	
					
				}
			}
			$this->Menu->Menu_post->saveAll($data);
			$this->Session->setFlash("Les élements ont bien été ajoutés au menu","notif");
			Cache::delete('element__menu_cache');
			$this->redirect($this->referer());
		}
		else
			$this->redirect('/');
	}

	/*
	*	Fonction qui supprime un item
	*/
	function admin_deleteItem(){

		$id = $this->request->query['id'];
		$count = $this->Menu->Menu_post->find('count',array(
			'conditions'=>array('id'=>$id)
		));

		if($count == 0){
			$this->error("L'item ne peut être supprimé car il n'existe pas");
			return;
		}
		
		// on récupère la position
		$this->Menu->Menu_post->id = $id;
		$item = current($this->Menu->Menu_post->find('first',array(
			'fields'=>array('Menu_post.menu_id','Menu_post.position'),
			'conditions'=>array('Menu_post.id'=>$id)
		)));

		// on modifie la position des autres items du menu
		$this->Menu->Menu_post->updateAll(
			array('Menu_post.position' => 'Menu_post.position -1'),
			array(
				'Menu_post.position > '=>$item['position'],
				'Menu_post.menu_id'=>$item['menu_id']
			)
		); 
		
		// on supprime l'item
		$this->Menu->Menu_post->delete($id);
		$this->Session->setFlash("L'élément a bien été supprimé du menu","notif");
		Cache::delete('element__menu_cache');
		$this->redirect($this->referer());
	}


	/*
	*	Fonction permettant de gérer la position des items d'un menu
	*/
	public function admin_move(){
		// on met le layout à null car appel en ajax
		$this->layout = null;

		// on initialise la position à 1
		$position = 1;

		// on parcours les datas envoyées en ajax
		foreach ($this->request->data['item'] as $v){
			// on initialise l'id du moèdle Menu_post
			$this->Menu->Menu_post->id = $v;
			// on savegarde le champ position
			$this->Menu->Menu_post->saveField('position',$position);
			// on incrémente la position
			$position++;
		}
		Cache::delete('element__menu_cache');
		// on renvois la vue admin_index
		$this->render('admin_index');
		// on retourne true pour dire que tout s'est bien passé
		return true;
	}
}
 ?>