<?php 
class Media extends AppModel{
	
	public $actsAs = array('Containable');
	public $useTable = 'posts';
	public $validExtension = array('jpg','png','jpeg','gif');
	public $validMimetype = array('image/jpeg', 'image/png', 'image/gif');

	public $belongsTo = array('User');
	public $hasMany = array(
		'Post_meta'=>array(
			'dependent'=>true
		)
	);

	public $validate = array(
		'name'=>array(
			'rule'=>'notEmpty',
			'message'=>"Vous devez mettre un nom au média"
		)
	);

	function afterFind($data){
		foreach ($data as $k => $v) {
			if(!empty($v['Post_meta'])){
				$metas = $v['Post_meta'];
				foreach ($metas as $k1 => $v1) {
					$tab = array();
					if($v1['meta_key'] == 'attachment_metadata'){
						$tab = unserialize($v1['meta_value']);
						$origin_file = $tab['origins']['file'];
						$origin_filename = end(explode('/',$origin_file));
						$data[$k]['Media']['thumbnail'] = str_replace($origin_filename, $tab['thumbnail']['file'], $origin_file);
						$data[$k]['Media']['size'] = $tab['origins']['width'].'*'.$tab['origins']['height'];
					}

					$data[$k]['Media']['alt'] = '';
					
					if($v1['meta_key'] == 'attachment_image_alt'){
						$data[$k]['Media']['alt'] = $v1['meta_value'];
					}
				}	
			}
		}
		return $data;
	}

	function beforeSave($data){
		if(!empty($this->data['Media']['file'])){
			$file = $this->data['Media']['file'];
			$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
			$this->data['Media']['slug'] = strtolower(Inflector::slug($this->data['Media']['name'],'-'));
			$this->data['Media']['mime_type'] = $file['type'];
			$this->data['Media']['guid'] = 'http://'.$_SERVER['HTTP_HOST'].Router::url('/').'img/'.date('Y').'/'.date('m').'/'.$this->data['Media']['slug'].'.'.$file_extension;	
		}
		return true;
	}

	function afterSave($data){
		if(!empty($this->data['Media']['file'])){
			$dir = IMAGES.date('Y');
			if(!file_exists($dir)){
				mkdir($dir,'0777');
			}
			$dir .= DS.date('m');
			if(!file_exists($dir)){
				mkdir($dir,'0777');
			}

			$file_slug = $this->data['Media']['slug'];

			$file = $this->data['Media']['file'];
			$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
			$file_infos = getimagesize($file['tmp_name']);
			$file_width = $file_infos[0];
			$file_height = $file_infos[1];

			$post_id = $this->id;

			$attachment_metadata = array(
				'origins'	=>	array(
					'width'	=>	$file_width,
					'height'=>	$file_height,
					'file'	=>	date('Y').'/'.date('m').'/'.$file_slug.'.'.$file_extension
				),
				'thumbnail'	=>	array(
					'width'	=>	Configure::read('thumbnail_size_w'),
					'height'=>	Configure::read('thumbnail_size_h'),
					'file'	=>	$file_slug.'_t'.'.'.$file_extension
				),
				'medium'	=>	array(
					'width'	=>	Configure::read('medium_size_w'),
					'height'=>	Configure::read('medium_size_h'),
					'file'	=>	$file_slug.'_m'.'.'.$file_extension
				),
				'large'	=>	array(
					'width'	=>	Configure::read('large_size_w'),
					'height'=>	Configure::read('large_size_h'),
					'file'	=>	$file_slug.'_l'.'.'.$file_extension
				),
				'post-thumbnail'	=>	array(
					'width'	=>	Configure::read('large_size_w'),
					'height'=>	Configure::read('large_size_h'),
					'file'	=>	$file_slug.'_l'.'.'.$file_extension
				)
			);

			$metadatas = array(
				array(
					'post_id'	=>	$post_id,
					'meta_key'	=>	'attached_file',
					'meta_value'=>	date('Y').'/'.date('m').'/'.$file_slug.'.'.$file_extension	
				),array(
					'post_id'	=>	$post_id,
					'meta_key'	=>	'attachment_metadata',
					'meta_value'=>	serialize($attachment_metadata)
				)
			);

			$this->contain('Post_meta');
			$this->Post_meta->saveAll($metadatas);	
		}
	}

	function beforeDelete($data){
		$meta = current($this->Post_meta->find('first',array(
			'fields'=>array('meta_value'),
			'conditions'=>array(
				'post_id'=>$this->id,
				'meta_key'=>'attachment_metadata'
			)
		)));
		$files = unserialize($meta['meta_value']);
		$path['origin'] = $files['origins']['file'];

		$origin_name = end(explode('/',$path['origin']));

		$path['thumbnail'] = str_replace($origin_name, $files['thumbnail']['file'], $path['origin']);
		$path['medium'] = str_replace($origin_name, $files['medium']['file'], $path['origin']);
		$path['large'] = str_replace($origin_name, $files['large']['file'], $path['origin']);

		foreach ($path as $v) {
			unlink(IMAGES.$v);
		}
		return true;
	}

	function isValidUpload($data){
		if($data['size'] == 0)
			return false;

		if($data['error'] != 0)
			return false;

		return true;	
	}

	function isValidImage($data){

		$file_extension = pathinfo($data['name'], PATHINFO_EXTENSION);
		if(!in_array(strtolower($file_extension),$this->validExtension))
			return false;

		$type_mime = $data['type'];
		if(!in_array(strtolower($type_mime),$this->validMimetype))
			return false;
		
		// vérification supplémentaire pour les tailles et poids
		return true;
	}
}
 ?>