<?php 
class ContactsController extends ContactAppController {
	
	function contact(){
		$d['title_for_layout'] = 'Contact | '.Configure::read('site_name');
		if($this->request->is('post')){
			$this->Contact->send($this->request->data['Contact']);
			$this->Session->setFlash("Le message a bien été envoyé","notif");
			$this->redirect($this->referer());
		}

		$this->set($d);
	}	
}
 ?>