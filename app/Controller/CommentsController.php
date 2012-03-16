<?php
class CommentsController extends AppController{
	
	var $components = array('RequestHandler');

	function post(){

		if($this->request->is('post')){
			$this->request->data['Comment']['author_ip'] = $this->RequestHandler->getClientIp();
			if($this->Comment->save($this->request->data)){
				$this->Session->setFlash("Merci de votre commentaire","notif");
				$this->redirect($this->referer());
			}
			else{
				$this->Session->setFlash("Le commentaire n'a pu être posté car il contient des erreurs","notif",array('typeMessage'=>'error'));
				$this->redirect($this->referer());
			}
		}
	}
}