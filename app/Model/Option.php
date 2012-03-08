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
		),
		'default_post_edit_rows'=>array(
			'rule'=>'numeric',
			'message'=>"Le champs doit être un nombre"
		)
	);
}