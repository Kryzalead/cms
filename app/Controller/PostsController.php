<?php 
App::uses('Sanitize', 'Utility');

class PostsController extends AppController{

	protected $alllow_post_type = array('post','page');
	protected $allow_post_status = array('all','publish','draft','trash');

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
		$this->request->params['named']['page'] = $this->params['page'];
		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.type','Post.created','Post.comment_count'),
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

			$this->Post->contain(array(
				'User'=>array(
					'fields'=>array('User.username')
				),
				'Term',
				'Comment'=>array(
					'fields'=>array('Comment.id','Comment.author','Comment.author_email','Comment.author_url','Comment.created','Comment.content'),
					'conditions'=>array('Comment.approved'=>1)
				)
			));

			$post = $this->Post->find('first',array(
				'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.created','Post.type','Post.comment_count'),
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

	function viewterm($type = null,$slug = null){

		$term = $this->Post->Term->find('first',array(
			'fields'=>array('Term.id','Term.name'),
			'conditions'=>array('Term.type'=>$type,'Term.slug'=>$slug)
		));
		if(empty($term))
			throw new NotFoundException('Erreur 404');
		
		$term_id = $term['Term']['id'];
		
		$term_posts = $this->Post->Term->TermR->find('all',array(
			'conditions'=>array('TermR.term_id'=>$term_id)
		));

		$object_ids = array();
		foreach ($term_posts as $k => $v) {
			$object_ids[] = $v['TermR']['object_id'];
		}

		$this->Post->contain(array('User'=>array('fields'=>array('User.username')),'Term'));

		$d['posts'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.slug','Post.content','Post.type','Post.created'),
			'conditions'=>array(
				'Post.id'=>$object_ids
			),
			'order'=>'Post.created DESC',
		));

		if($type == 'category')
			$d['type'] = 'Catégorie';
		elseif($type == 'tag')
			$d['type'] = 'Mot-Clef';
		
		$d['term'] = $term['Term']['name'];

		$this->set($d);
		

	}

	/************ ADMINISTRATION ******************/

