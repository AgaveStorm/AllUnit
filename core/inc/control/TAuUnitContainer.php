<?php


class TAuUnitContainer extends TContainer {
	private $config;
	private $path;
	private $level;
	
	function __construct($config, $path, $level) {
		$this->config = $config;
		$this->path = $path;
		$this->level = $level;
		//parent::__construct();
	}
	
	function create() {
		parent::__construct();
	}
	
	function getTheme() {
		return $this->config->design;
	}
	
	function getPath() {
		return $this->path;
	}
	
	function getLevel() {
		return $this->level;
	}
	
	function getUnitUrl() {
		$base = str_replace("/index.php","",$_SERVER['PHP_SELF']);
		if(substr($base,0,1) == '/') {
			$base = substr($base, 1); // fix for unexpected $_SERVER['PHP_SELF'] behaviour (depend on server and maybe php version)
		}
		$path = str_replace([$_SERVER['DOCUMENT_ROOT'].$base."/",
		    '/usr/share/php/'], '', $this->getPath());
		return $path;
	}
	public function allowBackend() {
		return false;
	}
}
