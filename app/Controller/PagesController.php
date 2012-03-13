<?php 

App::uses('Sanitize', 'Utility');

class PagesController extends AppController{

	public $uses = array('Post');


	/************ ADMINISTRATION ******************/

	

	
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