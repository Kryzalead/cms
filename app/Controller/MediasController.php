<?php 
App::uses('Sanitize', 'Utility');

class MediasController extends AppController{
	
	public $components = array('Img');

	/*
	*	Fonction index de l'administration
	*/
	function admin_index($mime = ''){
		$d['title_for_layout'] = 'Bibliothèque';
		$this->Media->contain(array(
			'User'=>array(
				'fields'=>array('User.id','User.username')
			),
			'Post_meta'
		));

		$conditions = array('Media.type'=>'attachment');

		if(!empty($this->request->query['search'])){
			$search = Sanitize::clean($this->request->query['search']);
			$conditions = array_merge(array('Media.name LIKE'=>'%'.$search.'%'),$conditions);
		}
		else{
			if(!empty($mime)){
				if($mime == 'images')
					$conditions = array_merge($conditions,array('Media.mime_type'=>'image/jpeg'));
			}	
		}

		$this->paginate = array(
			'fields'=>array('Media.id','Media.name','Media.created'),
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
			if($v['Media']['mime_type'] == 'image/jpeg')
				$d['totalImages'] = $v[0]['total'];
		}

		$d['total'] = $d['totalImages'] + $d['totalVideos'];

		$d['totalElement'] = (empty($mime)) ? $d['total'] : $d['total'.ucfirst($mime)];

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
						$format = array('thumbnail','medium','large'); 
						foreach ($format as $v) {
							$height = Configure::read($v.'_size_h');
							$width = Configure::read($v.'_size_w');
							$this->Img->crop($dir.DS.$file_slug.'.'.$file_extension,$dir.DS.$file_slug.'_'.substr($v, 0,1).'.'.$file_extension,$width,$height);
						}
						$this->Session->setFlash("Votre média a bien été ajouté","notif");
						if($this->request->action == 'admin_tinymce')
							$this->redirect(array('action'=>'tinymce','library'));
						$this->redirect(array('action'=>'edit',$this->Media->id));
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
			$this->request->data = $d['media'];
		}


		$this->set($d);
	}

	/*
	*	Fonction qui permet d'éffectuer des actions groupées
	*/
	function admin_doaction(){
		parent::doaction('média');
	}

	/*
	*	Fonction qui supprime un média
	*/
	function admin_delete($id,$token = null){
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');

		$this->Media->id = $id;
		$this->Media->delete();
		$this->Session->setFlash("Le média a bien été supprimé","notif");
		$this->redirect($this->referer());
	}

	/*
	*	Permet l'affichage des médias pour tinymce
	*/
	function admin_tinymce($tabs = 'upload'){
		
		$this->layout = 'modal';

		if($this->request->is('post') || $this->request->is('put')){
			$method = $this->request->data['Media']['type'];
			switch ($method) {
				case 'upload':
					$this->admin_edit();
					break;
				case 'url':
					$this->set('src',$this->request->data['Media']['src']);
					$this->set('title',$this->request->data['Media']['title']);
					$this->set('alt',$this->request->data['Media']['alt']);
					$this->set('class',$this->request->data['Media']['class']);
					$this->layout = null;
					$this->render('tinymce');
					die();
					break;
				case 'library':
					break;
				default:
					# code...
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
			$this->admin_index();
		}
		
		$d['current_tabs'] = $tabs;
		
		$d['alignement'] = array(
			'alignLeft'=>'Gauche',
			'alignCenter'=>'Centrer',
			'alignRight'=>'Droite'
		);

		$this->set($d);
		if($tabs != 'library')
			$this->render('admin_edit');
		else
			$this->render('admin_index');
	}
}
 ?>