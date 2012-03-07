<?php 

App::uses('Sanitize', 'Utility');

class PagesController extends AppController{

	public $uses = array('Post');

	/*
	*	Fonction affichant une page
	*/

	function view($id = null,$slug = null){
		
		if ($id == null) {
			throw new NotFoundException("Pas de page");
		}

		$page = Cache::read('Page.id_'.$id);

		if(!$page){
			$page = $this->Post->find('first',array(
				'fields'=>array('Post.id','Post.name','Post.content','Post.slug','Post.type'),
				'conditions'=>array('Post.id'=>$id)
			));

			if(empty($page)){
				throw new NotFoundException('Erreur 404');
			}
			else{
				Cache::write('Page.id_'.$id,$page);
			}
		}
		
		if($slug != $page['Post']['slug']){
				$this->redirect($page['Post']['link'],301);
		}
		
		$d['page'] = $page;

		$this->set($d);
	}

	/************ ADMINISTRATION ******************/

	function admin_index($status = ''){

		$d['title_for_layout'] = 'Pages';
		
		$this->Post->contain('User');

		$conditions = array('Post.type'=>'page');

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

		$d['pages'] = $this->Paginate('Post');

		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		$this->Post->contain();

		$count = $this->Post->find('all',array(
			'fields'=>array('Post.status','COUNT(Post.id) AS total'),
			'conditions'=>array('Post.type'=>'page'),
			'group'=>'Post.status'
		));

		foreach ($count as $k => $v)
			$d['total'.ucfirst($v['Post']['status'])] = $v[0]['total'];
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];

		$d['totalElement'] = $d['totalElement'] = (empty($status)) ? $d['total'] : $d['total'.ucfirst($status)];;

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

		$d['title_for_layout'] = 'Pages';
		
		$author = (!empty($author)) ? $author : 'admin';

		$this->Post->contain('User');

		$d['pages'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.status','Post.type','Post.slug','Post.created','User.id','User.username'),
			'conditions'=>array('Post.type'=>'page','User.username'=>$author),
			'limit'=>Configure::read('elements_per_page')
		));

		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		$this->Post->contain();

		$count = $this->Post->find('all',array(
			'fields'=>array('Post.status','COUNT(Post.id) AS total'),
			'conditions'=>array('Post.type'=>'page'),
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
	*	Fonction qui met une page à la corbeille
	*/

	function admin_trash($id,$token = null){
		
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

    	$this->Post->id = $id;
    	$this->Post->saveField('status','trash');
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui retire une page à la corbeille
	*/

	function admin_untrash($id){
    	$this->Post->id = $id;
    	$this->Post->saveField('status','draft');
    	$this->redirect($this->referer());
	}

	/*
	*	Fonction qui supprime une page
	*/

	function admin_delete($id,$token = null){
		
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

    	$this->Post->id = $id;
    	$this->Post->delete();
    	$this->Session->setFlash("La page a bien été supprimé","notif");
    	$this->redirect(array('action'=>'index'));
	}

	function admin_doaction(){
		parent::doaction('page');
	}

	/*
	* Fonction qui permet d'editer une page
	*/
	function admin_edit($id = null){

		$d['title_for_layout'] = 'Ajouter une nouvelle page';
		$d['texte_submit'] = 'Publier';
		
		if ($this->request->is('post') || $this->request->is('put')) {

			if($this->Post->save($this->request->data)){
			
			if($id)
				$this->Session->setFlash('La page a bien été modifiée','notif');
			else
				$this->Session->setFlash('La page a bien été ajoutée','notif');

			$this->redirect(array('action'=>'index'));
			}
			else
				$this->Session->setFlash('Merci de corriger vos erreurs','notif',array('type'=>'bad'));	
			
		}
		elseif($id){

		$d['title_for_layout'] = 'Modifier la page';
		$d['texte_submit'] = 'Mettre à jour';

			$this->Post->id = $id;
			$this->request->data = $this->Post->read(array('Post.id','Post.name','Post.content','Post.slug','Post.status','Post.type'));
		}
		
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
				)
			)
		));

		$this->request->data['Post']['link-title'] = (!empty($this->request->query['title'])) ? $this->request->query['title'] : '';
		$this->request->data['Post']['link-src'] = (!empty($this->request->query['src'])) ? $this->request->query['src'] : '';
		$this->request->data['Post']['content'] = $this->request->query['content'];

		$this->set($d);
	}
}
 ?>