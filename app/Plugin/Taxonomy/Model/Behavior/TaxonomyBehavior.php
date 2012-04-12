<?php 
class TaxonomyBehavior extends ModelBehavior{
	
	protected $_defaults = array();

	/*
	*	Fonction d'initialisation du comportement
	*	Cette fonction est lancé dès le chargement du modèle
	*	@params1 : $model : model sur lequel le comportement est greffé
	*	@params2 : $options de configuration
	*/
	public function setup($model,$options = array()){
		
		// on ajoute la laison HABTM au modèle
		$model->hasAndBelongsToMany['Term'] = array(
			'className'				=>	'Taxonomy.Term',
			'associationForeignKey'	=>	'term_id', // clé d'association
			'with'					=>	'Taxonomy.TermR', // table de liaison qui se trouve dans le pluggin
			'foreignKey'			=>	'object_id', //clé étrangére
			'joinTable'				=>	'term_relationships',
			'conditions'			=>array('object'=>$model->name)
		);

		$this->settings = array_merge($this->_defaults,$options);
	}

	function getFixedTerms($model,$slug){
		if(!empty($slug)){
			return $model->Term->find('list',array(
				'fields'=>array('Term.id','Term.name','Term.type'),
				'conditions'=>array('Term.type'=>$slug),
				'order'=>'name ASC'
			));
		}
		return $model->Term->find('list',array(
			'fields'=>array('Term.id','Term.name','Term.type'),
			'conditions'=>array('Term.type'=>$this->settings['fixed'])
		));
	}

	function afterFind($model,$data){
		foreach ($data as $k => $v) {
			if(!empty($v['Term'])){
				if($model->name == 'Product'){
					foreach ($v['Term'] as $k1 => $v1) {
						$data[$k][$model->name]['terms_'.$v1['type']] = Set::Combine($v['Term'],'{n}.id','{n}.id');
					}
				}
				$data[$k][$model->name]['terms'] = Set::Combine($v['Term'],'{n}.id','{n}.id');
				$data[$k]['Taxonomy'] = Set::Combine($v['Term'],'{n}.id','{n}','{n}.type');
			}
		}
		return $data;
	}

	function afterSave($model){
		if(isset($model->data[$model->name]['terms'])){
			$model->deleteTerms();
			$terms = $model->data[$model->name]['terms'];
			foreach ($terms as $term_id) {
				$model->Term->TermR->create();
				$model->Term->TermR->save(array(
					'term_id'=>$term_id,
					'object'=>$model->name,
					'object_id'=>$model->id	
				));
			}
		}
		if(isset($model->data[$model->name]['terms_product_creator'])){
			$model->deleteTerms('product_creator');
			$terms = $model->data[$model->name]['terms_product_creator'];
			$model->Term->TermR->create();
			$model->Term->TermR->save(array(
				'term_id'=>$terms,
				'object'=>$model->name,
				'object_id'=>$model->id	
			));
			
		}
		if(isset($model->data[$model->name]['terms_product_taille'])){
			$model->deleteTerms('product_taille');
			$terms = $model->data[$model->name]['terms_product_taille'];
			if(!empty($terms)){
				$model->Term->TermR->create();
				foreach ($terms as $term_id) {
					$model->Term->TermR->create();
					$model->Term->TermR->save(array(
						'term_id'=>$term_id,
						'object'=>$model->name,
						'object_id'=>$model->id	
					));
				}
			}
			
		}
		if(isset($model->data[$model->name]['terms_product_category'])){
			$model->deleteTerms('product_category');
			$terms = $model->data[$model->name]['terms_product_category'];
			$model->Term->TermR->create();
			$model->Term->TermR->save(array(
				'term_id'=>$terms,
				'object'=>$model->name,
				'object_id'=>$model->id	
			));
		}
	}

	function deleteTerms($model,$slug = null){
		if(!empty($slug)){
			$terms = $model->Term->find('list',array(
				'fields'=>array('Term.id','Term.id'),
				'conditions'=>array('Term.type'=>$slug)
			));
		}
		else{
			$terms = $model->Term->find('list',array(
				'fields'=>array('Term.id','Term.id'),
				'conditions'=>array('Term.type'=>$this->settings['fixed'])
			));
		}
		
		$model->Term->TermR->deleteAll(array(
			'object'=>$model->name,
			'object_id'=>$model->id,
			'term_id'=>$terms
		));
	}
} 
?>