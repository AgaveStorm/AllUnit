<?php


class TAuFields {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TAuFields();
		}
		return self::$instance;
	}
	
	function add($field) {
		$inst = TAuFields::getInstance();
		$inst->items[] = $field;
	}
	
	public function getList() {
		return self::getInstance()->items;
	}
}
