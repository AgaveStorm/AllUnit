<?php


class TLocation {
	
	const INCLUDE_CHILDREN = true;
	
	private $control;
	private $slug;
	private $vars;
	
	function __construct($control, $slug='', $includeChildren = false) {
		$this->control = $control;
		$this->slug = $slug;
		$this->vars = array();
		$this->includeChildren = $includeChildren;
		TLocations::add($this);
	}
	
	function getSlug() {
		return $this->slug;
	}
	
	function getVars() {
		return $this->vars;
	}
	
	function getControl() {
		return $this->control;
	}
	
	function current() {
		$basePath = str_replace("/index.php","",$_SERVER['PHP_SELF']);
		$thisPath = $_SERVER['REDIRECT_URL'];
		$strippedPath = substr($thisPath,strlen($basePath."/"));
		if(!is_array($this->slug)) {
			$exploded = explode("/",$strippedPath);
			if($this->slug == $strippedPath || (
				$this->includeChildren
				&& $exploded[0] == $this->slug
				)) {
				return true;
			}
		}
		if(is_array($this->slug)) {
			$exploded = explode("/",$strippedPath);
			
			if(count($exploded) < count($this->slug)) {
				return false;
			}
			$ok = true;
			$this->vars = array();
			foreach($exploded as $key=>$value) {
				$ok = $ok && ($this->slug[$key] == $value 
					|| $this->slug[$key] == "*"
					|| ( 
						$key > count($this->slug)-1
						&& $this->includeChildren
						));
				if($this->slug[$key] == "*" && !empty($value)) {
					$this->vars[] = $value;
				}
			}
			return $ok;
		}
		return false;
	}
}
