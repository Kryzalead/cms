<?php 
class ContactsController extends ContactAppController {
	
	function contact(){
		$d['title_for_layout'] = 'Contact | '.Configure::read('site_name');
		if($this->request->is('post')){
			if(!empty($this->request->data['Contact']['site'])){
				$this->Session->setFlash("Le message a bien été envoyé","notif");
				$this->redirect($this->referer());
			}
			else{
				if($this->Contact->send($this->request->data['Contact'])){
					$this->Session->setFlash("Le message a bien été envoyé","notif");
					$this->redirect($this->referer());
				}
				else
					$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
			}
		}
		$this->set($d);
	}	
}
 ?>