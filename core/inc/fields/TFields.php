<?php


class TFields {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TFields();
		}
		return self::$instance;
	}
	
	function add($field) {
		$inst = TFields::getInstance();
		$inst->items[] = $field;
	}
	
	public function getList() {
		return self::getInstance()->items;
	}
}
