<?php
App::uses('Sanitize', 'Utility');

class ProductsController extends AppController{

	public $components = array('Img');

	protected $allow_product = array('robe-de-mariee','accessoire');
	protected $allow_product_status = array('all','publish','draft','trash');
	protected $allow_product_action = array('add','edit');
	function home(){

		$d['title_for_layout'] = 'Catalogue | '.Configure::read('site_name');

		$this->Product->contain('Term');

		$d['robes'] = $this->Product->find('all',array(
			'fields'=>array('Product.id','Product.name','Product.prix','Product.url','Product.slug','Product.product_type'),
			'conditions'=>array('product_type'=>'robe-de-mariee','status'=>'publish'),
			'limit'=>4,
			'order'=>'rand()'
		));
		
		$d['accessoires'] = $this->Product->find('all',array(
			'conditions'=>array('product_type'=>'accessoire','status'=>'publish'),
			'limit'=>4,
			'order'=>'rand()'
		));

		$this->set($d);
	}

	function index(){
		
		$d['show_filter'] = false;
		$type_products = $this->request->params['type'];
		
		if(!in_array($type_products, $this->allow_product))
			throw new NotFoundException("Page introuvable");

		$conditions = array('Product.product_type'=>$type_products,'Product.status'=>'publish');
		$this->request->params['named']['page'] = $this->params['page'];
		
		if(!empty($this->request->params['slug'])){
			$d['show_filter'] = true;
			$this->paginate = array(
				'fields'=>array('Product.id','Product.name','Product.slug','Product.url','Product.prix'),
				'conditions'=>$conditions,
				'joins'=>array(
					array(
						'table' => 'term_relationships', 
						'alias' => 'TermR', 
						'type' => 'inner',  
						'conditions'=> array('TermR.object_id = Product.id')
					),
					array(
						'table' => 'terms', 
						'alias' => 'Term', 
						'type' => 'inner',  
						'conditions'=> array(
							'Term.id = TermR.term_id',
							'Term.slug' => $this->request->params['slug']
						)
					)
				),
				'order'=>array('created DESC')
			);	
		}
		else{
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>8,
				'order'=>array('created DESC')
			);
		}	

		$this->Product->contain('Term');
		$d['products'] = $this->Paginate('Product');
		
		$d['type_product'] = $type_products;

		if($d['type_product'] == 'robe-de-mariee'){
			$d['list_taille'] = array(Router::url('/').'catalogue/'.$d['type_product']=>' Taille ');
			$tailles = $this->Product->Term->find('all',array(
				'fields'=>array('Term.name','Term.slug'),
				'conditions'=>array('Term.type'=>'product_taille'),
				'order'=>array('Term.name')
			));
			
			foreach ($tailles as $k => $v) {
				$d['list_taille'] = array_merge($d['list_taille'],array(Router::url('/').'catalogue/'.$d['type_product'].'/taille/'.$v['Term']['slug']=>$v['Term']['name']));
			}
			if(!empty($this->request->params['order']) && $this->request->params['order'] == 'taille')
				$this->request->data['Product']['taille'] = Router::url('/').'catalogue/'.$d['type_product'].'/taille/'.$this->request->params['slug'];

			$d['list_creator'] = array(Router::url('/').'catalogue/'.$d['type_product']=>' Créateur ');
			$creators = $this->Product->Term->find('all',array(
				'fields'=>array('Term.name','Term.slug'),
				'conditions'=>array('Term.type'=>'product_creator'),
				'order'=>array('Term.name')
			));
			
			foreach ($creators as $k => $v) {
				$d['list_creator'] = array_merge($d['list_creator'],array(Router::url('/').'catalogue/'.$d['type_product'].'/createur/'.$v['Term']['slug']=>$v['Term']['name']));
			}
			if(!empty($this->request->params['order']) && $this->request->params['order'] == 'Créateur')
				$this->request->data['Product']['creator'] = Router::url('/').'catalogue/'.$d['type_product'].'/createur/'.$this->request->params['slug'];
		}
		elseif($d['type_product'] == 'accessoire'){
			$d['list_category'] = array(Router::url('/').'catalogue/'.$d['type_product']=>' Catégorie ');
			$categories = $this->Product->Term->find('all',array(
				'fields'=>array('Term.name','Term.slug'),
				'conditions'=>array('Term.type'=>'product_category'),
				'order'=>array('Term.name')
			));
			
			foreach ($categories as $k => $v) {
				$d['list_category'] = array_merge($d['list_category'],array(Router::url('/').'catalogue/'.$d['type_product'].'/categorie/'.$v['Term']['slug']=>$v['Term']['name']));
			}
			if(!empty($this->request->params['order']) && $this->request->params['order'] == 'categorie')
				$this->request->data['Product']['categorie'] = Router::url('/').'catalogue/'.$d['type_product'].'/categorie/'.$this->request->params['slug'];
		}
		