	function admin_index(){

		// on récupère le type de post
		$type = !empty($this->request->query['type']) ? $this->request->query['type'] : 'post';
		
		if(!in_array($type, $this->alllow_post_type)){
			$this->error("Type d’article invalide");
			return;
		}
				
		$d['type'] = $type;

		// on récupère le status demandé
		// si il est vide, on le met à all
		$status = !empty($this->request->query['status']) ? $this->request->query['status'] : 'all';
		if(!empty($status)){
			if(!in_array($status, $this->allow_post_status)){
				$status = '';
			}
		}
		$d['status'] = $status;


		// variable des textes de la vue
		$d['title_for_layout'] = $type == 'page' ? 'Pages' : 'Articles';
		$d['icon_for_layout'] = $type == 'page' ? 'icone-pages.png' : 'icone-posts.png';
		$d['text_for_add_post'] = $type == 'page' ? 'Ajouter une page' : 'Ajouter un article';
		$d['text_for_submit_search'] = $type == 'page' ? 'Rechercher dans les pages' : 'Rechercher dans les articles';
		
		$d['data_for_top_table'] = array(
			'action'=>'index',
			'params'=>array('type'=>$type),
			'list'=>array(
				'all'=>'Tous',
				'publish'=>'Publiés',
				'draft'=>'Brouillons',
				'trash'=>'Corbeille'
			),
			'current'=>$status
		);

		// début des conditions
		$conditions = array('Post.type'=>$type);

		$find_status = true;
		$find_by_term = false;

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
				$conditions = array_merge($conditions,array('Post.user_id'=>$this->request->query['author']));
				$find_status = false;
			}
			if(!empty($this->request->query['category'])){
				$find_by_term = true;
				$find_status = false;
				$term_slug = $this->request->query['category'];
				$term_type = 'category';
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
		else
			$conditions = array_merge($conditions,array('Post.status <>'=>'trash'));
		

		// ajout des contain
		if($type == 'post')
			$this->Post->contain(array('User','Term'));
		elseif($type == 'page')
			$this->Post->contain('User');

		// on prépare la pagination
		$this->paginate = array(
			'fields'=>array('Post.id','Post.name','Post.status','Post.type','Post.slug','Post.created','Post.comment_count','User.id','User.username'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);
		
		$d['posts'] = $this->Paginate('Post');

		if($find_by_term){
			$data = array();
			foreach ($d['posts'] as $k => $v) {
				$post_id = $v['Post']['id'];
				foreach ($v['Term'] as $k1 => $v1) {
					if($v1['type'] == $term_type && $v1['slug'] == $term_slug){
						$data[] = $d['posts'][$k];
					}
				}
			}
			$d['posts'] = $data;
		}

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
		foreach ($count as $k => $v){
			$d['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
			$d['data_for_top_table']['count']['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
		}
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];
		$d['data_for_top_table']['count']['total'] = $d['total'];

		// si une recherche, totalElement vaut le total de post trouvés
		if(!empty($search) || !empty($find_by_term))
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
		$this->Post->id =$id;
		
		$post_type = $this->Post->field('type');
		
		if(empty($post_type)){
			$this->error("Voulez-vous vraiment faire cela ?");
			return;
		}

		
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

	/*
	* Fonction qui permet d'editer un article
	*/
	function admin_edit(){


		$type = (!empty($this->request->query['type'])) ? $this->request->query['type'] : 'post';
		
		if(!in_array($type, $this->alllow_post_type)){
			$this->error("Type d’article invalide");
			return;
		}

		$id = !empty($this->request->query['id']) ? $this->request->query['id'] : 0;
		if(!is_numeric($id))
			$this->redirect(array('action'=>'index','?'=>array('type'=>$type)));
		
		if(!empty($id)){
			$this->Post->id = $id;
			$post_type = $this->Post->field('type');
			if(!empty($post_type)){
				if($type != $post_type)
					$this->redirect(array('action'=>'edit','?'=>array('type'=>$post_type,'id'=>$id)));
			}
			else{
				$this->error("Vous tentez de modifier un contenu qui n’existe pas. Peut-être a-t-il été supprimé ?");
				return;
			}
		}
		
		$d['type'] = $type;
		$d['title_for_layout'] = $type == 'post' ? 'Ajouter un nouvel article' : 'Ajouter une nouvelle page';
		$d['icon_for_layout'] = $type == 'post' ? 'icone-posts-add.png' : 'icone-pages-add.png';
		$d['texte_submit'] = 'Publier';
		
		if($type == 'post')
			$this->Post->contain('Term');

		if($this->request->is('post') || $this->request->is('put')) {

			if($this->Post->save($this->request->data)){
				if(empty($this->request->data['Post']['terms']))
					if($this->request->data['Post']['type'] == 'post')
						$this->Post->initCat();
			
			$action = $this->request->data['Post']['action'];
			$type =  $this->request->data['Post']['type'];

			if($action == 'upd')
				$message = $type == 'post' ? "L'article a bien été modifié" : "La page a bien été modifiée";	
			elseif($action == 'add')
				$message = $type == 'post' ? "L'article a bien été publié" : "La page a bien été publiée";
			
			$this->Session->setFlash($message,'notif');

			$this->redirect(array('action'=>'index','?'=>array('type'=>$type)));
			}
			else
				$this->Session->setFlash('Merci de corriger vos erreurs','notif',array('typeMessage'=>'error'));	
			
		}
		elseif($id){
			$d['title_for_layout'] = $type == 'post' ? "Modifier l'article" : "Modifier la page";
			$d['texte_submit'] = 'Mettre à jour';
			$d['action'] = 'upd';

			$this->Post->id = $id;
			$post = $this->Post->read(array('Post.id','Post.name','Post.content','Post.slug','Post.status','Post.type'));
			
			if(empty($post)){
				$this->error("Vous tentez de modifier un contenu qui n’existe pas. Peut-être a-t-il été supprimé ?");
				return;
			}

			$this->request->data = $post;
		}
		else{
			$d['action'] = 'add';
			$last_id = current($this->Post->find('first',array(
				'fields'=>'MAX(id) AS maxid',
			)));
			
			$this->request->data['Post']['id'] = $last_id['maxid'] + 1;

		}

		if($type == 'post')
			$d['terms'] = $this->Post->getFixedTerms();

		$d['list_status'] = array(
			'publish'=>'Publié',
			'draft'=>'Brouillon'
		);

		$d['status_selected'] = 'publish';
		$this->set($d);
	}

	function admin_tinymce(){
		
		$this->layout = 'modal';

		if($this->request->is('post') || $this->request->is('put')){
			$d['content'] = $this->request->data['Post']['content'];
			$d['src'] = $this->request->data['Post']['link-src'];
			$d['title'] = $this->request->data['Post']['link-title'];

			$this->layout = null;
			$this->set($d);
			$this->render('tinymce');
			return;
		}

		$d['posts'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.type','Post.guid'),
			'conditions'=>array(
				'OR'=>array(
					array('Post.type'=>'post'),
					array('Post.type'=>'page')
				),
				'Post.status <>'=>'trash'
			)
		));

		$this->request->data['Post']['link-title'] = (!empty($this->request->query['title'])) ? $this->request->query['title'] : '';
		$this->request->data['Post']['link-src'] = (!empty($this->request->query['src'])) ? $this->request->query['src'] : '';
		$this->request->data['Post']['content'] = $this->request->query['content'];

		$this->set($d);
	}
}
 ?>