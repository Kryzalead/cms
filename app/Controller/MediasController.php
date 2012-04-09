<?php 
App::uses('Sanitize', 'Utility');

class MediasController extends AppController{
	
	public $components = array('Img');
	public $allow_attachment_type = array('all','images','videos');

	/*
	*	Fonction index de l'administration
	*/
	function admin_index(){

		$d['title_for_layout'] = 'Bibliothèque';
		
		$mime = !empty($this->request->query['type_mime']) ? $this->request->query['type_mime'] : 'all';
		if(!in_array($mime,$this->allow_attachment_type)){
			$this->error("Type de médias invalide");
			return;
		}
		$d['mime'] = $mime;

		$d['data_for_top_table'] = array(
			'action'=>'index',
			'list'=>array(
				'all'=>'Tous',
				'images'=>'Images',
				'videos'=>'Videos'
			),
			'current'=>$mime
		);

		$conditions = array('Media.type'=>'attachment');

		if(!empty($this->request->query['s'])){
			$search = Sanitize::clean($this->request->query['s']);
			$conditions = array_merge(array('Media.name LIKE'=>'%'.$search.'%'),$conditions);
		}
		
		if($mime == 'images')
			$conditions = array_merge($conditions,array('Media.mime_type'=>'image/jpeg'));
		
		$this->Media->contain(array(
			'User'=>array(
				'fields'=>array('User.id','User.username')
			),
			'Post_meta'
		));

		$this->paginate = array(
			'fields'=>array('Media.id','Media.name','Media.created','Media.mime_type','Media.guid'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);

		$d['medias'] = $this->Paginate('Media');

		$this->Media->contain();

		$count = $this->Media->find('all',array(
			'fields'=>array('Media.mime_type','count(Media.id) AS total'),
			'conditions'=>array('Media.type'=>'attachment'),
			'group'=>'Media.mime_type'
		));

		$d['totalImages'] = $d['totalVideos'] = 0;

		foreach ($count as $k => $v) {
			if($v['Media']['mime_type'] == 'image/jpeg'){
				$d['totalImages'] = $v[0]['total'];
				$d['data_for_top_table']['count']['totalImages'] = $d['totalImages'];
			}
		}

		$d['total'] = $d['totalImages'] + $d['totalVideos'];
		$d['data_for_top_table']['count']['total'] = $d['total'];

		if(!empty($search))
			$d['totalElement'] = count($d['medias']);
		else
			$d['totalElement'] = (empty($mime) || $mime == 'all') ? $d['total'] : $d['total'.ucfirst($mime)];

		$d['list_action'] = array(
			'0'=>'Actions groupées',
			'delete'=>'Supprimer définitivement'
		);

		$this->set($d);
	}

	/*
	*	Fonction qui permet d'éditer un média
	*/
	function admin_edit($id = null){
		
		$d['title_for_layout'] = 'Ajouter un média';
		$d['action'] = 'add';

		$id = !empty($this->request->query['attachment_id']) ? $this->request->query['attachment_id'] : 0;
		if(!is_numeric($id))
			$this->redirect(array('action'=>'index'));

		if($this->request->is('post') || $this->request->is('put')){
			if($this->request->is('post')){
				$this->Media->set($this->request->data);
				if($this->Media->validates()){
					$file = $this->request->data['Media']['file'];
					if($this->Media->isValidUpload($file) && $this->Media->isValidImage($file)){
						$this->Media->save($this->request->data,array('validate'=>false));
						$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
						$file_slug = strtolower(Inflector::slug($this->request->data['Media']['name'],'-'));
						$dir = IMAGES.date('Y'). DS.date('m');
						
						move_uploaded_file($file['tmp_name'], $dir.DS.$file_slug.'.'.$file_extension);
						if($file_extension != 'png' && $file_extension =! 'PNG'){
							$format = array('thumbnail','medium','large'); 
							foreach ($format as $v) {
								$height = Configure::read($v.'_size_h');
								$width = Configure::read($v.'_size_w');
								$this->Img->crop($dir.DS.$file_slug.'.'.$file_extension,$dir.DS.$file_slug.'_'.substr($v, 0,1).'.'.$file_extension,$width,$height);
							}
						}
						
						$this->Session->setFlash("Votre média a bien été ajouté","notif");
						if($this->request->action == 'admin_tinymce')
							$this->redirect(array('action'=>'tinymce','library'));
						$this->redirect(array('action'=>'edit','?'=>array('attachment_id'=>$this->Media->id)));
					}
					else
						$this->Session->setFlash("Une erreur interne s'est produite lors de l'upload du média","notif",array('type'=>'error'));
				}
				else
					$this->Session->setFlash("Merci de corriger vos erreurs","notif",array('type'=>'error'));
			}
			elseif($this->request->is('put')){
				
				if ($this->Media->save($this->request->data)) {
					
					$meta = current($this->Media->Post_meta->find('first',array(
						'fields'=>'id',
						'conditions'=>array('post_id'=>$this->Media->id,'meta_key'=>'attachment_image_alt')
					)));

					if(!empty($this->request->data['Media']['alt'])){
						if(!empty($meta)){
							$this->Media->Post_meta->id = $meta['id'];
							$this->Media->Post_meta->save(array(
								'meta_value'	=>	$this->request->data['Media']['alt']
							));
						}
						else{
							$this->Media->Post_meta->save(array(
								'post_id'	=>	$this->Media->id,
								'meta_key'	=>	'attachment_image_alt',
								'meta_value'=>	$this->request->data['Media']['alt']	
							));	
						}
					}
					else{
						if(!empty($meta)){
							$this->Media->Post_meta->delete($meta['id']);
						}
					}
					
					$this->Session->setFlash("Le média a bien été modifié","notif");
					$this->redirect(array('action'=>'index'));
				}
				else
					$this->Session->setFlash("Merci de corriger vos erreurs","notif",array('type'=>'error'));
			}
			else
				$this->redirect('/');
		}
		elseif($id){
			$d['title_for_layout'] = 'Modifier un média';
			$d['action'] = 'upd';
			$this->Media->id = $id;
			$d['media'] = $this->Media->read(
				array('Media.id','Media.name','Media.created','Media.mime_type','Media.guid','Media.content')
			);

			if(empty($d['media'])){
				$this->error("Vous tentez de modifier un média qui n'existe plus");
				return;
			}

			$this->request->data = $d['media'];
		}
		$this->set($d);
	}

	/*
	*	Fonction qui permet d'éffectuer des actions groupées
	*/
	function admin_doaction(){
		$action = $this->request->data['Media']['action'];
		$count = 0;
		
		unset($this->request->data['Media']['action']);

		foreach ($this->request->data['Media'] as $k => $v) {
			if(!empty($v)){
				$this->Media->id = $k;
				$this->Media->delete();
				$count ++;
			}	
		}
		if($count > 0){
			$terminaison = ($count > 1 ) ? 's' : '';
			$this->Session->setFlash($count." médias supprimé".$terminaison,"notif");

		}
		$this->redirect(array('action'=>'index'));
	}

	/*
	*	Fonction qui supprime un média
	*/
	function admin_delete(){

		if(empty($this->request->query['token']))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $this->request->query['token'])
			$this->redirect('/');
		
		$id = $this->request->query['id'];
		$count = $this->Media->find('count',array(
			'conditions'=>array('Media.id'=>$id)
		));

		if(!$count){
			$this->error("Le médias ne peut être supprimé car il n'existe pas");
			return;
		}

		$this->Media->id = $id;
		$this->Media->delete();
		$this->Session->setFlash("Le médias a bien été supprimé","notif");
		$this->redirect($this->referer());
	}

