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

	function getFixedTerms($model){
		return $model->Term->find('list',array(
			'fields'=>array('Term.id','Term.name','Term.type'),
			'conditions'=>array('Term.type'=>$this->settings['fixed'])
		));
	}

	function afterFind($model,$data){
		foreach ($data as $k => $v) {
			if(!empty($v['Term'])){
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
	}

	function deleteTerms($model){
		$terms = $model->Term->find('list',array(
			'fields'=>array('Term.id','Term.id'),
			'conditions'=>array('Term.type'=>$this->settings['fixed'])
		));
		$model->Term->TermR->deleteAll(array(
			'object'=>$model->name,
			'object_id'=>$model->id,
			'term_id'=>$terms
		));
	}
} 
?>