		$title_for_layout = ($d['type_product'] == 'robe-de-mariee') ? 'Robe de Mariées' : 'Accessoires';
		$d['title_for_layout'] = $title_for_layout.' | Catalogue | '.Configure::read('site_name');
		$this->set($d);
	}

	function view(){

		$id = $this->request->params['id'];
		$slug = $this->request->params['slug'];

		$type_product = $this->request->params['type'];

		$this->Product->contain(array('Term','Product_meta','Product_attachement'));

		$d['product'] = $this->Product->find('first',array(
			'fields'=>array('Product.name','Product.slug','Product.description','Product.url','Product.prix','Product.product_type','Product.url_min'),
			'conditions'=>array('Product.id'=>$id,'Product.product_type'=>$type_product,'Product.status'=>'publish')
		));

		if(empty($d['product']))
			throw new NotFoundException("Page introuvable");

		if($slug != $d['product']['Product']['slug'])
			$this->redirect(array('plugin'=>'catalog','controller'=>'products','action'=>'view','type'=>$type_product,'slug'=>$d['product']['Product']['slug'],'id'=>$id));
		
		foreach ($d['product']['Product_meta'] as $k => $v) {
			if($v['meta_key'] == 'product_buy_prix'){
				if($d['product']['Product']['prix'] != 0)
					$d['product']['Meta']['valeur_achat'] = $v['meta_value'];
			}
				
			if($v['meta_key'] == 'product_creator_site')
				$d['product']['Meta']['product_creator_site'] = $v['meta_value'];
		}

		if(!empty($d['product']['Taxonomy']['product_creator'])){
			$creator = current($d['product']['Taxonomy']['product_creator']);
			$d['product']['Meta']['product_creator'] = $creator['name'];
		}
		

		if(!empty($d['product']['Meta']['valeur_achat'])){
			$temp = $d['product']['Product']['prix']/$d['product']['Meta']['valeur_achat'];
			$temp2 = $temp-1;
			$pourcent = ceil($temp2*100);
			$d['product']['Meta']['reduction'] = $pourcent;
		}
		

		$this->set($d);
		
	}

	function admin_index(){
		
		// on récupère le type de produit
		$type = !empty($this->request->query['type']) ? $this->request->query['type'] : 'robe-de-mariee';
		
		if(!in_array($type, $this->allow_product)){
			$this->error("Type de produit invalide");
			return;
		}
		
		// on récupère le status demandé
		// si il est vide, on le met à all
		$status = !empty($this->request->query['status']) ? $this->request->query['status'] : 'all';
		if(!empty($status)){
			if(!in_array($status, $this->allow_product_status)){
				$status = '';
			}
		}
		$d['status'] = $status;

		$d['type'] = $type;

		$d['title_for_layout'] = ($type == 'robe-de-mariee') ? 'Robe de Mariées' : 'Accessoires';
		$d['icon_for_layout'] = ($type == 'robe-de-mariee') ? 'icone-robe.png' : 'icone-accessoire.png';
		$d['text_for_add_product'] = ($type == 'robe-de-mariee') ? 'Ajouter une robe' : 'Ajouter un accessoire';
		$d['text_for_submit_search'] = ($type == 'robe-de-mariee') ? 'Rechercher dans les robes' : 'Rechercher dans les accessoires';
		$d['icon_for_layout'] = 'icone-produits.png';
		$d['data_for_top_table'] = array(
			'action'=>'index',
			'params'=>array('type'=>$type),
			'list'=>array(
				'all'=>'Tous',
				'publish'=>'Publiés',
				'draft'=>'Brouillons',
				'trash'=>'Corbeille'
			),
			'current'=>$status
		);


		$conditions = array('Product.product_type'=>$type);

		$find_status = true;
		$find_by_term = false;

		// si une recherche a été demandée
		if(!empty($this->request->query['s'])){
			$search = Sanitize::clean($this->request->query['s']);
			$conditions = array_merge($conditions,array(
					'Product.name LIKE'=>'%'.$search.'%'
			));
			$d['search'] = $search;
		}
		else{
			$term_type = '';
			$term_slug = '';
			if(!empty($this->request->query['taille']) || !empty($this->request->query['createur'])){
				$find_by_term = true;
				$find_status = false;
				
				if(!empty($this->request->query['taille'])){
					$term_type = 'Taille';
					$term_slug = $this->request->query['taille'];
				}
				if(!empty($this->request->query['createur'])){
					$term_type = 'Créateur';
					$term_slug = $this->request->query['createur'];
				}

				$this->paginate = array(
					'fields'=>array('Product.id','Product.slug','Product.name','Product.description','Product.prix','Product.status','Product.created','Product.url_min','Product.product_type'),
					'conditions'=>$conditions,
					'joins'=>array(
						array(
							'table' => 'term_relationships', 
							'alias' => 'termR', 
							'type' => 'inner',  
							'conditions'=> array('TermR.object_id = Product.id')
						),
						array(
							'table' => 'terms', 
							'alias' => 'Term', 
							'type' => 'inner',  
							'conditions'=> array(
								'Term.id = TermR.term_id',
								'Term.slug' => $term_slug
							)
						)
					),
					'order'=>'Product.name',
					'limit'=>Configure::read('elements_per_page')
				);
			}
		}
		if($find_status){
			if(!empty($status)){
				if($status != 'all')
					$conditions = array_merge($conditions,array('Product.status'=>$status));
				else
					$conditions = array_merge($conditions,array('Product.status <>'=>'trash'));
			}	
			else
				$conditions = array_merge($conditions,array('Product.status <>'=>'trash'));

			$this->paginate = array(
				'fields'=>array('Product.id','Product.slug','Product.name','Product.description','Product.prix','Product.status','Product.created','Product.url_min','Product.product_type'),
				'conditions'=>$conditions,
				'order'=>'Product.name',
				'limit'=>Configure::read('elements_per_page')
			);
		}
		

		$this->Product->contain('Term');
		

		$d['products'] = $this->Paginate('Product');
		
		// initialisation des compteur de la vue
		$d['totalPublish'] = $d['totalDraft'] = $d['totalTrash'] = 0;

		$this->Product->contain();
		$count = $this->Product->find('all',array(
			'fields'=>array('Product.status','COUNT(Product.id) AS total'),
			'conditions'=>array('Product.product_type'=>$type),
			'group'=>'Product.status'
		));

		// assignation des compteurs
		foreach ($count as $k => $v){
			$d['total'.ucfirst($v['Product']['status'])] = $v[0]['total'];
			$d['data_for_top_table']['count']['total'.ucfirst($v['Product']['status'])] = $v[0]['total'];
		}
		
		$d['total'] = $d['totalPublish'] + $d['totalDraft'];
		$d['data_for_top_table']['count']['total'] = $d['total'];

		// si une recherche, totalElement vaut le total de post trouvés
		if(!empty($search) || !empty($find_by_term))
			$d['totalElement'] = count($d['products']);
		else
			$d['totalElement'] = $d['totalElement'] = (empty($status) || $status == 'all') ? $d['total'] : $d['total'.ucfirst($status)];

		// préparation de la list do_action
		$d['list_action'] = array(
			'0'=>'Action groupées'
		);
		switch ($status) {
			case '':
			case 'publish':
			case 'all':
				$d['list_action'] = array_merge($d['list_action'],array('draft'=>'Déplacer dans les brouillons','trash'=>'Déplacer dans la corbeille'));
				break;
			case 'draft':
				$d['list_action'] = array_merge($d['list_action'],array('publish'=>'Déplacer dans les publications','trash'=>'Déplacer dans la corbeille'));
				break;	
			case 'trash':
				$d['list_action'] = array_merge($d['list_action'],array('draft'=>'Restaurer','delete'=>'Supprimer définitivement'));
				break;			default:
				# code...
				break;
		}

		$this->set($d);
	}

	function admin_product(){

		$action = $this->request->query['action'];
		$id = $this->request->query['id'];
		$this->Product->id =$id;
		
		$post_type = $this->Product->field('product_type');
		
		if(empty($post_type)){
			$this->error("Voulez-vous vraiment faire cela ?");
			return;
		}

		
		switch ($action) {
			case 'trash':
				$this->Product->saveField('status','trash');
				$this->Session->setFlash("Element déplacé dans la corbeille","notif");
				break;
			case 'untrash':
				$this->Product->saveField('status','draft');
				$this->Session->setFlash("Element retiré de la corbeille","notif");
				break;
			case 'delete':
				if(empty($this->request->query['token']))
					$this->redirect('/');
				elseif($this->Session->read('Security.token') != $this->request->query['token'])
					$this->redirect('/');
				
				$this->Product->delete();
				$this->Session->setFlash("Element supprimé","notif");
				break;	
			default:
				# code...
				break;
		}
		$this->redirect($this->referer());
	}

	function admin_doaction(){
		$action = $this->request->data['Product']['action'];
		$type = $this->request->data['Product']['type'];
		$count = 0;
		
		unset($this->request->data['Product']['action']);
		unset($this->request->data['Product']['type']);

		foreach ($this->request->data['Product'] as $k => $v) {
			if(!empty($v)){
				$this->Product->id = $k;
				if($action != 'delete'){
					$this->Product->saveField('status',$action);
				}
				else{
					$this->Product->delete();
				}
				$count ++;
			}	
		}

		$texte = $type == 'robe-de-mariee' ? 'robe de mariée' : 'accessoire';
		if($count > 0){
			$terminaison = ($count > 1 ) ? 's' : '';
			$feminin = $type == 'robe-de-mariee' ? 'e' : '';
			switch ($action) {
				case 'publish':
					$this->Session->setFlash($count." ".$texte.$terminaison." publié".$feminin.$terminaison,"notif");
					break;
				case 'draft':
					$this->Session->setFlash($count." ".$texte.$terminaison." déplacé".$feminin.$terminaison." dans les brouillons","notif");
					break;	
				case 'trash':
					$this->Session->setFlash($count." ".$texte.$terminaison." déplacé".$feminin.$terminaison." dans la corbeille","notif");
					break;
				case 'delete':
					$this->Session->setFlash($count." ".$texte.$terminaison." supprimé".$feminin.$terminaison,"notif");
					break;
				default:
					break;
			}
		}
		$this->redirect(array('action'=>'index','?'=>array('type'=>$type)));
	}

	function admin_add(){
		// récupération du type
		$type = (!empty($this->request->query['type'])) ? $this->request->query['type'] : 'robe-de-mariee';
		if(!in_array($type,$this->allow_product)){
			$this->error("Type de produits invalide");
			return;
		}

		// création des variables pour la vue
		$d['type'] = $type;
		if($type == 'robe-de-mariee'){
			$d['title_for_layout'] = 'Ajouter une robe';
			$d['icon_for_layout'] = 'icone-produits.png';
			$d['texte_submit'] = 'Publier';
		}
		else{
			$d['title_for_layout'] = 'Ajouter un accessoire';
			$d['icon_for_layout'] = 'icone-produits.png';
			$d['texte_submit'] = 'Publier';
		}

		//création de l'id du post
		$last_id = current($this->Product->find('first',array(
			'fields'=>'MAX(id) AS maxid',
		)));

		if($this->Session->check('data_form')){
			$this->request->data = $this->Session->read('data_form');
			$this->Product->validationErrors = $this->Session->read('data_form_error');
			$this->Session->delete('data_form');
			$this->Session->delete('data_form_error');
		}
		$this->request->data['Product']['id'] = $last_id['maxid'] + 1;
		$this->request->data['Product']['product_type'] = $type;
		$this->request->data['Product']['action'] = 'add';

		// si le type est post, on rajoute la taxonomy
		if($type == 'accessoire'){
			$d['terms_product_category'] = array('0'=>'Catégorie');
			$terms_product_category = $this->Product->getFixedTerms('product_category');
			foreach ($terms_product_category as $k => $v) {
				$d['terms_product_category'][$k] = $v;
			}
		}
		if($type == 'robe-de-mariee'){
			$d['terms_product_taille'] = $this->Product->getFixedTerms('product_taille');
			$terms_product_creator = $this->Product->getFixedTerms('product_creator');
			$d['terms_product_creator'] = array('0'=>'Créateur');
			foreach ($terms_product_creator as $k => $v) {
				$d['terms_product_creator'][$k] = $v;
			}
			
		}

		// listes des status
		$d['list_status'] = array(
			'publish'=>'Publié',
			'draft'=>'Brouillon'
		);

		$d['status_selected'] = 'publish';
		$d['action'] = 'add';
		$this->set($d);
		$this->render('admin_edit');
	}

	function admin_edit(){

		// si le formulaire a été envoyé
		if($this->request->is('post') || $this->request->is('put')){
			
			// on vérifie l'action demandée
			if(empty($this->request->data['Product']['action']) || !in_array($this->request->data['Product']['action'],$this->allow_product_action)){
				$this->redirect($this->referer());
			}
			$action = $this->request->data['Product']['action'];
			
			// on vérifie si le type est correct
			if(!in_array($this->request->data['Product']['product_type'],$this->allow_product)){
				$this->redirect($this->referer());
			}
			$type = $this->request->data['Product']['product_type'];
			
			if(!empty($this->request->data['Product']['url'])){
				$file = $this->request->data['Product']['url'];
				unset($this->request->data['Product']['url']);
			}
			if($action == 'add' && !empty($file['name'])){
				$this->Product->set($this->request->data);
				if($this->Product->validates()){
					$slug = strtolower(Inflector::slug($this->data['Product']['name'],'-'));
					if(!empty($file) && $this->request->data['Product']['action'] == 'add'){
						$dir = IMAGES.'catalogue'.DS.$slug;
						if(!file_exists($dir)){
							mkdir($dir,'0777');
							mkdir($dir.DS.'mini','0777');
						}
						$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
						move_uploaded_file($file['tmp_name'], $dir.DS.$slug.'.'.$file_extension);
						$width = 350;$height = 263;
						$this->Img->crop($dir.DS.$slug.'.'.$file_extension,$dir.DS.'mini'.DS.$slug.'.'.$file_extension,$width,$height);
						$this->request->data['Product']['url'] = 'http://'.$_SERVER['HTTP_HOST'].Router::url('/').'img/catalogue/'.$slug.'/'.$slug.'.jpg';
						$this->request->data['Product']['url_min'] = 'http://'.$_SERVER['HTTP_HOST'].Router::url('/').'img/catalogue/'.$slug.'/mini/'.$slug.'.jpg';
					}

					$this->request->data['Product']['slug'] = $slug;
					$this->Product->save($this->request->data,array('validate'=>false));
					$product_id = $this->request->data['Product']['id'];
					if(!empty($this->request->data['Product']['product_buy_prix'])){
						if(is_numeric($this->request->data['Product']['product_buy_prix'])){
							
							$this->Product->Product_meta->delete(
								array('product_id'=>$product_id,'meta_key'=>'product_buy_prix')
							);
							$this->Product->Product_meta->save(array(
								'meta_key'=>'product_buy_prix',
								'meta_value'=>$this->request->data['Product']['product_buy_prix'],
								'product_id'=>$product_id
							));
						}
					}
					if ($action == 'add') {
						$this->Session->setFlash("Le produit a bien été ajouté","notif");
						$this->redirect(array('action'=>'edit','?'=>array('id'=>$product_id,'action'=>'edit')));
					}
					elseif($action == 'edit'){
						$this->Session->setFlash("Le produit a bien été modifié","notif");
						$this->redirect(array('action'=>'index','?'=>array('type'=>$type)));
					}
				}
				else{
					$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
					$product = $this->request->data;
					$this->Session->write('data_form',$this->request->data);
					$this->Session->write('data_form_error',$this->Product->validationErrors);
					$product_type = $this->request->data['Product']['product_type'];
					if ($this->request->data['Product']['action'] == 'add')
						$this->redirect(array('action'=>'add','?'=>array('type'=>$product_type)));
					if ($this->request->data['Product']['action'] == 'edit'){
						$id = $this->request->data['Product_id'];
						$this->redirect(array('action'=>'edit','?'=>array('id'=>$id,'action'=>'edit')));
					}

				}
			}
			else{
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
				$product = $this->request->data;
				$this->Session->write('data_form',$this->request->data);
				$this->Session->write('data_form_error',$this->Product->validationErrors);
				$product_type = $this->request->data['Product']['product_type'];
				$this->redirect(array('action'=>'add','?'=>array('type'=>$product_type)));
			}
			
		}
		else{
			// récupération de l'id
			if(empty($this->request->query['id']) || $this->request->query['id'] == 0){
				$this->redirect($this->referer());
			}
			$id = $this->request->query['id'];
			
			// on vérifie l'action demandée
			if(empty($this->request->query['action']) || !in_array($this->request->query['action'],$this->allow_product_action)){
				$this->redirect($this->referer());
			}
			$action = $this->request->query['action'];

			// on vérifie qu'on a bien un post à cet id et on récupère son type
			$this->Product->id = $id;
			$this->Product->contain(array('Product_meta','Term','Product_attachement'));
			$product = $this->Product->read(array('Product.id','Product.name','Product.description','Product.slug','Product.status','Product.product_type','Product.url_min','Product.prix'));
			if(empty($product)){
				$this->error("Vous tentez de modifier un contenu qui n’existe pas. Peut-être a-t-il été supprimé ?");
				return;
			}
			foreach ($product['Product_meta'] as $k => $v) {
				$product['Product'][$v['meta_key']] = $v['meta_value'];
			}
			$d['product'] = $product;
			$d['action'] = 'edit';
		}
		
		// on crée les variables pour la vue
		$post_type = $product['Product']['product_type'];
		if($post_type == 'robe-de-mariee'){
			$d['title_for_layout'] = "Modifier la robe";
			$d['icon_for_layout'] = 'icone-produits.png';
			$d['texte_submit'] = 'Mettre à jour';
			$d['terms_product_taille'] = $this->Product->getFixedTerms('product_taille');
			$terms_product_creator = $this->Product->getFixedTerms('product_creator');
			$d['terms_product_creator'] = array('0'=>'Créateur');
			foreach ($terms_product_creator as $k => $v) {
				$d['terms_product_creator'][$k] = $v;
			}
		}
		else{
			$d['title_for_layout'] = "Modifier l'accessoire";
			$d['icon_for_layout'] = 'icone-produits.png';
			$d['texte_submit'] = 'Mettre à jour';
			$d['terms_product_category'] = array('0'=>'Catégorie');
			$terms_product_category = $this->Product->getFixedTerms('product_category');
			foreach ($terms_product_category as $k => $v) {
				$d['terms_product_category'][$k] = $v;
			}
		}
		
		$d['type'] = $post_type;
		// listes des status
		$d['list_status'] = array(
			'publish'=>'Publié',
			'draft'=>'Brouillon'
		);

		$d['status_selected'] = 'publish';

		// on envoie les datas au formulaire
		$this->request->data = $product;
		if($this->Session->check('data_form')){
			$this->request->data = $this->Session->read('data_form');
			$this->Product->validationErrors = $this->Session->read('data_form_error');
			$this->Session->delete('data_form');
			$this->Session->delete('data_form_error');
		}
		$this->request->data['Product']['action'] = $action;
		
		$this->set($d);
	}

	function admin_delattachment(){

		$attachement_id = $this->request->query['attachment_id'];
		
		$this->Product->Product_attachement->id = $attachement_id;
		$product_id = $this->Product->Product_attachement->field('product_id');
		$this->Product->Product_attachement->delete();
		$this->redirect(array('action'=>'edit','?'=>array('id'=>$product_id,'action'=>'edit')));
	}

	function admin_addattachment(){
		$attachment_name = $this->request->data['Product']['attachment_name'];
		$attachment_slug = strtolower(Inflector::slug($attachment_name,'-'));
		$attachment_product_id = $this->request->data['Product']['attachment_product_id'];
		$attachment_product_slug = $this->request->data['Product']['attachment_product_slug'];
		$file = $this->request->data['Product']['attachment_file'];
		if(!empty($file['name'])){
			$dir = IMAGES.'catalogue'.DS.$attachment_product_slug;
			if(!file_exists($dir)){
				mkdir($dir,'0777');
				mkdir($dir.DS.'mini','0777');
			}
			$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
			
			move_uploaded_file($file['tmp_name'], $dir.DS.$attachment_slug.'.'.$file_extension);
			$this->Product->Product_attachement->save(array(
				'name'=>$attachment_name,
				'url'=>'catalogue/'.$attachment_product_slug.'/'.$attachment_slug.'.'.$file_extension,
				'url_min'=>'catalogue/'.$attachment_product_slug.'/mini/'.$attachment_slug.'.'.$file_extension,
				'product_id'=>$attachment_product_id
			));
			$width = 52;$height = 69;
			$this->Img->crop($dir.DS.$attachment_slug.'.'.$file_extension,$dir.DS.'mini'.DS.$attachment_slug.'.'.$file_extension,$width,$height);
			$this->redirect(array('action'=>'edit','?'=>array('id'=>$attachment_product_id,'action'=>'edit')));
		}
		else{
			$this->redirect(array('action'=>'edit','?'=>array('id'=>$attachment_product_id,'action'=>'edit')));
		}
	}
}