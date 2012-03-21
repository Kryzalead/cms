<?php 
class OptionsController extends AppController{

	function init(){
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

    function admin_general(){   

    	$d['title_for_layout'] = 'Options générales';
    	$d['action'] = 'general';

    	if($this->request->is('post') || $this->request->is('put')){
			$this->Option->set($this->request->data);
			if($this->Option->validates()){
				foreach ($this->request->data['Option'] as $k => $v) {
					$option_id = $this->Option->field('id',array('name'=>$k));
					$this->Option->id = $option_id;
					$this->Option->saveField('value',$v);
				}
                Cache::delete('config_site');
				$this->Session->setFlash("Les modifications ont bien été prises en compte","notif");
				$this->redirect(array('action'=>'admin_general'));
			}
			else
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
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
			$this->Option->set($this->request->data);
			if($this->Option->validates()){
				foreach ($this->request->data['Option'] as $k => $v) {
					$option_id = $this->Option->field('id',array('name'=>$k));
					$this->Option->id = $option_id;
					$this->Option->saveField('value',$v);
				}
                Cache::delete('config_site');
				$this->Session->setFlash("Les modifications ont bien été prises en compte","notif");
				$this->redirect(array('action'=>'admin_write'));
			}
			else
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
    	}

     	$fields = array(
     		'default_post_edit_rows',
     		'default_post_category'
     	);

     	foreach ($fields as $name) {
     		$this->request->data['Option'][$name] = Configure::read($name);
     	}
   		
   		$this->loadModel('Term');
   		$list_category = $this->Term->find('all',array(
			'fields'=>array('Term.id','Term.name'),
			'conditions'=>array('type'=>'category')
   		));

   		$data = array();
   		foreach ($list_category as $k => $v) {
   			$data[$v['Term']['id']] = $v['Term']['name'];
   		}
   		
   		$d['list_category'] = $data;
   		
        $this->set($d);
        $this->render('admin_edit');
    }

    function admin_read(){

    	$d['title_for_layout'] = 'Options de lecture';
    	$d['action'] = 'read';

    	if($this->request->is('post') || $this->request->is('put')){
			$this->Option->set($this->request->data);
			if($this->Option->validates()){
				if(empty($this->request->data['Option']['page_on_front']))
					$this->request->data['Option']['page_on_front'] = 0;
				foreach ($this->request->data['Option'] as $k => $v) {
					$option_id = $this->Option->field('id',array('name'=>$k));
					$this->Option->id = $option_id;
					$this->Option->saveField('value',$v);
				}
                Cache::delete('config_site');
				$this->Session->setFlash("Les modifications ont bien été prises en compte","notif");
				$this->redirect(array('action'=>'admin_read'));
			}
			else
				$this->Session->setFlash("Merci de corriger vos informations","notif",array('typeMessage'=>'error'));
    	}

    	$fields = array(
    		'posts_per_page',
    		'show_on_front',
    		'page_on_front',
    	);

    	foreach ($fields as $name) {
     		$this->request->data['Option'][$name] = Configure::read($name);
     	}

     	$d['list_show_on_front'] = array(
     		'post'=>'Les derniers articles',
     		'page'=>'Une page statique (voir en dessous)'
     	);

     	$this->loadModel('Post');
     	$d['list_page_on_show'] =  $this->Post->find('list',array(
     		'conditions'=>array('Post.type'=>'page','Post.status'=>'publish')
     	));
     	$d['is_disabled'] = Configure::read('show_on_front') == 'post' ? 'disabled' : '';

    	$this->set($d);
        $this->render('admin_edit');
    }

    function admin_media(){
        $d['title_for_layout'] = 'Réglages des médias';
        $d['action'] = 'media';

        if($this->Session->read('Auth.User.role') != 'superadmin'){
            $this->error("test");return;
        }
        if ($this->request->is('put') || $this->request->is('post')) {
            
            $valid = true;
            foreach ($this->request->data['Option'] as $k => $v) {
                if(!is_numeric($v))
                    $valid = false;
            }
            if($valid){
                foreach ($this->request->data['Option'] as $k => $v) {

                    $option_id = $this->Option->field('id',array('name'=>$k));
                    $this->Option->id = $option_id;
                    $this->Option->saveField('value',$v);
                }
                Cache::delete('config_site');
                $this->Session->setFlash("Les modifications ont bien été prises en compte","notif");
                $this->redirect(array('action'=>'admin_media'));
            }
            else
                $this->Session->setFlash("Les valeurs doivent être numérique","notif",array('typeMessage'=>'error'));
        }

        $fields = array(
            'thumbnail_size_w',
            'thumbnail_size_h',
            'medium_size_w',
            'medium_size_h',
            'large_size_w',
            'large_size_h'
        );

        foreach ($fields as $name) {
            $this->request->data['Option'][$name] = Configure::read($name);
        }

        $this->set($d);
        $this->render('admin_edit');
    }
}
