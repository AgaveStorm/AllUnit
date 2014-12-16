<?php

class TMeta {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TMeta();
		}
		return self::$instance;
	}
	function add($name, $content) {
		$inst = TMeta::getInstance();
		$inst->items[] = array( 'name'=>$name, 'content'=>$content );
	}
	
	function getAll() {
		$inst = TMeta::getInstance();
		return $inst->items;
	}
}

