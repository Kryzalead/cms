<?php 
class Menu extends AppModel{
	
	public $actsAs = array('Containable');

	public $hasMany = array('Menu_post'=>array('dependent'=>true));

	public $recursive = -1;
}

 ?>