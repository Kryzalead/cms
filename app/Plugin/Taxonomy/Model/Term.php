<?php
class Term extends AppModel{
	
	public $hasMany = array(
		'TermR'=>array(
			'className'=>'Taxonomy.TermR',
			'dependent'=>true
		)
	);

	public $recursive = -1;

}		