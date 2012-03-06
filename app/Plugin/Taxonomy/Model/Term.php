<?php
class Term extends AppModel{
	
	public $hasMany = array(
		'TermR'=>array(
			'className'=>'Taxonomy.TermR',
			'dependent'=>true
		)
	);

	public $recursive = -1;

	public $validate = array(
		'name'=>array(
			'rule'=>'notEmpty',
			'message'=>'Le champ ne peut être vide'
		)
	);

	function beforeSave($data){
		
		if(empty($this->data['Term']['slug'])){
			$this->data['Term']['slug'] = strtolower(Inflector::slug($this->data['Term']['name'],'-'));
		}
		return true;
	}

	function beforeDelete($data){
		$this->TermR->updateAll(array('term_id'=>1),array('term_id'=>$this->id));
		return true;
	}

}		