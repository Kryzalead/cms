<?php 
App::uses('Sanitize', 'Utility');

class PostsController extends AppController{

	/*
	*	Fonction affichant les derniers articles
	*/

	function index(){
		
		$this->Post->contain(array('User'=>array('fields'=>array('User.username')),'Term'));

		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.type','Post.created'),
			'conditions'=>array(
				'Post.type'=>'post',
				'Post.status'=>'publish'
			),
			'order'=>'Post.created DESC',
			'limit'=>Configure::read('posts_per_page')
		);
		$d['posts'] = $this->Paginate('Post');
		$this->set($d);
	}

	/*
	*	Fonction affichant un article
	*/
	function view($id = null,$slug = null){
		
		if ($id == null) 
			throw new NotFoundException("Pas d'article");

		$this->Post->contain(array('User'=>array('fields'=>array('User.username')),'Term'));

		$post = $this->Post->find('first',array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.created','Post.type'),
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
		
		$d['title_for_layout'] = 'Articles';
		
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

		$d['totalElement'] = $d['totalElement'] = (empty($status)) ? $d['total'] : $d['total'.ucfirst($status)];

		$d['status'] = $status;

		$d['list_action'] = array(
			'0'=>'Action groupées'
		);
		switch ($status) {
			case '':
			case 'publish':
				$d['list_action'] = array_merge($d['list_action'],array('draft'=>'Déplacer dans les brouillons','trash'=>'Déplacer dans la corbeille'));
				break;
			case 'draft':
				$d['list_action'] = array_merge($d['list_action'],array('publish'=>'Déplacer dans les publications','trash'=>'Déplacer dans la corbeille'));
				break;	
			case 'trash':
				$d['list_action'] = array_merge($d['list_action'],array('draft'=>'Restaurer','delete'=>'Supprimer définitivement'));
				break;			default:
				# code...
				break;
		}

		$this->set($d);
	}

	/*
	*	Fonction qui affiche les pages par auteur
	*/
	function admin_author($author = null){
		
		$d['title_for_layout'] = 'Articles';

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

		$d['totalElement'] = count($d['posts']);

		$d['status'] = '';

		$this->set($d);
	}

	/*
	*	Fonction qui met un article à la corbeille
	*/

	function admin_trash($id,$token = null){
		
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

    	$this->Post->id = $id;
    	$this->Post->saveField('status','trash');
    	$this->Session->setFlash("Article déplacé dans la corbeille","notif");
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui retire un article à la corbeille
	*/

	function admin_untrash($id){

    	$this->Post->id = $id;
    	$this->Post->saveField('status','draft');
    	$this->Session->setFlash("Article retiré de la corbeille","notif");
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui supprime un article
	*/

	function admin_delete($id,$token = null){
		
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

    	$this->Post->id = $id;
    	$this->Post->delete();
    	$this->Session->setFlash("L'article a bien été supprimé","notif");
    	$this->redirect(array('action'=>'index'));
	}

	function admin_doaction(){
		parent::doaction('article');
	}

	/*
	* Fonction qui permet d'editer un article
	*/
	function admin_edit($id = null){

		$d['title_for_layout'] = 'Ajouter un nouvel article';
		$d['texte_submit'] = 'Publier';
		
		$this->Post->contain('Term');

		if ($this->request->is('post') || $this->request->is('put')) {

			if($this->Post->save($this->request->data)){
				if(!$id)
					$this->Post->initCat();
			
			if($id)
				$this->Session->setFlash("L'article a bien été modifié",'notif');
			else
				$this->Session->setFlash("L'article a bien été publié",'notif');

			$this->redirect(array('action'=>'index'));
			}
			else
				$this->Session->setFlash('Merci de corriger vos erreurs','notif',array('type'=>'error'));	
			
		}
		elseif($id){
			$d['title_for_layout'] = "Modifier l'article";
			$d['texte_submit'] = 'Mettre à jour';

			$this->Post->id = $id;
			$this->request->data = $this->Post->read(array('Post.id','Post.name','Post.content','Post.slug','Post.status','Post.type'));
		}
		else{
			$last_id = current($this->Post->find('first',array(
				'fields'=>'MAX(id) AS maxid',
			)));
			
			$this->request->data['Post']['id'] = $last_id['maxid'] + 1;

		}
		$d['terms'] = $this->Post->getFixedTerms();

		$d['list_status'] = array(
			'publish'=>'Publié',
			'draft'=>'Brouillon'
		);

		$d['status_selected'] = 'publish';
		$this->set($d);
	}
}
 ?>