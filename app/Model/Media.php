<?php 
class Media extends AppModel{
	
	public $useTable = 'posts';
	public $hasMany = array('Post_meta');
	public $belongsTo = array('User');

	public $validate = array(
		'name'	=>	array(
			'rule'		=>	'notEmpty',
			'message'	=>	'Le titre ne peut être vide'
		)
	);
}
 ?>