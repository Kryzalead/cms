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
		'prix'=>array(
			'rule'=>'numeric',
			'allowEmpty'	=>	true,
			'message'=>"Le prix doit être de type numéric"
		)
	);
	public $actsAs = array('Containable','Taxonomy.taxonomy'=>array('fixed'=>array('product_category','product_taille','product_creator')));

	public $hasMany = array('Product_meta'=>array('dependent'=>true),'Product_attachement'=>array('dependent'=>true));

	public $recursive = -1;

	function beforeDelete($data){
		$product = current($this->read('slug'));
		
		$dossier = IMAGES.'catalogue'.DS.$product['slug'];
		$this->deltree($dossier);
		return true;
		
	}

	function deltree($dossier){
		if(($dir=opendir($dossier))===false)
            return;
 
        while($name=readdir($dir)){
            if($name==='.' or $name==='..')
                continue;
            $full_name=$dossier.'/'.$name;
 
            if(is_dir($full_name)){
                $this->deltree($full_name);
            }
            else unlink($full_name);
            }
 
        closedir($dir);
	}
}