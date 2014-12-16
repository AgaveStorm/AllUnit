<?php

class TCss {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TCss();
		}
		return self::$instance;
	}
	
	function add($css, $id='') {
		$inst = TCss::getInstance();
		$inst->items[] = array( 'filename' => $css, 'id'=>$id );
	}
	
	function getAll() {
		$inst = TCss::getInstance();
		return $inst->items;
	}
}
