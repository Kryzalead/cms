<?php 
class TermsController extends TaxonomyAppController{
	
	function admin_delete($id = null){
		$this->Term->TermR->id = $id;
		$term_id = $this->Term->TermR->field('term_id');

		$this->Term->TermR->delete($id);

		$count = $this->Term->TermR->find('count',array(
			'conditions'=>array('term_id'=>$term_id)
		));

		if($count == 0)
			$this->Term->delete($term_id);

		die();
	}

	function admin_edit($term = null){
		
	}

	function admin_add($object,$object_id){
		
		$type = $this->request->query['type'];
		
		if(isset($this->request->query['id']))
			$term_id = $this->request->query['id'];
		else{
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
		else
			die();
	}

	function admin_search(){
		$terms = $this->Term->find('list',array(
			'fields'=>array('id','name'),
			'conditions'=>array(
				'name LIKE'=>'%'.$this->request->query['term'].'%',
				'type'=>$this->request->query['type']
			)
		));

		$json = array();
		foreach ($terms as $id => $name) {
			$json[] = array('id'=>$id,'label'=>$name);
		}
		die(json_encode($json));
	}
}
 ?>