<?php

class EJsDependency extends Exception {}

class TJs {
	private static $instance;
	private $items = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TJs();
		}
		return self::$instance;
	}
	
	function add($js, $id='',$dependencies = array()) {
		$inst = TJs::getInstance();
		if(empty($id)) {
			$id = $js;
		}
		foreach($inst->items as $item) {
			if($item['id'] == $id) {
				return; //do not add same script twice
			}
		}
		$inst->items[] = array( 'filename' => $js, 'id'=>$id, 'deps' => $dependencies );
	}
	
	function getAll() {
		$inst = TJs::getInstance();
		$items = $inst->items;
		//var_dump($items);
		$allIds = array_column($items, 'id');
		foreach($items as $item) {
			foreach($item['deps'] as $dep) {
				if(!in_array($dep, $allIds)) {
					throw new EJsDependency('Dependency "'.$dep.'" not found for '.$item['id']."( file: ".$item['filename'].")");
				}
			}
		}
		
		$sorted = [];
		$limit = 1000;
		while(!empty($items) && $limit > 0 ) {
			$limit--;
			$item = $items[0];
			unset($items[0]);
			$items = array_values($items);
			
			if(empty($item['deps'])) {
				$sorted[] = $item;
				continue;
			}
			$already = array_column($sorted,'id');
			
			$ok = false;
			foreach($item['deps'] as $dep) {
				if(in_array($dep, $already)) {
					$ok = true;
					continue;
				}
			}
			
			if($ok) {
				$sorted[] = $item;
				continue;
			}
			
			if(!$ok) {
				$items[] = $item;
			}
		}
		
		$js = [];
		foreach($sorted as $item) {
			$js[] = $item['filename'];
		}
		//var_dump($js);
		return $js;
	}
	
	
	function getMinified() {		
		foreach(self::getAll() as $item) {
			$pathinfo = pathinfo($item);
			$list[$pathinfo['extension']][$pathinfo['dirname']][] = $pathinfo['basename'];
		}
		$re = array();
		foreach($list['js'] as $key=>$value) {
			$path = $key;
			$exploded = explode('/', $path);
			if(!empty($exploded)) {
				if($exploded[0] != TAu::RELAY) {
					$path = TAu::RELAY."/".$path;
				}
			}
			$re[] = array('filename' => $path."/js.min?".implode(";",$value));
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
