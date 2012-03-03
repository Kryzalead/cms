<?php 
class TermsController extends AppController{
	
	function admin_delete($id = null){
		$this->Term->TermR->delete($id);
	}

	function admin_add($object,$object_id,$type){
		
		if($this->request->query['name']){
			$d = array(
				'name'=>$this->request->query['name'],
				'type'=>$type
			);

			$term = $this->Term->find('first',array(
				'fields'=>array('id'),
				'conditions'=>$d
			));

			if(empty($term)){
				$d['slug'] = strtolower(Inflector::slug($this->request->query['name'],'-'));
				$this->Term->save($d);
				$term_id = $this->Term->id;
			}
			else{
				$term_id = $term['Term']['id'];
			}
		}
		$d = array(
			'object'=>$object,
			'object_id'=>$object_id,
			'term_id'=>$term_id
		);

		$count = $this->Term->TermR->find('count',array(
			'conditions'=>$d
		));

		if($count == 0){
			$this->Term->TermR->save($d);
			$url = Router::url(array('action'=>'delete',$this->Term->TermR->id));
			die('<span style="margin-right: 25px;display: block;float: left;font-size: 11px;line-height: 1.8em;white-space: nowrap;cursor: default;"><a class="delTaxo" href="'.$url.'">x </a>'.strtoupper($this->request->query['name']).'</span>');
		}
	}
}
 ?>