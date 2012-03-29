<?php 
Router::connect('/livreor',array('plugin'=>'guestbook','controller'=>'guestbooks','action'=>'index'));
Router::connect('/livreor/valid-comment.php',array('plugin'=>'guestbook','controller'=>'guestbooks','action'=>'valid','admin'=>true));
Router::connect('/livreor/delete-comment.php',array('plugin'=>'guestbook','controller'=>'guestbooks','action'=>'delete','admin'=>true));
 ?>