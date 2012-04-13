<?php 
class DashboardController extends AppController{

	public function admin_index(){
		$d['title_for_layout'] = 'Tableau de bord';
		$d['totalPost'] = $d['totalPage'] = $d['totalCategory'] = $d['totalTag'] = 0;
		
		// on récupère le nombre de pages et d'articles
		$this->loadModel('Post');

		$count = $this->Post->find('all',array(
			'fields'	=>	array('Post.type','COUNT(Post.id) AS total'),
			'conditions'=>array(
				'OR'=>array(
					array(
						'Post.type'=>'post'
					),
					array(
						'Post.type'=>'page'
					)
				),
				'Post.status'=>'publish'
			),
			'group'		=>	'Post.type'
		));
		
		foreach ($count as $k => $v) {
			$d['total'.ucfirst($v['Post']['type'])] = $v[0]['total'];
		}
		
		// on récupère le nombre de taxonomy
		$this->loadModel('Taxonomy.Term');

		$count = $this->Term->find('all',array(
			'fields'=>array('Term.type','COUNT(Term.id) AS total'),
			'group'=>'Term.type'
		));

		foreach ($count as $k => $v) {
			$d['total'.ucfirst($v['Term']['type'])] = $v[0]['total'];
		}
		

		// on récupère les derniers brouillons
		$d['last_drafts'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.content','Post.created'),
			'conditions'=>array(
				'Post.type'=>'post',
				'Post.status'=>'draft'	
			)
		));

		
		$this->loadModel('Guestbook');
		$count = $this->Guestbook->find('all',array(
			'fields'=>array('Guestbook.approved','COUNT(Guestbook.id) AS total'),
			'group'=>'Guestbook.approved'
		));
		
		
		$d['totalWaiting'] = $d['totalApproved'] = $d['totalSpam'] = 0;
		foreach ($count as $k => $v) {
			if($v['Guestbook']['approved'] == '0')
				$d['totalWaiting'] =  $v[0]['total'];
			if($v['Guestbook']['approved'] == '1')
				$d['totalApproved'] =  $v[0]['total'];
		}

		$d['totalComments'] =  $d['totalApproved'] + $d['totalWaiting'];

		$d['last_comments'] = $this->Guestbook->find('all',array(
			'fields'=>array('Guestbook.id','Guestbook.author','Guestbook.approved','Guestbook.created','Guestbook.content'),
			'conditions'=>array('Guestbook.approved'=>array(0,1)),
			'limit'=>4,
			'order'=>array('Guestbook.id'=>'DESC')
		));
		
		$this->loadModel('Catalog.Product');
		$count = $this->Product->find('all',array(
			'fields'	=>	array('Product.product_type','COUNT(Product.id) AS total'),
			'conditions'=>array(
				'OR'=>array(
					array(
						'Product.product_type'=>'robe-de-mariee'
					),
					array(
						'Product.product_type'=>'accessoire'
					)
				),
				'Product.status'=>'publish'
			),
			'group'		=>	'Product.product_type'
		));
		
		foreach ($count as $k => $v) {
			$d['total'.ucfirst($v['Product']['product_type'])] = $v[0]['total'];
			if($v['Product']['product_type'] == 'robe-de-mariee')
				$d['totalRobe'] = $d['total'.ucfirst($v['Product']['product_type'])];
		}
		
		$this->set($d);
	}
}
 ?>