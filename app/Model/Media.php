<?php 
class Media extends AppModel{
	
	public $actsAs = array('Containable');
	public $useTable = 'posts';

	public $belongsTo = array('User');
	public $hasMany = array(
		'Post_meta'=>array(
			'dependent'=>true
		)
	);

	public function afterFind($data){

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
					}

					if($v1['meta_key'] == 'attachment_image_alt'){
						$data[$k]['Media']['alt'] = $v1['meta_value'];
					}
				}	
			}
		}
		return $data;
	}
}
 ?>