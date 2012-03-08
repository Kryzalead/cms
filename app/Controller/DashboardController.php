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
		
		foreach ($count as $key => $value) {
			$d['total'.ucfirst($value['Post']['type'])] = $value[0]['total'];
		}
		
		// on récupère le nombre de taxonomy
		$this->loadModel('Taxonomy.Term');

		$count = $this->Term->find('all',array(
			'fields'=>array('Term.type','COUNT(Term.id) AS total'),
			'group'=>'Term.type'
		));

		foreach ($count as $key => $value) {
			$d['total'.ucfirst($value['Term']['type'])] = $value[0]['total'];
		}
		

		// on récupère les derniers brouillons
		$d['last_drafts'] = $this->Post->find('all',array(
			'fields'=>array('Post.id','Post.name','Post.content','Post.created'),
			'conditions'=>array(
				'Post.type'=>'post',
				'Post.status'=>'draft'	
			)
		));

		$this->set($d);
	}
}
 ?>