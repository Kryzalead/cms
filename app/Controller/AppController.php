<?php
class AppController extends Controller{

	public $helpers = array('date','Html','Form','Session','Text','Cache','Taxonomy.Taxonomy');
	public $components = array('Session','Auth','RequestHandler');
	
	/*
	*	Fonction qui s'excute avant tout autre fonction du controller
	*/
	public function beforeFilter(){
		
		// on importe le controller Options
		App::import('Controller','Options');
		$this->Options = new OptionsController();
		// on initialise le controller Options pour récupérer toute la configuration du site
		$this->Options->init();

		// défini l'action à appeller pour se connecter
		// on place le prefix admin à false pour que ça n'apparaisse pas dans l'url
		$this->Auth->loginAction = array('plugin'=>false,'controller'=>'users','action'=>'login','admin'=>false);

		// on demande à utiliser le système d'autorisation par controller
		$this->Auth->authorize = array('Controller');

		// si on a pas de prefixe de défini, on autorise tout
		if(!isset($this->request->params['prefix'])){
			$this->Auth->allow();
		}
			
		// si un prefixe existe et si il vaut admin
		// on met le layout d'administration
		if(isset($this->request->params['prefix'])){
			if ($this->request->params['prefix'] == 'admin' || $this->request->params['prefix'] == 'superadmin') {
				$this->layout = 'admin';
				// on envois aux vues le controller actuel sur lequel on est pour le menu
				$this->set('currentController',$this->request->controller);
			}
			
		}
		else{
			if(Configure::read('site_offline') == 1){
				$this->layout = 'offline-page';
				$this->set('content',Configure::read('content_site_offline'));
				
			}
		}
	}

	/*
	*	Fonction permettant de définir les autorisations
	*/
	function isAuthorized($user){
		
		// si aucun préfix n'est entré, celà signifie que le visiteur est sur la partie publique du site
		if(!isset($this->request->params['prefix']))
			return true;

		// définition du tableau des roles
		$roles = array(
			'superadmin'=>10,
			'admin'=>9,
			'editor'=>8,
			'user'=>5
		);
		if(isset($roles[$this->request->params['prefix']])){
			$lvlAction  = $roles[$this->request->params['prefix']];
			$lvlUser	= $roles[$user['role']];
			if($lvlUser >= $lvlAction){
				return true;
			}
				
			else{
				$this->Session->setFlash("Vous n'avez pas l'accès à cette page","notif");
				return false;
			}
		}
		return false;
	}

	function error($message){
		$this->layout = 'error-page';
		$this->set('message',$message);
		$this->render('/errors/error-page');
	}
}
 ?>