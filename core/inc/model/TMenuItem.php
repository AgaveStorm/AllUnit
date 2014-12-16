<?php

class TMenuItem {
	
	private $items = array();
	private $slug;
	private $title;
	
	function __construct($slug, $title) {
		$this->slug = $slug;
		$this->title = $title;
	}
	function add($item) {
		if(!empty($item)) {
			$this->items[] = $item;
		}
	}
	
	function getSlug() {
		return $this->slug;
	}
	function getTitle() {
		return $this->title;
	}
	
	function getMenuAsArray(){
		$res['slug'] = $this->getSlug();
		$res['title'] = TXml::cdata($this->getTitle());
		foreach($this->items as $item) {
			$res['items'][] = $item->getMenuAsArray();
		}
		return $res;
	}
}
