<?php
class AppController extends Controller{

	public $helpers = array('date','Html','Form','Session','Text','Cache','Taxonomy.Taxonomy');
	public $components = array('Session','Auth');
	
	/*
	*	Fonction qui s'excute avant tout autre fonction du controller
	*/
	public function beforeFilter(){
		
		// on importe le controller Options
		App::import('Controller','Options');
		$this->Options = new OptionsController();
		// on initialise le controller Options pour récupérer toutes la configuration du site
		$this->Options->init();

		// défini l'action à appeller pour se connecter
		// on place le prefix admin à false pour que ça n'apparaisse pas dans l'url
		$this->Auth->loginAction = array('controller'=>'users','action'=>'login','admin'=>false);

		// on demande à utiliser le système d'autorisation par controller
		$this->Auth->authorize = array('Controller');

		// si on a pas de prefixe de défini, on autorise tout
		if(!isset($this->request->params['prefix'])){
			$this->Auth->allow();
		}
			

		// si un prefixe existe et si il vaut admin
		// on met le layout d'administration
		if(isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin'){
			$this->layout = 'admin';
			// on envois aux vues le controller actuel sur lequel on est pour le menu
			$this->set('currentController',$this->request->controller);
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
			'admin'=>10,
			'user'=>5
		);
		if(isset($roles[$this->request->params['prefix']])){
			$lvlAction  = $roles[$this->request->params['prefix']];
			$lvlUser	= $roles[$user['role']];
			if($lvlUser >= $lvlAction)
				return true;
			else{
				$this->Session->setFlash("Vous n'avez pas la permission d'y accéder","notif",array('type'=>'error'));
				return false;
			}
		}
		return false;
	}
}
 ?>