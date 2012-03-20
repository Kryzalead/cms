<?php
App::uses('Sanitize', 'Utility');

class CommentsController extends AppController{
	
	var $components = array('RequestHandler');
	public $allow_comment_status = array('all','approved','waiting','spam','trash');

	function post(){

		if($this->request->is('post')){
			$this->request->data['Comment']['author_ip'] = $this->RequestHandler->getClientIp();
			if($this->Comment->save($this->request->data)){
				$this->Session->setFlash("Merci de votre commentaire","notif");
				$this->redirect($this->referer());
			}
			else{
				$this->Session->setFlash("Le commentaire n'a pu être posté car il contient des erreurs","notif",array('typeMessage'=>'error'));
				$this->redirect($this->referer());
			}
		}
	}

	function admin_index(){

		$d['title_for_layout'] = 'Commentaires';

		$comment_status = !empty($this->request->query['comment_status']) ? $this->request->query['comment_status'] : 'all';
		
		if(!empty($comment_status)){
			if(!in_array($comment_status,$this->allow_comment_status))
				$comment_status = 'all';
		}
		$d['comment_status'] = $comment_status;

		$conditions = array();

		if(!empty($this->request->query['ip'])){
			$conditions = array_merge($conditions,array(
				'Comment.approved'=>array(0,1),
				'Comment.author_ip'=>$this->request->query['ip']
			));
			$d['search'] = $this->request->query['ip'];
			$this->request->data['Comment']['ip'] = $d['search'];
		}
		else{
			if($comment_status == 'all')
				$conditions = array_merge($conditions,array('Comment.approved'=>array(0,1)));
			if($comment_status == 'approved')
				$conditions = array_merge($conditions,array('Comment.approved'=>1));
			if($comment_status == 'waiting')
				$conditions = array_merge($conditions,array('Comment.approved'=>0));
			if($comment_status == 'spam' || $comment_status == 'trash')
				$conditions = array_merge($conditions,array('Comment.approved'=>$comment_status));

			if(!empty($this->request->query['s'])){
				$search = Sanitize::clean($this->request->query['s']);
				$conditions = array_merge($conditions,array('Comment.content LIKE'=>'%'.$search.'%'));
				$d['search'] = $search;
				$this->request->data['Comment']['s'] = $search;
			}
		}
		
		$this->Comment->contain(array(
			'Post'=>array(
				'fields'=>array('Post.id','Post.name','Post.slug','Post.type','Post.comment_count')
			)
		));

		$this->paginate = array(
			'fields'=>array('Comment.id','Comment.author','Comment.author_email','Comment.author_ip','Comment.created','Comment.content','Comment.approved','Comment.post_id'),
			'conditions'=>$conditions,
			'limit'=>Configure::read('elements_per_page')
		);

		$d['comments'] = $this->Paginate('Comment');

		$this->Comment->contain();

		$count = $this->Comment->find('all',array(
			'fields'=>array('COUNT(*) AS total, Comment.post_id'),
			'conditions'=>array('Comment.approved'=>0),
			'group'=>'Comment.post_id'
		));

		foreach ($count as $k => $v) {
			$d['totalWaitingComments'][$v['Comment']['post_id']] = $v[0]['total'];
		}

		$d['data_for_top_table'] = array(
			'action'=>'index',
			'list'=>array(
				'all'=>'Tous',
				'waiting'=>'En attente de relecture',
				'approved'=>'Approuvés',
				'spam'=>'Indésirables',
				'trash'=>'Corbeille'
			),
			'current'=>$comment_status
		);

		

		$count = $this->Comment->find('all',array(
			'fields'=>array('Comment.approved','COUNT(Comment.id) AS total'),
			'group'=>'Comment.approved'
		));
		
		$d['totalWaiting'] = $d['totalApproved'] = $d['totalSpam'] = $d['totalTrash'] = 0;

		foreach ($count as $k => $v) {
			if($v['Comment']['approved'] == '0'){
				$d['totalWaiting'] =  $v[0]['total'];
				$d['data_for_top_table']['count']['totalWaiting'] = $v[0]['total'];
			}
				
			if($v['Comment']['approved'] == '1'){
				$d['totalApproved'] =  $v[0]['total'];
				$d['data_for_top_table']['count']['totalApproved'] = $v[0]['total'];
			}
				
			if($v['Comment']['approved'] == 'spam'){
				$d['totalSpam'] =  $v[0]['total'];
				$d['data_for_top_table']['count']['totalSpam'] = $v[0]['total'];
			}
				
			if($v['Comment']['approved'] == 'trash'){
				$d['totalTrash'] =  $v[0]['total'];	
				$d['data_for_top_table']['count']['totalTrash'] = $v[0]['total'];
			}
				
		}

		// préparation de la list do_action
		$d['list_action'] = array(
			'0'=>'Action groupées'
		);
		switch ($comment_status) {
			case '':
			case 'all':
				$d['list_action'] = array_merge($d['list_action'],
					array(
						'unapprove'=>'Désapprouver',
						'approve'=>'Approuver',
						'spam'=>'Marquer comme indésirable',
						'trash'=>'Déplacer dans la corbeille'
					)
				);
				break;
			case 'waiting':
				$d['list_action'] = array_merge($d['list_action'],
					array(
						'approve'=>'Approuver',
						'spam'=>'Marquer comme indésirable',
						'trash'=>'Déplacer dans la corbeille'
					)
				);
				break;
			case 'approved':
				$d['list_action'] = array_merge($d['list_action'],
					array(
						'unapprove'=>'Désapprouver',
						'spam'=>'Marquer comme indésirable',
						'trash'=>'Déplacer dans la corbeille'
					)
				);
				break;
			case 'spam':
				$d['list_action'] = array_merge($d['list_action'],
					array(
						'approve'=>'Approuver',
						'unspam'=>"N'est pas un indésirable",
						'delete'=>'Supprimer définitivement'
					)
				);
				break;	
			case 'trash':
				$d['list_action'] = array_merge($d['list_action'],
					array(
						'untrash'=>'Restaurer',
						'delete'=>'Supprimer définitivement'
					)
				);
				break;			
			default:
				# code...
				break;
		}

		if(!empty($d['search']))
			$d['total'] = count($d['comments']);
		else
			$d['total'] =  $d['totalApproved'] + $d['totalWaiting'];
		
		$d['data_for_top_table']['count']['total'] = $d['totalApproved'] + $d['totalWaiting'];

		$d['totalElement'] = (empty($comment_status) || $comment_status == 'all') ? $d['total'] : $d['total'.ucfirst($comment_status)];
		
		$this->set($d);
	}
}