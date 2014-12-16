<?php

require_once 'TMenuItem.php';

abstract class TMenu {
	
	protected $menu;
	 public function __construct($slug, $title) {
		 $this->menu = new TMenuItem($slug, $title);
	 }
	
	public function add($item) {
		$this->menu->add($item);
	}
	public function getMenu() {
		return $this->menu->getMenuAsArray();
	}
}
