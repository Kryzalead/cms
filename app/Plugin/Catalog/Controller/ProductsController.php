<?php
class ProductsController extends AppController{

	public $allow_product = array('robe-de-mariee','accessoire');

	function home(){

		$d['title_for_layout'] = 'Catalogue';

		$this->Product->contain('Term');

		$d['robes'] = $this->Product->find('all',array(
			'conditions'=>array('product_type'=>'robe'),
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
		
		$type_products = $this->request->params['type'];
		
		if(!in_array($type_products, $this->allow_product))
			throw new NotFoundException("Page introuvable");

		$conditions = array('Product.product_type'=>$type_products);

		if(!empty($this->request->params['slug'])){
			$this->paginate = array(
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
		
		$d['type_product'] = $type_products == 'robe' ? 'robe-de-mariee' : $type_products;

		$this->set($d);
	}

	function view(){

		$id = $this->request->params['id'];
		$slug = $this->request->params['slug'];

		$type_product = $this->request->params['type'];

		$d['product'] = $this->Product->find('first',array(
			'conditions'=>array('Product.id'=>$id,'Product.product_type'=>$type_product)
		));

		if(empty($d['product']))
			throw new NotFoundException("Page introuvable");

		if($slug != $d['product']['Product']['slug'])
			$this->redirect(array('plugin'=>'catalog','controller'=>'products','action'=>'view','type'=>$type_product,'slug'=>$d['product']['Product']['slug'],'id'=>$id));
			
		$this->set($d);
		
	}
}