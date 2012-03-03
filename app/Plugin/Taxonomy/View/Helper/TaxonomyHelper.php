<?php 
class TaxonomyHelper extends AppHelper{
	
	var $helpers = array('Html','Form');

	function input($type,$options = array()){
		
		$data = $this->data;
		if(empty($data))
			return false;

		$object = key($data);

		$this->javascript($object,$data[$object]['id'],$type);

		$html = '';
		if(!empty($data['Taxonomy'][$type])){
			foreach ($data['Taxonomy'][$type] as $v) {
				$url = Router::url(array('controller'=>'Terms','action'=>'delete','plugin'=>'taxonomy','admin'=>true,$v['TermR']['id']));
				$html .= '<span style="margin-right: 25px;display: block;float: left;font-size: 11px;line-height: 1.8em;white-space: nowrap;cursor: default;"><a class="delTaxo" href="'.$url.'">x </a>'.strtoupper($v['name']).'</span>';
			}	
		}

		$options['id'] = $type;
		$options['class']='addTaxo';

		return $this->Form->input('Taxonomy.'.$type,$options).$html;
	}

	private function javascript($object,$object_id,$type){
		$url = Router::url(array('controller'=>'Terms','action'=>'add','plugin'=>'taxonomy','admin'=>true,$object,$object_id,$type));

		$this->Html->scriptStart(array('inline'=>false));
		?>
		jQuery(function($){
			$('.delTaxo').live('click',function(){
				var a = $(this);
				$.get(a.attr('href'));
				a.parent().fadeOut();
				return false;
			});

			$('.addTaxo').keypress(function(e){
				// si le keyCode est égal à 13 : entrer
				if(e.keyCode == 13){
					input = $(this);
					$.get("<?php echo $url ?>",{name:input.val()},function(data){
						input.parent().after(data);
					});
					return false;
				}
			});
		})
		<?php
		$this->Html->scriptEnd();
	}
}
 ?>