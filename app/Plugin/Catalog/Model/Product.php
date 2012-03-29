<?php
class Product extends CatalogAppModel{
	public $actsAs = array('Containable','Taxonomy.taxonomy'=>array('fixed'=>array('product_category')));

	public $hasMany = array('Product_meta'=>array('dependent'=>true));

	public $recursive = -1;
}