	/*
	*	Permet l'affichage des médias pour tinymce
	*/
	function admin_tinymce($tabs = 'upload'){
		
		$this->layout = 'modal';

		if($this->request->is('post') || $this->request->is('put')){
			$method = $this->request->data['Media']['method'];
			switch ($method) {
				case 'upload':
					$this->admin_edit();
					return;
					break;
				case 'url':
					$d['src'] = $this->request->data['Media']['src'];
					$d['title'] = (!empty($this->request->data['Media']['title'])) ? $this->request->data['Media']['title'] : '';
					$d['alt'] = (!empty($this->request->data['Media']['alt'])) ? $this->request->data['Media']['alt'] : 'Image utilisateur';
					$d['class'] = $this->request->data['Media']['class'];	

					$this->layout = null;
					$this->set($d);
					$this->render('tinymce');
					return;
					break;
				case 'library':
					
					$d['title'] = $this->request->data['Media']['title'];
					$d['alt'] = (!empty($this->request->data['Media']['alt'])) ? $this->request->data['Media']['alt'] : 'Image utilisateur';
					$d['class'] = $this->request->data['Media']['class'];	

					$file = $this->request->data['Media']['guid'];
					$file_name = end(explode('/',$file));
					$name = current(explode('.',$file_name));

					$size = $this->request->data['Media']['size'];
					if($size == 'thumbnail')
						$src = str_replace($name,$name.'_t', $file);
					elseif($size == 'medium')	
						$src = str_replace($name,$name.'_m', $file);
					elseif($size == 'large')
						$src = str_replace($name,$name.'_l', $file);
					else
						$src = $file;

					$d['src'] = $src;

					$this->set($d);
					$this->layout = null;
					$this->render('tinymce');
					return;
					break;
				default:
					break;
			}
		}

		if($tabs == 'upload'){
			$d['action'] = 'add';
		}
		elseif($tabs == 'url'){
			$d['action'] = 'url';
		}
		elseif($tabs == 'library'){
			$d['taille'] = array(
				'origin'		=> 	'Originale',
				'thumbnail'		=>	'Petite',
				'medium'		=>	'Moyenne',
				'large'			=>	'Grande'
			);
			$this->request->data['Media']['size'] = 'thumbnail';
			$this->admin_index();
		}
		
		$d['current_tabs'] = $tabs;
		
		$d['alignement'] = array(
			'alignLeft'=>'Gauche',
			'alignCenter'=>'Centrer',
			'alignRight'=>'Droite'
		);

		$this->request->data['Media']['class'] = 'alignLeft';

		if(!empty($this->request->query)){
			$this->request->data['Media']['src'] = $this->request->query['src'];
			$this->request->data['Media']['title'] = $this->request->query['title'];
			$this->request->data['Media']['alt'] = (!empty($this->request->data['Media']['alt'])) ? $this->request->data['Media']['alt'] : 'Image utilisateur';
			$this->request->data['Media']['class'] = $this->request->query['class'];
		}

		$this->set($d);
		if($tabs != 'library')
			$this->render('admin_edit');
		else
			$this->render('admin_index');
	}
}
 ?>