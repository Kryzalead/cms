<?php 
class TaxonomyHelper extends AppHelper{
	
	var $helpers = array('Html','Form');

	function input($type,$options = array()){
		
		debug($this->data);die();
		return $this->Form->input('Taxonomy.'.$type,$options);
	}
}
 ?>