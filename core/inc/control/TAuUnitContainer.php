<?php


class TAuUnitContainer extends TContainer {
	private $config;
	private $path;
	private $level;
	private $slug;
	private $active = false;
	
	function __construct($config, $path, $level, $slug) {
		$this->config = $config;
		$this->path = $path;
		$this->level = $level;
		$this->slug = $slug;
	}
	
	function create() {
		$this->active = true;
		parent::__construct();
	}
	
	function getTheme() {
		return @$this->config->design;
	}
	
	function getDependencies() {
		return @$this->config->require;
	}
	
	function getPath() {
		return $this->path;
	}
	
	function getLevel() {
		return $this->level;
	}
	
	function getSlug() {
		return $this->slug;
	}
	
	function getTitle() {
		if(@empty($this->config->title)) {
			return $this->getSlug();
		}
		return $this->config->title;
	}
	
	function getDescription() {
		return @$this->config->description;
	}
	
	function isActive() {
		$list = new TActiveUnits();
		return $this->active || $list->getActive($this->getSlug());
	}
	
	function enableDependencies($units) {
		$deps = $this->getDependencies();
		if(empty($deps)) {
			return;
		}
		foreach($units as $control) {
			if(!$control->isEnabled()) {
				if(in_array($control->getSlug(), $deps)) {
					$control->create();
				}
			}
		}
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
		return $path;
	}
	public function allowBackend() {
		return false;
	}
}
