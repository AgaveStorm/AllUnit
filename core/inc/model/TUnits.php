<?php
require_once 'vihv/misc/TFile.php';

class TUnits {
	
	const LEVEL_CORE = 1;
	const LEVEL_COMMUNITY = 2;
	const LEVEL_USER = 3;
	
	private static $instance;
	private $units = array();
	
	private function __construct() {}
	
	public function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new TUnits();
		}
		return self::$instance;
	}
	
	public function addUnit($unit) {
		$this->units[] = $unit;
	}
	
	public function getTheme() {
		$units = $this->getActiveUnits();
		$theme = array();
		foreach($units as $unit) {
			$theme[get_class($unit)] = array(
			    'theme'=>$unit->getTheme(),
			    'path' =>$unit->getPath()
				);
		}
		return $theme;
	}
	
	public function initUnits() {
		$path = TFile::SearchIncludePath('allunit/core/units');
		$this->addUnitsFromFolder($path, TUnits::LEVEL_CORE);
		$path = TFile::SearchIncludePath('allunit/community/units');
		$this->addUnitsFromFolder($path, TUnits::LEVEL_COMMUNITY);
		$path = TFile::SearchIncludePath('units');
		$this->addUnitsFromFolder($path, TUnits::LEVEL_USER);
	}
	
	private function addUnitsFromFolder($path, $level) {
		$folders = TFile::GetChildFolders($path);
		foreach($folders as $folder) {
			$filename = $folder."/info.json";
			if(file_exists($filename)) {
				$config = json_decode(file_get_contents($filename));
				$class = $config->class;
				require_once $folder.'/'.$class.'.php';
				$this->addUnit(new $class($config, $folder, $level));
			}
		}
	}

	public function getActiveUnits() {
		return $this->units;
	}
}
