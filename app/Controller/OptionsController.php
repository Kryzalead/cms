<?php 
class OptionsController extends AppController{
	
	public function init(){
		// on check si options_init vaut false
		if(!Configure::read('options_init')){
			if(!Cache::read('config_site')){
				// on récupère tous les enregistrements  
				$options = $this->Option->find('all',array(
				'fields'	=>	array('name','value')
				));	
				Cache::write('config_site',$options);
			}
			else
				$options = Cache::read('config_site');

			// on stocke chaque options dans la configuration de cake, de manière à pouvoir y accéder de partout 
			foreach ($options as $v) {
				Configure::write($v['Option']['name'],$v['Option']['value']);
			}
			// on précise que la configuration s'est chargée
			Configure::write('options_init',true);	
		}
	}
}
 ?>