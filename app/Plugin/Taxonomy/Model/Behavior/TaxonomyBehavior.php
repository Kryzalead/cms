<?php 
class TaxonomyBehavior extends ModelBehavior{
	
	/*
	*	Fonction d'initialisation du comportement
	*	Cette fonction est lancé dès le chargement du modèle
	*	@params1 : $model : model sur lequel le comportement est greffé
	*	@params2 : $options de configuration
	*/
	public function setup($model,$options = array()){
		
		// on ajoute la laison HABTM au modèle
		$model->hasAndBelongsToMany['Term'] = array(
			'associationForeignKey'	=>	'term_id', // clé d'association
			'with'					=>	'Taxonomy.TermR', // table de liaison qui se trouve dans le pluggin
			'foreignKey'			=>	'object_id', //clé étrangére
			'joinTable'				=>	'term_relationships',
			'conditions'			=>array('object'=>$model->name)
		);
	}
} 
?>