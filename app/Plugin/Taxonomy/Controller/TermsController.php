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

	function admin_edit($term = null,$id = null){
		
		$taxo = $this->Term->find('count',array(
			'conditions'=>array('Term.type'=>$term)
		));

		if($taxo){
			switch ($term) {
			case 'category':
				$d['title_for_layout'] = 'Catégories';
				if($id){
					$d['text_form'] = 'Modifier une catégorie';
					$d['text_for_submit'] = 'Mettre à jour';
				}
				else{
					$d['text_form'] = 'Ajouter une catégorie';
					$d['text_for_submit'] = 'Ajouter une catégorie';	
				}
				break;
			default:
				# code...
				break;
			}
			if($this->request->is('post') || $this->request->is('put')){
				$this->Term->save($this->request->data);
				switch ($term) {
					case 'category':
						if($id)
							$message = 'La catégorie a bien été modifiée';
						else
							$message = 'La catégorie a bien été crée';	
						break;
					default:
						# code...
						break;
				}
				$this->Session->setFlash($message,"notif");
				$this->redirect(array('action'=>'edit',$term));
			}
			elseif($id){
				$this->Term->id = $id;
				$this->request->data = $this->Term->read();
			}
			$this->paginate = array(
				'fields'=>array('Term.id','Term.name','Term.slug','Term.type'),
				'conditions'=>array('Term.type'=>$term)
			);
			$d['list_term'] = $this->Paginate('Term');
			$d['type_term'] = $term;
			$this->set($d);
		}
		else
			$this->set('erreur_taxo',"La Taximonie demandée est invalide");
	}

	function admin_delete($term = null,$id = null){
		$this->Term->id = $id;
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
		$this->redirect(array('action'=>'edit',$term));
	}
}
 ?>