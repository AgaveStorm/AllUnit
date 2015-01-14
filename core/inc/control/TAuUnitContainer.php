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
		return @$this->config->design;
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
		$whatToReplace = explode(PATH_SEPARATOR, ini_get("include_path"));
		foreach($whatToReplace as $key=>$value) {
			$whatToReplace[$key] = $value."/";
		}
		$whatToReplace[] = $_SERVER['DOCUMENT_ROOT'].$base."/";
		$path = str_replace($whatToReplace, '', $this->getPath());
//		var_dump($path);
		return $path;
	}
	public function allowBackend() {
		return false;
	}
}
