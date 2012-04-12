<?php
class Product extends CatalogAppModel{
	
	public $validate = array(
		'name'=>array(
			'rule'=>'notEmpty',
			'message'=>"Le champs ne peut être vide"
		),
		'slug'	=>	array(
			'rule'			=>	'/^[a-z0-9\-]+$/',
			'allowEmpty'	=>	true,
			'message'		=>	"L'url n'est pas valide"
		),
		'url'=>array(
			
		)
	);
	public $actsAs = array('Containable','Taxonomy.taxonomy'=>array('fixed'=>array('product_category','product_taille','product_creator')));

	public $hasMany = array('Product_meta'=>array('dependent'=>true),'Product_attachement'=>array('dependent'=>true));

	public $recursive = -1;
}