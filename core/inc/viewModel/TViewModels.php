<?php


class TViewModels {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TJs();
		}
		return self::$instance;
	}
	
	public static function getList() {
		return self::$instance->items;
	}
	
	public static function add($className) {
		self::$instance->items[] = $className;
	}
}
