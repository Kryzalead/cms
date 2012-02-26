<?php 
class MenusController extends AppController{

	public function admin_index($id = null){

		// si id n'est pas défini on initialise l'id 1
		if($id == null)
			$id = 1;

		$d['menu_id'] = $id;
		
		// on charge le model des posts
		$this->loadModel('Post');
		
		// on récupère la liste des pages
		$d['listPages'] = $this->Post->find('list',array(
			'conditions'=>	array('Post.type'=>'page','Post.status'=>'publish')
		));

		
		// on récupère la liste des menus
		$d['listMenus'] = $this->Menu->find('list');
		
		$d['menu'] = $this->Menu->find('first',array(
			'fields'=>array('Menu.id','Menu.name'),
			'conditions'=>array('Menu.id'=>$id),
			'recursive'=>-1
		));

		// on envois le menu au formulaire
		$this->request->data = $d['menu'];

		// on passe la recursivité à -1
		$this->Menu->recursive = -1;		

		// on crée nos jointures
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
			'conditions'	=>	array('Menu_post.menu_id'=>$id),
			'order'			=>	array('Menu_post.position'=>'ASC')	
		));

		// on set les datas à la vue
		$this->set($d);

	}

	public function admin_edit(){
		
		 if($this->request->is('post')){
		 	$this->request->data['Menu']['slug'] = strtolower(Inflector::slug($this->data['Menu']['name'],'-'));
		 	$this->request->data['Menu']['count'] = 0;
		 	$this->Menu->save($this->request->data);
		 	if($this->request->data['Menu']['id'] == 0)
		 		$this->Session->setFlash("Le menu a bien été créé","notif");
		 	else
		 		$this->Session->setFlash("Le menu a bien été modifié","notif");	
		 	$this->redirect(array('action'=>'index',$this->Menu->id));		
		 }
		 else $this->redirect($this->referer());
	}

	/*
	*	Fonction permettant de supprimer un menu
	*/	
	public function admin_delete($id,$token = null){
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

		// on supprime d'abord les associations
		$this->Menu->Menu_post->deleteAll(
			array('Menu_post.menu_id'=>$id)
		);

		// on supprime ensuite le menu
		$this->Menu->delete($id);

		$this->Session->setFlash("Le menu a bien été supprimé","notif");
		$this->redirect(array('action'=>'index'));
	}

	public function admin_addItem(){
		
		if($this->request->is('Post')){
			
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
			$this->redirect($this->referer());
		}
		else
			$this->redirect('/');
	}

	public function admin_deleteItem($id){
		
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
		// on renvois la vue admin_index
		$this->render('admin_index');
		// on retourne true pour dire que tout s'est bien passé
		return true;
	}
}
 ?>