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

		$this->loadModel('Comment');
		$count = $this->Comment->find('all',array(
			'fields'=>array('Comment.approved','COUNT(Comment.id) AS total'),
			'group'=>'Comment.approved'
		));
		
		
		$d['totalWaiting'] = $d['totalApproved'] = $d['totalSpam'] = $d['totalTrash'] = 0;
		foreach ($count as $k => $v) {
			if($v['Comment']['approved'] == '0')
				$d['totalWaiting'] =  $v[0]['total'];
			if($v['Comment']['approved'] == '1')
				$d['totalApproved'] =  $v[0]['total'];
			if($v['Comment']['approved'] == 'spam')
				$d['totalSpam'] =  $v[0]['total'];
			if($v['Comment']['approved'] == 'trash')
				$d['totalTrash'] =  $v[0]['total'];	
		}

		$d['totalComments'] =  $d['totalApproved'] + $d['totalWaiting'] + $d['totalSpam'];

		
		$this->Comment->contain(array(
			'Post'=>array(
				'fields'=>array('Post.id','Post.name')
			)
		));

		$d['last_comments'] = $this->Comment->find('all',array(
			'fields'=>array('Comment.id','Comment.author','Comment.approved','Comment.created','Comment.content'),
			'conditions'=>array('Comment.approved'=>array(0,1)),
			'limit'=>5
		));

		$this->set($d);
	}
}
 ?>