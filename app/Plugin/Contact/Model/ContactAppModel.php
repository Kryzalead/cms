<?php
class ContactAppModel extends AppModel{
	
	public $useTable = false;

	function send($data){

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
}