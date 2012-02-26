<?php 
class DashboardController extends AppController{

	public function admin_index(){
		
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
			'recursive'	=>	-1,
			'group'		=>	'Post.type'
		));
		
		foreach ($count as $key => $value) {
			$d['total'.ucfirst($value['Post']['type'].'s')] = $value[0]['total'];
		}
		
		$this->set($d);
	}
}
 ?>