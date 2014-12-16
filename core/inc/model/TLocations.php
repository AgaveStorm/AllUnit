<?php

require_once 'TLocation.php';

class TLocations {
	private static $instance;
	private $locations = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TLocations();
		}
		return self::$instance;
	}
	
	
	public function add($location) {
		$inst = TLocations::getInstance();
		$inst->locations[] = $location;
	}
	
	public function getAll() {
		$inst = TLocations::getInstance();
		return $inst->locations;
	}
	
	public function controlEnabled($control) {
		$inst = TLocations::getInstance();
		foreach($inst->locations as $location) {
			if($location->getControl() == $control
				&& $location->current()
				) {
				return true;
			}
		}
	}
	
	/**
	 * @return array of current matching locations
	 */
	public function getCurrent() {
		$inst = TLocations::getInstance();
		$locations = array();
		foreach($inst->locations as $location) {
			if($location->getControl() == $control
				&& $location->current()
				) {
				$locations[] = $location;
			}
		}
		return $locations;
	}
}
