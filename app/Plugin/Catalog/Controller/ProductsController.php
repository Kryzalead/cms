<?php
class ProductsController extends AppController{

	public $allow_product = array('robe-de-mariee','accessoire');

	function home(){

		$d['title_for_layout'] = 'Catalogue';

		$this->Product->contain('Term');

		$d['robes'] = $this->Product->find('all',array(
			'fields'=>array('Product.id','Product.name','Product.price','Product.url','Product.slug','Product.product_type'),
			'conditions'=>array('product_type'=>'robe-de-mariee'),
			'limit'=>4,
			'order'=>'rand()'
		));
		
		$d['accessoires'] = $this->Product->find('all',array(
			'conditions'=>array('product_type'=>'accessoire'),
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

		$conditions = array('Product.product_type'=>$type_products);

		if(!empty($this->request->params['slug'])){
			$d['show_filter'] = true;
			$this->paginate = array(
				'fields'=>array('Product.id','Product.name','Product.slug','Product.url','Product.price'),
				'conditions'=>$conditions,
				'limit'=>8,
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
							'Term.slug' => $this->request->params['slug']
						)
					)
				)
			);	
		}
		else{
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>8
			);
		}	

		$this->Product->contain('Term');
		$d['products'] = $this->Paginate('Product');
		
		$d['type_product'] = $type_products;

		$d['list_taille'] = array(Router::url('/').'catalogue/'.$d['type_product']=>' --taille-- ');
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

		$d['list_creator'] = array(Router::url('/').'catalogue/'.$d['type_product']=>' --createur-- ');
		$creators = $this->Product->Term->find('all',array(
			'fields'=>array('Term.name','Term.slug'),
			'conditions'=>array('Term.type'=>'product_creator'),
			'order'=>array('Term.name')
		));
		
		foreach ($creators as $k => $v) {
			$d['list_creator'] = array_merge($d['list_creator'],array(Router::url('/').'catalogue/'.$d['type_product'].'/createur/'.$v['Term']['slug']=>$v['Term']['name']));
		}
		if(!empty($this->request->params['order']) && $this->request->params['order'] == 'createur')
			$this->request->data['Product']['creator'] = Router::url('/').'catalogue/'.$d['type_product'].'/createur/'.$this->request->params['slug'];
		
		$this->set($d);
	}

	function view(){

		$id = $this->request->params['id'];
		$slug = $this->request->params['slug'];

		$type_product = $this->request->params['type'];

		$this->Product->contain(array('Term','Product_meta'));

		$d['product'] = $this->Product->find('first',array(
			'fields'=>array('Product.name','Product.slug','Product.description','Product.url','Product.price','Product.product_type'),
			'conditions'=>array('Product.id'=>$id,'Product.product_type'=>$type_product)
		));

		if(empty($d['product']))
			throw new NotFoundException("Page introuvable");

		if($slug != $d['product']['Product']['slug'])
			$this->redirect(array('plugin'=>'catalog','controller'=>'products','action'=>'view','type'=>$type_product,'slug'=>$d['product']['Product']['slug'],'id'=>$id));
		
		foreach ($d['product']['Product_meta'] as $k => $v) {
			if($v['meta_key'] == 'product_buy_price')
				$d['product']['Meta']['valeur_achat'] = $v['meta_value'];
			if($v['meta_key'] == 'product_creator_site')
				$d['product']['Meta']['product_creator_site'] = $v['meta_value'];
			if($v['meta_key'] == 'product_attachment_metadata'){
				$product_attachment_metadata = unserialize($v['meta_value']);
				foreach ($product_attachment_metadata as $k1 => $v1) {
					$d['product']['Meta']['attachment'][] = array(
						'name'=>$k1,
						'origin'=>$v1['origin'],
						'thumb'=>$v1['min']
					);
				}
			}
		}

		if(!empty($d['product']['Meta']['valeur_achat'])){
			$temp = $d['product']['Product']['price']/$d['product']['Meta']['valeur_achat'];
			$temp2 = $temp-1;
			$pourcent = ceil($temp2*100);
			$d['product']['Meta']['reduction'] = $pourcent;
		}
		

		$this->set($d);
		
	}
}