<?php 

App::uses('Sanitize', 'Utility');

class UsersController extends AppController{
	
	/*
	*	Fonction de connexion
	*/
	function login(){
		$this->set('title_for_layout','Connexion');
		
		$this->layout = 'login';
		// si des datas ont été postées
		if($this->request->is('post')){
			// vérfication grâce à la fonction login de Auth
			if($this->Auth->login()){
				// si tout est ok, on redirige vers la page qu'on souhaite
				$token = md5(time()*rand(85,945));
				$this->Session->write('Security.token',$token);
				return $this->redirect(array('controller'=>'dashboard','action'=>'index','admin'=>true));
			}
			else{
				$this->Session->setFlash("Identifiants incorrect","notif",array('type'=>'error'));
			}	
		}
	}

	/*
	*	Fonction de déconnexion
	*/
	function logout(){
		$this->Auth->logout();
		$this->Session->setFlash("Vous êtes bien déconnecté","notif");
		$this->redirect('/');
	}

	function admin_index($role = ''){

		$d['title_for_layout'] = 'Utilisateurs';

		$this->User->contain(array(
			'User_meta'=>array(
				'conditions'=>array(
					'OR'=>array(array('meta_key'=>'first_name'),array('meta_key'=>'last_name'))
				)
			)
		));

		$conditions = array();

		if(!empty($this->request->query['search'])){
			$search = Sanitize::clean($this->request->query['search']);
			$conditions = array_merge(array('User.username LIKE'=>'%'.$search.'%'),$conditions);
		}
		else{
			$conditions = (!empty($role)) ? array_merge(array('User.role'=>$role),$conditions) : array();
		}

		$this->paginate = array(
			'fields'=>array('User.id','User.username','User.email','User.role','User.page_count','User.post_count'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);

		$d['users'] = $this->Paginate('User');

		$d['totalAdmin'] = $d['totalUser'] = 0;

		$this->User->contain();

		// on récupère le nombre total de d'utilisateur par role
		$count = $this->User->find('all',array(
			'fields'	=>	array('User.role','COUNT(User.id) AS total'),
			'group'		=>	'User.role'
		));

		foreach ($count as $key => $value) {
			$d['total'.ucfirst($value['User']['role'])] = $value[0]['total'];
		}

		$d['total'] = $d['totalAdmin'] + $d['totalUser'];

		$d['totalElement'] = (empty($role)) ? $d['total'] : $d['total'.ucfirst($role)];

		$d['list_action'] = array(
			'0'=>'Actions groupées',
			'delete'=>'Supprimer'
		);
		
		$this->set($d);
	}

	function admin_doaction(){
		parent::doaction('utilisateur');
	}
	
	function admin_delete($id){

		if ($this->request->is('get')) 
        	throw new MethodNotAllowedException();

    	$this->User->id = $id;
    	$this->User->delete($id);
    	$this->Session->setFlash("L'utilisateur a bien été supprimé","notif");
    	$this->redirect($this->referer());
	}
	
	function admin_edit($id = null){
		
		$d['texte_submit'] = 'Ajouter un utilisateur';
		$d['title_for_layout'] = 'Ajouter un utilisateur';

		if($this->request->is('post') || $this->request->is('put')){
			
			if($this->request->data['User']['password'] != $this->request->data['User']['passwordconfirm']){
				$this->Session->setFlash("Les mots de passe ne correspondent pas","notif",array('type'=>'error'));
			}
			else{
				if(empty($this->request->data['User']['password']))
					unset($this->request->data['User']['password']);

				$this->User->contain('User_meta');

				$this->User->set($this->request->data);
				$this->User->User_meta->set($this->request->data);

				if($this->User->validates() & $this->User->User_meta->validates()){

					$this->User->save($this->request->data,array('validate'=>false));

					if($id)
						$this->Session->setFlash("L'utilisateur a bien été modifié","notif");
					else
						$this->Session->setFlash("L'utilisateur a bien été ajouté","notif");

					$this->redirect(array('action'=>'index'));
				}
				else{
					$this->Session->setFlash("Merci de corriger vos erreurs","notif",array('type'=>'error'));
				}
			}
		}
		elseif($id){
			
			if($id == $this->Session->read('Auth.User.id'))
				$d['title_for_layout'] = 'Profil';
			else
				$d['title_for_layout'] = "Modifier l'utilisateur";

			$d['texte_submit'] = 'Mettre à jour le profil';
				
			$this->User->contain(array(
				'User_meta'=>array(
					'conditions'=>array(
						'OR'=>array(
							array('meta_key'=>'first_name'),
							array('meta_key'=>'last_name')
						)
					)
				)
			));
			$this->User->id = $id;
			$this->request->data = $this->User->read(array('User.id','User.username','User.email','User.siteweb','User.role'));
		}

		$d['roles'] = array(
			'admin'=>'Administrateur',
			'user'=>'Utilisateur'
		);

		$this->set($d);
	}	
}
 ?>