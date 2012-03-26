<?php 
class GuestbooksController extends GuestbookAppController {
	
	var $components = array('RequestHandler','Session');

	function index(){

		$d['title_for_layout'] = "Livre d'or - ".Configure::read('site_name');
		if($this->request->is('post')){

			if(!empty($this->request->data['Guestbook']['site'])){
				$this->Session->setFlash("Merci de votre commentaire","notif");
				$this->redirect($this->referer());
			}
			$this->Guestbook->set($this->request->data);
			if($this->Guestbook->validates()){
				$this->request->data['Guestbook']['author_ip'] = $this->RequestHandler->getClientIp();

				$this->Guestbook->save(array('validate'=>false));
				$this->Session->setFlash("Merci de votre commentaire,celui ci apparaitra quand il sera validé","notif");
				$this->redirect($this->referer());
			}
			else{
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
			}
		}

		$conditions = array();
		if($this->Session->read('Auth.User.role') != 'admin')
			$conditions = array_merge($conditions,array('Guestbook.approved'=>1));

		$d['guestbooks'] = $this->Guestbook->find('all',array(
			'fields'=>array('Guestbook.id','Guestbook.created','Guestbook.content','Guestbook.author','Guestbook.author_url','Guestbook.approved'),
			'conditions'=>$conditions
		));

		$d['totalComments'] = count($d['guestbooks']);

		$this->set($d);
	}

	function admin_valid(){

		if(empty($this->request->query['token']))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $this->request->query['token'])
			$this->redirect('/');

		$message = $this->Guestbook->find('first',array(
			'fields'=>array('Guestbook.id','Guestbook.approved'),
			'conditions'=>array('Guestbook.id'=>$this->request->query['id'])
		));

		if(empty($message)){
			$this->error("Le message ne peut être validé car il n'existe pas");
			return;
		}

		if($message['Guestbook']['approved'] == 1)
			$this->redirect($this->referer());

		$this->Guestbook->id = $this->request->query['id'];
		$this->Guestbook->saveField('approved',1);
		$this->redirect($this->referer());
	}

	function admin_delete(){

		if(empty($this->request->query['token']))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $this->request->query['token'])
			$this->redirect('/');

		$message = $this->Guestbook->find('first',array(
			'fields'=>array('Guestbook.id'),
			'conditions'=>array('Guestbook.id'=>$this->request->query['id'])
		));

		if(empty($message)){
			$this->error("Le message ne peut être supprimé car il n'existe pas");
			return;
		}

		$this->Guestbook->id = $this->request->query['id'];
		$this->Guestbook->delete();
		$this->redirect($this->referer());
	}
}
 ?>