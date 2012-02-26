<?php 
App::uses('Sanitize', 'Utility');

class PostsController extends AppController{

	/*
	*	Fonction affichant les derniers articles
	*/

	function index(){
		
		$this->Post->contain('User');

		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.type','Post.created','User.username'),
			'conditions'=>array(
				'Post.type'=>'post',
				'Post.status'=>'publish'
			),
			'order'=>'Post.created DESC',
			'limit'=>Configure::read('posts_per_page')
		);

		$this->set('posts',$this->Paginate('Post'));
	}

	/*
	*	Fonction affichant un article
	*/
	function view($id = null,$slug = null){
		
		if ($id == null) 
			throw new NotFoundException("Pas d'article");

		$this->Post->contain('User');

		$post = $this->Post->find('first',array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.created','Post.type','User.username'),
			'conditions'=>array('Post.id'=>$id)
		));

		if(empty($post))
			throw new NotFoundException('Erreur 404');
		
		if ($slug != $post['Post']['slug']) 
			$this->redirect($post['Post']['link'],301);
		
		$d['post'] = $post;
		$this->set($d);
	}

	/************ ADMINISTRATION ******************/

	function admin_index($status = ''){
		
		$this->Post->contain('User');

		$conditions = array('Post.type'=>'post');

		if(!empty($this->request->query['search'])){
			$search = Sanitize::clean($this->request->query['search']);
			$conditions = array_merge(array('Post.content LIKE'=>'%'.$search.'%','Post.status <>'=>'trash'),$conditions);
		}
		else
			$conditions = (!empty($status)) ? array_merge(array('Post.status'=>$status),$conditions) : array_merge(array('Post.status <>'=>'trash'),$conditions);	
	
		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.status','Post.type','Post.slug','Post.created','User.id','User.username'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);

		$d['posts'] = $this->Paginate('Post');

		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		$this->Post->contain();

		$count = $this->Post->find('all',array(
			'fields'=>array('Post.status','COUNT(Post.id) AS total'),
			'conditions'=>array('Post.type'=>'post'),
			'group'=>'Post.status'
		));

		foreach ($count as $k => $v)
			$d['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];

		$d['totalElement'] = $d['totalElement'] = (empty($status)) ? $d['total'] : $d['total'.ucfirst($status)];;

		$d['status'] = $status;

		$this->set($d);
	}

	/*
	*	Fonction qui affiche les pages par auteur
	*/
	function admin_author($author = null){
		
		$author = (!empty($author)) ? $author : 'admin';

		$this->Post->contain('User');

		$d['posts'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.status','Post.type','Post.slug','Post.created','User.id','User.username'),
			'conditions'=>array('Post.type'=>'post','User.username'=>$author),
			'limit'=>Configure::read('elements_per_page')
		));

		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		$this->Post->contain();

		$count = $this->Post->find('all',array(
			'fields'=>array('Post.status','COUNT(Post.id) AS total'),
			'conditions'=>array('Post.type'=>'post'),
			'group'=>'Post.status'
		));

		foreach ($count as $k => $v)
			$d['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];

		$d['totalElement'] = count($d['pages']);

		$d['status'] = '';

		$this->set($d);
	}

	/*
	*	Fonction qui met un article à la corbeille
	*/

	function admin_trash($id){
		
		if ($this->request->is('get')) 
        	throw new MethodNotAllowedException();

    	$this->Post->id = $id;
    	$this->Post->saveField('status','trash');
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui retire un article à la corbeille
	*/

	function admin_untrash($id){
		
		if ($this->request->is('get')) 
        	throw new MethodNotAllowedException();

    	$this->Post->id = $id;
    	$this->Post->saveField('status','draft');
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui supprime un article
	*/

	function admin_delete($id){
		
		if ($this->request->is('get')) 
        	throw new MethodNotAllowedException();

    	$this->Post->id = $id;
    	$this->Post->delete($id);
    	$this->Session->setFlash("L'article a bien été supprimé","notif");
    	$this->redirect($this->referer());
	}

	/*
	* Fonction qui permet d'editer un article
	*/
	function admin_edit($id = null){
		
		if ($this->request->is('post') || $this->request->is('put')) {

			if($this->Post->save($this->request->data)){
			
			if($id)
				$this->Session->setFlash('Le contenu a bien été modifié','notif');
			else
				$this->Session->setFlash('Le contenu a bien été ajouté','notif');

			$this->redirect(array('action'=>'index'));
			}
			else
				$this->Session->setFlash('Merci de corriger vos erreurs','notif',array('type'=>'error'));	
			
		}
		elseif($id){
			$this->Post->id = $id;
			$this->request->data = $this->Post->read(array('Post.id','Post.name','Post.content','Post.slug','Post.status'));
		}
		
		$d['list_status'] = array(
			'publish'=>'Publié',
			'draft'=>'Brouillon'
		);

		$d['status_selected'] = 'publish';
		$this->set($d);
	}
}
 ?>