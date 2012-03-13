<?php 
App::uses('Sanitize', 'Utility');

class PostsController extends AppController{

	/*
	* Fonction qui affiche la page d'acceuil
	*/
	function home(){

		$id = $this->request->params['page_on_front'];
		$this->Post->id = $id;
		$slug = $this->Post->field('slug');

		$post = Cache::read('Page.slug_'.$slug);

		if(empty($post)){
			$post = $this->Post->find('first',array(
				'fields'=>array('Post.id','Post.name','Post.slug','Post.type','Post.content'),
				'conditions'=>array('Post.slug'=>$slug,'Post.type'=>'page')
			));

			if(empty($post))
				throw new NotFoundException('Erreur 404');
			else{
				Cache::write('Page.slug_'.$slug,$post);
			}
		}

		$d['post'] = $post;
		$d['title_for_layout'] = 'Accueil | '.Configure::read('site_name');
		$this->set($d);
		$this->render('view');
	}

	/*
	*	Fonction affichant les derniers articles
	*/

	function index(){

		$d['title_for_layout'] = 'Blog | '.Configure::read('site_name');
		
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
	*	Fonction affichant un post
	*/
	function view(){

		$type = $this->request->params['type'];
		$slug = $this->request->params['slug'];

		if($type == 'post'){
			
			$id = $this->request->params['id'];

			$this->Post->contain(array('User'=>array('fields'=>array('User.username')),'Term'));

			$post = $this->Post->find('first',array(
				'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.created','Post.type'),
				'conditions'=>array('Post.id'=>$id,'Post.type'=>'post')
			));

			if(empty($post))
				throw new NotFoundException('Erreur 404');

			if ($slug != $post['Post']['slug']) 
				$this->redirect($post['Post']['link'],301);

			$d['title_for_layout'] = $post['Post']['slug'].' | Blog | '.Configure::read('site_name');
			

		}
		elseif($type == 'page'){

			$post = Cache::read('Page.slug_'.$slug);

			if(empty($post)){
				$post = $this->Post->find('first',array(
					'fields'=>array('Post.id','Post.name','Post.slug','Post.type','Post.content'),
					'conditions'=>array('Post.slug'=>$slug,'Post.type'=>'page')
				));

				if(empty($post))
					throw new NotFoundException('Erreur 404');
				else{
					Cache::write('Page.slug_'.$slug,$post);
				}
			}
			
			$d['title_for_layout'] = $post['Post']['slug'].' | '.Configure::read('site_name');			
		}
		else{
			throw new NotFoundException('Erreur 404');
		}

		$d['post'] = $post;
		$this->set($d);
	}

	/************ ADMINISTRATION ******************/

