<?php 
class MediasController extends AppController{
	
	public $allowed_extension = array('jpg','jpeg','png','gif');
	public $components = array('Img');

	/**************************************
	*	
	*			ADMINISTRATION 
	*
	***************************************/

	/*
	*	Affiche les médias pour l'administration
	*/
	public function admin_index($type = ''){

		$d['title_for_layout'] = 'Bibliothèque';
		
		$conditions = array('Media.type'=>'attachment');

		// si une recherche a été demandée
		if(!empty($this->request->query['search'])){
			// on récupère la recherche
			$search = $this->request->query['search'];
			// on modifie le tableau des conditions
			$conditions = array_merge(array('Media.name LIKE '=>'%'.$search.'%'),$conditions);
		}
		
		if($type == 'detached')
			$conditions = array_merge(array('Media.post_parent'=>0),$conditions);
		elseif($type == 'images')
			$conditions = array_merge(array('Media.mime_type LIKE '=>'%image%'),$conditions);
		else
			$type = '';			
		
		
		$test = $this->paginate = array(
			'fields'	=>	array('Media.id','Media.name','Media.created','Media.post_parent','User.username','Post.name'),
			'conditions'=>	$conditions,
			'limit'		=>	Configure::read('elements_per_page'),
			'joins'		=>	array(
			 		array(
				 		'table'	=>	'posts',
				 		'alias'	=>	'Post',
				 		'type'	=>	'LEFT',
				 		'conditions'	=>	array('Media.post_parent = Post.id')
			 		)
			 	
			 	),
		);
		
		
		$medias = $this->paginate('Media');

		
		foreach ($medias as $k => $v) {
			$media_meta = $v['Post_meta'];
			foreach ($media_meta as $k1 => $v1) {
				if($v1['meta_key'] == 'attachment_metadata'){
					// on désrialise le tableau des meta_data
					$tab = unserialize($v1['meta_value']);
					// on récupère le fichier d'origine
					$origin_file = $tab['origins']['file'];
					// on récupère le nom d'origine du fichier
					$origin_name = end(explode('/',$origin_file));
					// on remplace le nom d'origine par le nom de la thumbnail
					$medias[$k]['Media']['file'] = str_replace($origin_name, $tab['thumbnail']['file'], $origin_file);
				}
				if($v1['meta_key'] == 'attachment_image_alt')
					$medias[$k]['Media']['alt'] = $v1['meta_value'];	
			}

			
		}
		
		$count = $this->Media->find('all',array(
			'fields'	=>	array('Media.post_parent'),
			'conditions'=>	array('Media.type'=>'attachment'),
			'recursive'	=>	-1		
		));
		
		$d['totalImages'] = $d['totalDetached'] = 0;
		foreach ($count as $k => $v) {
			if($v['Media']['post_parent'] == 0)
				$d['totalDetached']++;
			$d['totalImages']++;	
		}

		// nombre total de médias
		$d['total'] = $d['totalImages'];

		// nombre totakl d'élement pour le tri demandé
		$d['totalElement'] = (!empty($type) || $type != 'all') ? $d['total'.ucfirst($type)] : $d['total'];

		$d['medias'] = $medias;
		$this->set($d);
	}

	
	/*
	* 	Permet d'ajouter et de modifier un media
	*/
	public function admin_edit($id = null){
		
		// ajout d'un média
		$d['title_for_layout'] = "Envoi d'un nouveau média";
		if(empty($id)){
			$d['action'] = 'add';
			if(!empty($this->request->data['Media']['file'])){
				$file = $this->request->data['Media']['file'];
				
				// on récupère l'extension du fichier
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
				
				// on teste si l'extension est bonne
				if(in_array(strtolower($file_extension),$this->allowed_extension)){
					// on vérifie si ce dernier correspond bien à une image
					if(strpos($file['type'], 'image') !== false){
						// on récupère le type mime du fichier
						$file_type_mime = $file['type'];

						// on vérifie que le dossier existe bien sinon on lé crée
						$dir = IMAGES.date('Y');
						if(!file_exists($dir)){
							mkdir($dir,'0777');
						}
						$dir .= DS.date('m');
						if(!file_exists($dir)){
							mkdir($dir,'0777');
						}
						// nom du fichier
						$file_name = str_replace('.'.$file_extension, '', $file['name']);
						// slug du fichier
						$file_slug = strtolower(Inflector::slug($file_name,'-'));
						// id de l'auteur
						$user_id = $this->request->data['Media']['user_id'];
						
						// on enregistre le média
						$this->Media->save(array(
							'user_id'	=>	$user_id,
							'name'		=>	$file_name,
							'slug'		=>	$file_slug,
							'status'	=>	'inherit',
							'type'		=>	'attachment',
							'mime_type'	=>	$file_type_mime,
							'guid'		=>	'http://'.$_SERVER['HTTP_HOST'].Router::url('/').'img/'.date('Y').'/'.date('m').'/'.$file_slug.'.'.$file_extension
						));
						
						// On recupere les informations du fichier
      					$file_infos = getimagesize($file['tmp_name']);
      					// largeur
      					$file_width = $file_infos[0];
      					// hauteur
      					$file_height = $file_infos[1];
						
						// on récupère l'id du média
						$post_id = $this->Media->id;
						
						// préparation du tableau pour les metadatas
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

						// préparation du tableau ^pour l'enregistrement des metas
						$data = array(
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

						$success = $this->Media->Post_meta->saveAll($data);
						// vérification des sauvegardes avant la création des images
						if($success){
							// upload de l'image d'origine
							move_uploaded_file($file['tmp_name'], $dir.DS.$file_slug.'.'.$file_extension);
							
							// on passe à la création des images
							$format = array('thumbnail','medium','large');
							// pour chaque format, on récupère les dimensions en configuration puis on crop l'image
							foreach ($format as $v) {
								$height = Configure::read($v.'_size_h');
								$width = Configure::read($v.'_size_w');
								$this->Img->crop($dir.DS.$file_slug.'.'.$file_extension,$dir.DS.$file_slug.'_'.substr($v, 0,1).'.'.$file_extension,$width,$height);
							}
							$this->Session->setFlash("Votre média a bien été ajouté","notif");
							
							// si on est passé par la méthode admin_tinymce, on renvois vers cette dernière
							// sinon c'est qu'on est passé par la gestion des médias
							if($this->request->params['action'] == 'admin_tinymce')
								$this->redirect(array('action'=>'tinymce','library'));
							else	
								$this->redirect(array('action'=>'edit',$post_id));
						}
						else{
							$this->Session->setFlash("Une erreur interne s'est produite lors de la sauvegarde de votre média","notif",array('type'=>'error'));	
						}
					}
					else{
						$this->Session->setFlash("Votre média n'est pas valide","notif",array('type'=>'error'));
					}
				}
				else{
					$this->Session->setFlash("Votre média n'est pas valide","notif",array('type'=>'error'));
				}
			}
			$this->set($d);

		}
		else{
			$d['title_for_layout'] = 'Modifier un média';
			$d['action'] = 'upd';
			// modification d'un média
			if($this->request->is('put')){
				// si des datas ont été postées

				if($this->Media->save($this->request->data)){
					// si un texte alternatif a été posté
					// on vérifie si il n'existe pas
					$meta_id = $this->Media->Post_meta->find('first',array(
						'fields'	=>	array('id'),
						'conditions'=>	array(
							'post_id'=>$this->request->data['Media']['id'],
							'meta_key'=>'attachment_image_alt'
						)
					));

					// si une meta existe
					if($meta_id){
						$this->Media->Post_meta->id = $meta_id;
						$this->Media->Post_meta->save(array(
							'meta_value'	=>	$this->request->data['Media']['alt']
						));
					}
					else{
						$this->Media->Post_meta->save(array(
							'post_id'	=>	$this->request->data['Media']['id'],
							'meta_key'	=>	'attachment_image_alt',
							'meta_value'=>	$this->request->data['Media']['alt']	
						));	
					}
					
					$this->Session->setFlash("Le média a bien été modifié","notif");
					$this->redirect(array('action'=>'index'));
				}
				else{
					$this->Session->setFlash("Merci de corriger vos informations","notif",array('type'=>'error'));
				}
			}
			
			// on récupère les datas du média pour les afficher dans la vue
			$media = $this->Media->find('first',array(
				'fields'		=>	array('Media.id','Media.content','Media.name','Media.slug','Media.mime_type','Media.created','Media.guid','Media.user_id'),
				'conditions'	=>	array('Media.id'=>$id)
			));
			// on récupère les metas
			$meta_data = $media['Post_meta'];
			foreach ($meta_data as $k => $v) {
				if($v['meta_key'] == 'attachment_metadata'){
					// on désrialise le tableau des meta_data
					$tab = unserialize($v['meta_value']);
					// on récupère le fichier d'origine
					$origin_file = $tab['origins']['file'];
					// on récupère le nom d'origine du fichier
					$origin_name = end(explode('/',$origin_file));
					// on remplace le nom d'origine par le nom de la thumbnail
					$media['Media']['file'] = str_replace($origin_name, $tab['thumbnail']['file'], $origin_file);
					// on récupère les tailles du fichier d'origine
					$media['Media']['size'] = $tab['origins']['width'].'*'.$tab['origins']['height'];
				}
				if($v['meta_key'] == 'attachment_image_alt')
					$media['Media']['alt'] = $v['meta_value'];	
			}
			$d['media'] = $media;
			$this->data = $media;	
			
			$this->set($d);
		}
	}

	/*
	*	Fonction de supression d'un média
	*/
	public function admin_delete($id,$token = null){
		if(empty($token))
			$this->redirect('/');
		elseif($this->Session->read('Security.token') != $token)
			$this->redirect('/');
		else{
			// récupération des metadatas du média
			$metadatas = $this->Media->Post_meta->find('all',array(
				'conditions'	=>	array('post_id'=>$id)
			));
			// on parcours les meta
			foreach ($metadatas as $k => $v){
				// on récupère les différents nom des fichiers
				if($v['Post_meta']['meta_key'] == 'attachment_metadata'){
					$files = unserialize($v['Post_meta']['meta_value']);
				}
			}
			// on récupère le chemin de l'image d'orgine
			$path['origin'] = $files['origins']['file'];
			// on récupère son nom
			$origin_name = end(explode('/',$path['origin']));
			// on crée les chemins des autres formats
			$path['thumbnail'] = str_replace($origin_name, $files['thumbnail']['file'], $path['origin']);
			$path['medium'] = str_replace($origin_name, $files['medium']['file'], $path['origin']);
			$path['large'] = str_replace($origin_name, $files['large']['file'], $path['origin']);
			// pour chacun des chemins, on supprime les images
			foreach ($path as $v) {
				unlink(IMAGES.$v);
			}

			// supression des metadatas
			$this->Media->Post_meta->deleteAll(array('post_id'=>$id));

			// supression du média
			$this->Media->delete($id);
			$this->Session->setFlash("Votre média a bien été supprimé","notif");
			$this->redirect($this->referer());
		}	
	}

	/*
	*	Permet l'affichage des médias pour tinymce
	*/
	public function admin_tinymce($tabs = 'upload',$type = ''){
		$this->layout = 'modal';
		
		// on récupère sur quel onglet on se situe
		$d['tabs'] = $tabs;

		// on teste si des datas ont été postées
		if($this->request->is('post')){
			
			// on récupère avec quelle méthode on a posté
			$method = $this->request->data['Media']['type'];
			switch ($method) {
				case 'upload':
					// cas d'un envois avec la méthode upload
					// on stocke la nouvelle image
					// pour celà on fait appel à la méthode admin_edit sans id
					$this->admin_edit();
					break;

				case 'url':
					// cas d'un envois avec la méthode url
					
					// on récupère le chemin de l'image
					$this->set('src',$this->request->data['Media']['src']);
					$this->set('title',$this->request->data['Media']['title']);
					$this->set('alt',$this->request->data['Media']['alt']);
					$this->set('class',$this->request->data['Media']['class']);
					$this->set('insert_type','img');
					$this->layout = false;
					$this->render('tinymce');
					return;
					break;
				
				default:
					// on récupère le title
					$this->set('title',$this->request->data['Media']['title']);
					
					// on récupère le alt, si celui ci est vide, on met le title à la place
					if(empty($this->request->data['Media']['alt']))
						$this->set('alt',$this->request->data['Media']['title']);
					else
						$this->set('alt',$this->request->data['Media']['alt']);
							
					// on récupère la classe pour l'alignement
					$this->set('class',$this->request->data['Media']['class']);
					
					// on récupère le fichier original
					$file = $this->request->data['Media']['guid'];
					// on récupère le nom du fichier original avec son extension
					$file_name = end(explode('/',$file));
					// on récupère le nom sans l'extension
					$name = current(explode('.',$file_name));

					// on récupère la taille demandée
					$size = $this->request->data['Media']['size'];
					
					// on renomme le fichier selon la taille demandée
					if($size == 'thumbnail')
						$src = str_replace($name,$name.'_t', $file);
					elseif($size == 'medium')	
						$src = str_replace($name,$name.'_m', $file);
					elseif($size == 'large')
						$src = str_replace($name,$name.'_l', $file);
					else
						$src = $file;
					
					$this->set('src',$src);
					$this->set('insert_type','img');			
					$this->layout = false;
					$this->render('tinymce');
					return;
					break;
			}
		}
		else{
			// si des données non pas été postées

			// si des datas existe en query, c'est à dire si on est passé par une modification du média directement dans tiny
			if($this->request->query)
				$d['query'] = $this->request->query;
					
			// sinon on récupère les infos pour la librairie
			$conditions = array('Media.type'=>'attachment');	
			
			if($type == 'images')
				$conditions = array_merge(array('Media.mime_type LIKE '=>'%image%'),$conditions);
			else
				$type = '';	

			$medias = $this->Media->find('all',array(
				'fields'		=>	array('Media.id','Media.name','Media.content','Media.mime_type','Media.created','Media.guid'),
				'conditions'	=>	$conditions
			));
			foreach ($medias as $k => $v) {
				$meta_datas = $v['Post_meta'];
				foreach ($meta_datas as $k1 => $v1) {
					if($v1['meta_key'] == 'attachment_metadata'){
						// on désrialise le tableau des meta_data
						$tab = unserialize($v1['meta_value']);
						// on récupère le fichier d'origine
						$origin_file = $tab['origins']['file'];
						// on récupère le nom d'origine du fichier
						$origin_name = end(explode('/',$origin_file));
						// on remplace le nom d'origine par le nom de la thumbnail
						$medias[$k]['Media']['file'] = str_replace($origin_name, $tab['thumbnail']['file'], $origin_file);
						$medias[$k]['Media']['size'] = $tab['origins']['width'].'*'.$tab['origins']['height'];
					}
					if($v1['meta_key'] == 'attachment_image_alt')
						$medias[$k]['Media']['alt'] = $v1['meta_value'];	
				}
			}
			$d['medias'] = $medias;

			// variable supplémentaires pour la vue
			// nombre total d'image
			$d['totalImages'] = $this->Media->find('count',array(
				'conditions'=>array('type'=>'attachment')
			));

			// nombre total de médias
			$d['total'] = $d['totalImages'];	
			$this->set($d);
		}	
	}
}
 ?>