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
	
	function getMinified() {		
		foreach(self::getAll() as $item) {
			$pathinfo = pathinfo($item['filename']);
			$list[$pathinfo['extension']][$pathinfo['dirname']][] = $pathinfo['basename'];
		}
		$re = array();
		foreach($list['css'] as $key=>$value) {
			$path = $key;
			$exploded = explode('/', $path);
			if(!empty($exploded)) {
				if($exploded[0] != TAu::RELAY) {
					$path = TAu::RELAY."/".$path;
				}
			}
			$re[] = array('filename' => $path."/css.min?".implode(";",$value));
		}
		if(!empty($list['php'])) {
			foreach($list['php'] as $path=>$files) {
				foreach($files as $key=>$value) {
					$re[] = array('filename'=>$path."/".$value);
				}
			}
		}
		return $re;
	}
}
