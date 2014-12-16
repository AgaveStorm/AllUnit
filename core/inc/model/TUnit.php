<?php


class TUnit {
	private $config;
	
	function __construct($config) {
		$this->config = $config;
		$units = TUnits::getInstance();
		$units->addUnit($this);
	}
	
	function getTheme() {
		return $this->config->design;
	}
	
	function getPath() {
		$exploded = explode("/",$this->config->file);
		unset($exploded[count($exploded)-1]);
		return implode('/',$exploded);
	}
	
}