	function admin_index(){

		// on récupère le type de post
		$type = !empty($this->request->query['type']) ? $this->request->query['type'] : 'post';
		if(!in_array($type, array('post','page'))){
			$this->layout = 'error-page';
			$d['message'] = "Type d’article invalide";
			$this->set($d);
			$this->render('/errors/error-page');return;
		}	
		$d['type'] = $type;

		// on récupère le status demandé
		// si il est vide, on le met à all
		$status = !empty($this->request->query['status']) ? $this->request->query['status'] : 'all';
		$d['status'] = $status;


		// variable des textes de la vue
		$d['title_for_layout'] = $type == 'page' ? 'Pages' : 'Articles';
		$d['icon_for_layout'] = $type == 'page' ? 'icone-pages.png' : 'icone-posts.png';
		$d['text_for_add_post'] = $type == 'page' ? 'Ajouter une page' : 'Ajouter un article';
		$d['text_for_submit_search'] = $type == 'page' ? 'Rechercher dans les pages' : 'Rechercher dans les articles';

		// début des conditions
		$conditions = array('Post.type'=>$type);

		$find_status = true;

		// si une recherche a été demandée
		if(!empty($this->request->query['s'])){
			$search = Sanitize::clean($this->request->query['s']);
			$conditions = array_merge($conditions,array(
				'OR'=>array(
					array('Post.name LIKE'=>'%'.$search.'%'),
					array('Post.content LIKE'=>'%'.$search.'%')
				)
			));
			
			$d['search'] = $search;
		}
		else{
			if(!empty($this->request->query['author'])){
				$conditions = array_merge($conditions,array('Post.user_id'=>$this->request->query['author'],'Post.status <>'=>'trash'));
				$find_status = false;
			}
		}

		if($find_status){
			if(!empty($status)){
				if($status != 'all')
					$conditions = array_merge($conditions,array('Post.status'=>$status));
				else
					$conditions = array_merge($conditions,array('Post.status <>'=>'trash'));
			}	
			else
				$conditions = array_merge($conditions,array('Post.status <>'=>'trash'));

			
		}

		// ajout des contain
		if($type == 'post')
			$this->Post->contain(array('User','Term'));
		elseif($type == 'page')
			$this->Post->contain('User');
		
		// on prépare la pagination
		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.status','Post.type','Post.slug','Post.created','User.id','User.username'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);

		$d['posts'] = $this->Paginate('Post');

		// initialisation des compteur de la vue
		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		// on enlève les contain
		$this->Post->contain();


		$count = $this->Post->find('all',array(
			'fields'=>array('Post.status','COUNT(Post.id) AS total'),
			'conditions'=>array('Post.type'=>$type),
			'group'=>'Post.status'
		));

		// assignation des compteurs
		foreach ($count as $k => $v)
			$d['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];

		// si une recherche, totalElement vaut le total de post trouvés
		if(!empty($search))
			$d['totalElement'] = count($d['posts']);
		else
			$d['totalElement'] = $d['totalElement'] = (empty($status) || $status == 'all') ? $d['total'] : $d['total'.ucfirst($status)];

		// préparation de la list do_action
		$d['list_action'] = array(
			'0'=>'Action groupées'
		);
		switch ($status) {
			case '':
			case 'publish':
			case 'all':
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

		// on set les datas
		$this->set($d);
	}

	function admin_post(){

		$action = $this->request->query['action'];
		$id = $this->request->query['id'];

		$this->Post->id = $this->request->query['id'];
		switch ($action) {
			case 'trash':
				$this->Post->saveField('status','trash');
				$this->Session->setFlash("Element déplacé dans la corbeille","notif");
				break;
			case 'untrash':
				$this->Post->saveField('status','draft');
				$this->Session->setFlash("Element retiré de la corbeille","notif");
				break;
			case 'delete':
				if(empty($this->request->query['token']))
					$this->redirect('/');
				elseif($this->Session->read('Security.token') != $this->request->query['token'])
					$this->redirect('/');
				
				$this->Post->delete();
				$this->Session->setFlash("Element supprimé","notif");
				break;	
			default:
				# code...
				break;
		}
		$this->redirect($this->referer());
	}

	function admin_doaction(){
		$action = $this->request->data['Post']['action'];
		$type = $this->request->data['Post']['type'];
		$count = 0;
		
		unset($this->request->data['Post']['action']);
		unset($this->request->data['Post']['type']);

		foreach ($this->request->data['Post'] as $k => $v) {
			if(!empty($v)){
				$this->Post->id = $k;
				if($action != 'delete'){
					$this->Post->saveField('status',$action);
				}
				else{
					$this->Post->delete();
				}
				$count ++;
			}	
		}

		$texte = $type == 'post' ? 'article' : 'page';
		if($count > 0){
			$terminaison = ($count > 1 ) ? 's' : '';
			$feminin = $type == 'page' ? 'e' : '';
			switch ($action) {
				case 'publish':
					$this->Session->setFlash($count." ".$texte.$terminaison." publié".$feminin.$terminaison,"notif");
					break;
				case 'draft':
					$this->Session->setFlash($count." ".$texte.$terminaison." déplacé".$feminin.$terminaison." dans les brouillons","notif");
					break;	
				case 'trash':
					$this->Session->setFlash($count." ".$texte.$terminaison." déplacé".$feminin.$terminaison." dans la corbeille","notif");
					break;
				case 'delete':
					$this->Session->setFlash($count." ".$texte.$terminaison." supprimé".$feminin.$terminaison,"notif");
					break;
				default:
					break;
			}
		}
		$this->redirect(array('action'=>'index','?'=>array('type'=>$type)));
	}

	function admin_new(){
		
	}
	/*
	* Fonction qui permet d'editer un article
	*/
	function admin_edit(){

		$type = (!empty($this->request->query['type'])) ? $this->request->query['type'] : 'post';
		$d['type'] = $type;

		$id = !empty($this->request->query['id']) ? $this->request->query['id'] : 0;

		$d['title_for_layout'] = $type == 'post' ? 'Ajouter un nouvel article' : 'Ajouter une nouvelle page';
		$d['icon_for_layout'] = $type == 'post' ? 'icone-posts-add.png' : 'icone-pages-add.png';
		$d['texte_submit'] = 'Publier';
		
		$this->Post->contain('Term');

		if($this->request->is('post') || $this->request->is('put')) {

			if($this->Post->save($this->request->data)){
				if(empty($this->request->data['Post']['terms']))
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
			$d['title_for_layout'] = $type == 'post' ? "Modifier l'article" : "Modifier la page";
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