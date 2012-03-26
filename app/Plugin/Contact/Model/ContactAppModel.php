<?php
class ContactAppModel extends AppModel{
	
	public $useTable = false;

	public $validate = array(
		'name'=>array(
			'rule'=>'notEmpty',
			'required'=>true,
			'message'=>'Votre nom est requis'
		),
		'email'=>array(
			'rule'=>'email',
			'required'=>true,
			'message'=>"Votre email n'est pas valide"
		),
		'message'=>array(
			'rule'=>'notEmpty',
			'required'=>true,
			'message'=>"Il ne manquerai pas le message ?"
		)
	);

	function send($data){

		$this->set($data);
		if($this->validates()){
			App::uses('CakeEmail','Network/Email');
			$mail = new CakeEmail();
			$mail->to('elscorto@gmail.com')
				 ->from($data['email'])
				 ->subject('contact')
				 ->emailFormat('html')
				 ->template('contact')
				 ->viewVars($data);

			return $mail->send();
		}
		else
			return false;
	}
	
}