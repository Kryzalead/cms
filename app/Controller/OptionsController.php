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
				//Cache::write('config_site',$options);
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

    function admin_general(){   

    	$d['title_for_layout'] = 'Options générales';
    	$d['action'] = 'general';

    	if($this->request->is('post') || $this->request->is('put')){
    		$this->Option->set($this->request->data);
    		if($this->Option->validates()){
    			$data = array();
    			foreach ($this->request->data['Option'] as  $k => $v) {
    				$data[] = array(
    					'name'=>$k,
    					'value'=>$v
    				);
    			}
    			$this->Option->saveAll($data,array('validate'=>false));
    			
    			$this->Session->setFlash("Les modifications ont bien été prises en compte","notif");
    			$this->redirect(array('action'=>'admin_general'));
    		}
    		else{
    			$this->Session->setFlash("Merci de corriger vos informations","notif",array('type'=>'error'));
    		}
    	}

     	$d['list_user_roles'] = Configure::read('user_roles');

     	$fields = array(
     		'site_name',
     		'slogan',
     		'admin_email',
     		'default_role'

     	);
     	foreach ($fields as $name) {
     		
     		$this->request->data['Option'][$name] = Configure::read($name);
     	}
   		
        $this->set($d);
        $this->render('admin_edit');
    }

    function admin_write(){   

    	$d['title_for_layout'] = 'Options d’écriture';
    	$d['action'] = 'write';

    	if($this->request->is('post') || $this->request->is('put')){
    		
    	}

     	
   		
        $this->set($d);
        $this->render('admin_edit');
    }
}
