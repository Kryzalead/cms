<?php 
Router::connect('/catalogue.html',array('plugin'=>'catalog','controller'=>'products','action'=>'home'));
Router::connect('/catalogue/:type.html',array('plugin'=>'catalog','controller'=>'products','action'=>'index'));
Router::connect('/catalogue/:type/:order/:slug',array('plugin'=>'catalog','controller'=>'products','action'=>'index'),array('pass'=>array('type','order','slug')));
Router::connect('/catalogue/:type/:slug-:id.html',array('plugin'=>'catalog','controller'=>'products','action'=>'view'));
 ?>