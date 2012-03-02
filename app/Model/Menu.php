<?php 
class Menu extends AppModel{
	
	public $actsAs = array('Containable');

	public $hasMany = array('Menu_post'=>array('dependent'=>true));

	public $recursive = -1;

	public $validate = array(
		'name'=>array(
			'rule'=>'notEmpty'
		)
	);
	function beforeSave($data){
		$this->data['Menu']['slug'] = strtolower(Inflector::slug($this->data['Menu']['name'],'-'));
		$this->data['Menu']['count'] = 0;
		return $data;
	}
}
?>