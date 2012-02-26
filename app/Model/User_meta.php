<?php 
class User_meta extends AppModel{
	
	public $belongsTo = array('User');

	public $validate = array(
		'last_name'	=>	array(
			'rule'		=>	'#^[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+[ \-\']?[[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+[ \-\']?]*[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+$#',
			'allowEmpty'=>	true,
			'message'	=>	'Le champ n\'est pas valide'
		),
		'first_name' =>	array(
			'rule'		=>	'#^[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+[ \-\']?[[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+[ \-\']?]*[a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ]+$#',
			'allowEmpty'=>	true,
			'message'	=>	'Le champ n\'est pas valide'
		)
	);

	function afterFind($data){
		if(!empty($data[0]['User_meta'])){
			$meta = $data[0]['User_meta'];
			if( $meta['meta_key'] == 'first_name')
				$meta['meta_value'] = ucfirst($meta['meta_value']);
			if( $meta['meta_key'] == 'last_name')
				$meta['meta_value'] = strtoupper($meta['meta_value']);
			$data[0]['User_meta'] = $meta;	
		}
		return $data;		
			
	}
}
 ?>