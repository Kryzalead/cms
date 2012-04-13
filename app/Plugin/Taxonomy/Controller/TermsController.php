<?php 
class TermsController extends TaxonomyAppController{
	
	function admin_deleteR($id = null){
		$this->Term->TermR->id = $id;
		$term_id = $this->Term->TermR->field('term_id');

		$this->Term->TermR->delete($id);

		$count = $this->Term->TermR->find('count',array(
			'conditions'=>array('term_id'=>$term_id)
		));

		if($count == 0)
			$this->Term->delete($term_id);

		die();
	}

	function admin_addR($object,$object_id){
		
		$type = $this->request->query['type'];
		
		if(isset($this->request->query['id'])) 
			$term_id = $this->request->query['id'];
		else{
			$d = array(
				'name'=>$this->request->query['name'],
				'type'=>$type
			);

			$term = $this->Term->find('first',array(
				'fields'=>array('id'),
				'conditions'=>$d
			));

			if(empty($term)){
				$d['slug'] = strtolower(Inflector::slug($this->request->query['name'],'-'));
				$this->Term->save($d);
				$term_id = $this->Term->id;
			}
			else{
				$term_id = $term['Term']['id'];
			}
		}
		$d = array(
			'object'=>$object,
			'object_id'=>$object_id,
			'term_id'=>$term_id
		);

		$count = $this->Term->TermR->find('count',array(
			'conditions'=>$d
		));

		if($count == 0){
			$this->Term->TermR->save($d);
			$url = Router::url(array('action'=>'deleteR',$this->Term->TermR->id));
			die('<span style="margin-right: 25px;display: block;float: left;font-size: 11px;line-height: 1.8em;white-space: nowrap;cursor: default;"><a class="delTaxo" href="'.$url.'">x </a>'.strtoupper($this->request->query['name']).'</span>');
		}
		else
			die();
	}

	function admin_search(){
		$terms = $this->Term->find('list',array(
			'fields'=>array('id','name'),
			'conditions'=>array(
				'name LIKE'=>'%'.$this->request->query['term'].'%',
				'type'=>$this->request->query['type']
			)
		));

		$json = array();
		foreach ($terms as $id => $name) {
			$json[] = array('id'=>$id,'label'=>$name);
		}
		die(json_encode($json));
	}

	function admin_edit(){

		$term = $this->request->query['type'];
		$term_id = (!empty($this->request->query['id'])) ? $this->request->query['id'] : '' ;
		
		$count = $this->Term->find('all',array(
			'fields'=>array('id'),
			'conditions'=>array('Term.type'=>$term)
		));

		if(empty($count)){
			$this->error("La Taximonie demandée est invalide");
			return;
		}

		switch ($term) {
			case 'category':
				$d['title_for_layout'] = 'Catégories';
				if($term_id){
					$d['text_form'] = 'Modifier une catégorie';
					$d['text_for_submit'] = 'Mettre à jour';
				}
				else{
					$d['text_form'] = 'Ajouter une catégorie';
					$d['text_for_submit'] = 'Ajouter une catégorie';	
				}
				break;
			case 'product_category':
				$d['title_for_layout'] = 'Catégories accessoires';
				if($term_id){
					$d['text_form'] = "Modifier une catégorie d'accessoire";
					$d['text_for_submit'] = 'Mettre à jour';
				}
				else{
					$d['text_form'] = "Ajouter une catégorie d'accessoire";
					$d['text_for_submit'] = 'Ajouter une catégorie';	
				}
				break;
			case 'product_taille':
				$d['title_for_layout'] = 'Tailles';
				if($term_id){
					$d['text_form'] = 'Modifier une taille';
					$d['text_for_submit'] = 'Mettre à jour';
				}
				else{
					$d['text_form'] = 'Ajouter une taille';
					$d['text_for_submit'] = 'Ajouter une taille';	
				}
				break;
			case 'product_creator':
				$d['title_for_layout'] = 'Créateurs';
				if($term_id){
					$d['text_form'] = 'Modifier un créateur';
					$d['text_for_submit'] = 'Mettre à jour';
				}
				else{
					$d['text_form'] = 'Ajouter un créateur';
					$d['text_for_submit'] = 'Ajouter un créateur';	
				}
				break;
			default:
				# code...
				break;
		}

		if($this->request->is('post') || $this->request->is('put')){
			if($this->Term->save($this->request->data)){
				switch ($term) {
					case 'category':
						if($term_id)
							$message = 'La catégorie a bien été modifiée';
						else
							$message = 'La catégorie a bien été crée';	
						break;
					case 'product_category':
						if($term_id)
							$message = 'La catégorie accessoire a bien été modifiée';
						else
							$message = 'La catégorie accessoire a bien été crée';	
						break;
					case 'product_taille':
						if($term_id)
							$message = 'La taille a bien été modifiée';
						else
							$message = 'La taille a bien été crée';	
						break;
					case 'product_creator':
						if($term_id)
							$message = 'Le créateur a bien été modifié';
						else
							$message = 'Le créateur a bien été crée';	
						break;
					default:
						# code...
						break;
				}
				$this->Session->setFlash($message,"notif");
				$this->redirect(array('action'=>'edit','?'=>array('type'=>$term)));
			}
			else
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
			
		}
		elseif($term_id){

			$count = $this->Term->find('count',array(
				'conditions'=>array('Term.id'=>$term_id)
			));

			if($count == 0){
				$this->error("Vous tentez de modifier un contenu qui n’existe pas. Peut-être a-t-il été supprimé ?");
				return;
			}

			$this->Term->id = $term_id;
			$this->request->data = $this->Term->read();
		}

		$this->paginate = array(
			'fields'=>array('Term.id','Term.name','Term.slug','Term.type'),
			'conditions'=>array('Term.type'=>$term),
			'order'=>'slug ASC'
		);
		
		$d['list_term'] = $this->Paginate('Term');
		$d['type_term'] = $term;
		
		$this->set($d);
		
	}

	function admin_delete(){

		$term = $this->request->query['type'];

		$count = $this->Term->find('count',array(
			'conditions'=>array('Term.type'=>$term)
		));

		if($count == 0){
			$this->error("La Taximonie demandée est invalide");
			return;
		}

		$term_id = $this->request->query['id'];
		
		$count = $this->Term->find('count',array(
			'conditions'=>array('Term.id'=>$term_id)
		));

		if($count == 0){
			$this->error("Vous tentez de modifier un contenu qui n’existe pas. Peut-être a-t-il été supprimé ?");
			return;
		}

		$this->Term->id = $term_id;
		$this->Term->delete();
		switch ($term) {
			case 'category':
				$message = 'La catégorie a bien été supprimée';
				break;
			default:
				# code...
				break;
		}
		$this->Session->setFlash($message,"notif");
		$this->redirect(array('action'=>'edit','?'=>array('type'=>$term)));
	}
}
 ?>