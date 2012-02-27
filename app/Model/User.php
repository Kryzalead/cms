<?php 
class User extends AppModel{

	public $actsAs = array('Containable');

	public $hasMany = array(
		'Post',
		'User_meta'=>array(
			'dependent'=>true
		)
	);

	public $recursive = -1;

	public $validate = array(
		'username'	=>	array(
			'required'	=>	array(
				'rule'		=>	'notEmpty',
				'required'	=>	true,
				'message'	=>	'Vous devez entrer un identifiant'
			),
			'isUnique'	=>	array(
				'rule'		=>	'isUnique',
				'message'	=>	'Cet identifiant est déjà pris'
			)
		),
		'email'		=>	array(
			'required'	=>	array(
				'rule'		=>	'notEmpty',
				'required'	=>	true,
				'message'	=>	'Votre email est obligatoire'
			),
			'email'		=>	array(
				'rule'		=>	'email',
				'message'	=>	'Votre email n\'est pas valide'
			)	
		),
		'siteweb'	=>	array(
			'rule'		=>	'url',
			'allowEmpty'=>	true,
			'message'	=>	'L\'url de votre site n\'est pas valide'
		),
		'password'	=>	array(
			'rule'		=>	'notEmpty',
			'required'	=>	true,
			'on'		=>	'create',
			'message'	=>	'Votre mot de passe est vide'
		)
	);

	function afterFind($data){
		
		// On crée des index supplémentaires
		// totalPost : donne le nombre de pages pour un utilisateur
		// meta : récupère les métas de chaque utilisateur

		foreach ($data as $k => $v) {
			if(!empty($v['User_meta'])){
				$data[$k]['User_meta'] = Set::Combine($v['User_meta'],'{n}.meta_key','{n}.meta_value');
			}
			else
				$data[$k]['User_meta'] = array();
			
		}
		return $data;
	}

	function beforeSave($data){
		if(!empty($this->data['User']['password'])){
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}

		return true;
	}

	function afterSave($data){
		$user_id = $this->id;

		$data = array();
		if(!empty($this->data['User_meta'])){
			foreach ($this->data['User_meta'] as $k => $v) {
				if(!empty($v)){
					$data[] = array(
						'user_id'=>$user_id,
						'meta_key'=>$k,
						'meta_value'=>$v
					);	
				}
			}
			
			if(!empty($this->data['User']['id']))
				$this->User_meta->deleteAll(array('user_id'=>$user_id));
			
			if(!empty($data))	
				$this->User_meta->saveAll($data,array('validate'=>'false'));	
		}

		return true;
	}
}
 ?>