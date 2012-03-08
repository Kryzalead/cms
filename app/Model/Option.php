<?php
class Option extends AppModel{
	
	public $validate = array(
		'site_name'=>array(
			'rule'=>'notEmpty',
			'message'=>"Votre site n'a pas de nom"
		),
		'admin_email'=>array(
			'rule'=>'email',
			'message'=>"L'adresse de messagerie n'est pas valide"
		)
	);
}