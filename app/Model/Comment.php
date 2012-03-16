<?php
class Comment extends AppModel{

	public $actsAs = array('Containable');

	public $belongsTo = array(
		'Post'=>array(
			'counterCache'=>true,
			'counterScope'=>array('Comment.approved'=>1)
		),
		'User'
	);

	public $recursive = -1;

	public $validate = array(
		'author'=>array(
			'rule'=>'notEmpty',
			'required'=>true
		),
		'author_email'=>array(
			'rule'=>'email',
			'required'=>true
		),
		'content'=>array(
			'rule'=>'notEmpty',
			'required'=>true
		)
	);

	function beforeSave($data){
		$this->data['Comment']['approved'] = 0;
		$this->data['Comment']['user_id'] = 0;
		return $this->data;
	}
}