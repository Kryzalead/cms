<?php 
App::uses('Sanitize', 'Utility');

class MediasController extends AppController{
	
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

		$this->set($d);
	}

	/*
	*	Permet l'affichage des médias pour tinymce
	*/
	function admin_tinymce($tabs = 'upload',$type = ''){
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