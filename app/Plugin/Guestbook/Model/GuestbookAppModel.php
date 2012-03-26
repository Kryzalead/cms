<?php
class GuestbookAppModel extends AppModel{

	public $validate = array(
		'author'=>array(
			'rule'=>'notEmpty',
			'required'=>true,
			'message'=>'Votre nom est requis'
		),
		'author_email'=>array(
			'rule'=>'email',
			'required'=>true,
			'message'=>"Votre email n'est pas valide"
		),
		'author_url'=>array(
			'rule'=>'url',
			'allowEmpty'=>true,
			'message'=>"Votre site web n'est pas valide"
		),
		'content'=>array(
			'rule'=>'notEmpty',
			'required'=>true,
			'message'=>"Il ne manquerai pas le message ?"
		)
	);

}