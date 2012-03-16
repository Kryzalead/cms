<?php
class Post extends AppModel{
	
	public $actsAs = array('Containable','Taxonomy.taxonomy');
	
	public $belongsTo = array(
        'User',
        'UserPost' => array(
            'counterCache' => true,
            'foreignKey' => 'user_id',
            'className' => 'User',
            'counterScope' => array('Post.type'=>'post','Post.status'=>'publish')
        ),
        'UserPage' => array(
            'counterCache' => 'page_count',
            'foreignKey' => 'user_id',
            'className' => 'User',
            'counterScope' => array('Post.type'=>'page','Post.status'=>'publish')
        )    
    );

    public $hasMany = array('Menu_post'=>array('dependent'=>true),'Comment'=>array('dependent'=>true));

	public $recursive = -1;
	
	public $validate = array(
		'slug'	=>	array(
			'rule'			=>	'/^[a-z0-9\-]+$/',
			'allowEmpty'	=>	true,
			'message'		=>	"L'url n'est pas valide"
		),
		'name'	=>	array(
			'rule'			=>	'notEmpty',
			'message'		=>	'Le titre ne peut être vide'
		),
		'content'=> array(
			'rule'			=>	'notEmpty',
			'message'		=>	'Le contenu ne peut être vide'
		)
	);

	/*
	*	Fonction a executer après avoir récupéré les datas
	*/
	function afterFind($data){
		
		// création d'un index link
		// cet index servira dans les liens pour les vues
		foreach ($data as $k => $v) {
			if (isset($v['Post']['id']) && isset($v['Post']['slug'])) {
				$v['Post']['link'] = array(
					'controller' 	=> 	Inflector::pluralize($v['Post']['type']),
					'action'		=>	'view',
					'type'			=>	$v['Post']['type'],
					'id'			=>	$v['Post']['id'],
					'slug'			=>	$v['Post']['slug']
				);
			}
			if(!empty($v['Comment'])){
				$v['Post']['totalWaiting'] = count($v['Comment']);
			}
			else
				$v['Post']['totalWaiting'] = 0;
			$data[$k] = $v;
		}
		return $data;
	}

	/*
	*	Fonction a executer avant l'enregistrement
	*/
	function beforeSave($data){
		if(empty($this->data['Post']['slug']) && isset($this->data['Post']['slug']) && !empty($this->data['Post']['name'])){
			$this->data['Post']['slug'] = strtolower(Inflector::slug($this->data['Post']['name'],'-'));		
		}
		return true;
	}

	/*
	* Fonction à executer après un enregistrement
	*/
	function afterSave($data){
		if(!empty($this->data['Post']['slug'])){
			
			$id = $this->id;
			if($this->data['Post']['type'] == 'post')
				$guid = 'http://'.$_SERVER['HTTP_HOST'].Router::url('/').'blog/'.$this->data['Post']['slug'].'-'.$id;
			else
				$guid = 'http://'.$_SERVER['HTTP_HOST'].Router::url('/').$this->data['Post']['slug'].'.html';
			$this->saveField('guid',$guid);
		}
		return true;
	}

	function initCat(){
		$this->TermR->save(array(
			'object'=>'Post',
			'object_id'=>$this->id,
			'term_id'=>Configure::read('default_post_category')
		));
		return true;
	}
}
 ?>