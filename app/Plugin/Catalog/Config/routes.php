<?php 
Router::connect('/catalogue',array('plugin'=>'catalog','controller'=>'products','action'=>'home'));
Router::connect('/catalogue/:type',array('plugin'=>'catalog','controller'=>'products','action'=>'index'));
Router::connect('/catalogue/:type/:order/:slug',array('plugin'=>'catalog','controller'=>'products','action'=>'index'),array('pass'=>array('type','order','slug')));
Router::connect('/catalogue/:type/:slug-:id',array('plugin'=>'catalog','controller'=>'products','action'=>'view'));

Router::connect('/admin/catalogue.php',array('plugin'=>'catalog','controller'=>'products','action'=>'index','admin'=>true));
Router::connect('/admin/catalogue/action.php',array('plugin'=>'catalog','controller'=>'products','action'=>'product','admin'=>true));
Router::connect('/admin/edit-product.php',array('plugin'=>'catalog','controller'=>'products','action'=>'edit','admin'=>true));
Router::connect('/admin/product-new.php',array('plugin'=>'catalog','controller'=>'products','action'=>'add','admin'=>true));
 ?>