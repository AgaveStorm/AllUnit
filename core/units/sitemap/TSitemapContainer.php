<?php
ini_set("include_path",ini_get("include_path").PATH_SEPARATOR.__DIR__);
require_once 'TFrontendControl.php';

class TSitemapContainer extends TAuUnitContainer {
	
	static $instance;

	function OnCreateEvent($Sender) {
		self::$instance = $this;
		$this->location = new \TLocation($this, ['au-manage','units','sitemap'],true, array($this, 'titleFunc'));
		$Sender->AddChild(new \sitemap\TFrontendControl());
	}
	
	function titleFunc($path, $vars) {
		return "Sitemap";
	}
	
	function OnEnableEvent($Sender) {

	}
	
	function OnBeforeDisplayEvent($Sender) {
		if(!$Sender->isEnabled()) {
			return;
		}
		$locations = TLocations::getAll();
		foreach($locations as $loc) {
			$pages = $loc->getPages();
			foreach($pages as $page) {
				$exploded = explode("/",$page->getSlugStr());
				if(empty($page)
					|| empty($page->getSlugStr())
					|| reset($exploded) == TAu::MANAGE) {
					continue;
				}
				$Sender->Data['pages'][] = [ 
				    'slug' => $page->getSlugStr(),
				    'title' => $loc->getTitle($page->getSlugStr())
				]; 
			}
		}
	}
	

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}
	
	static function getUnitUrlStatic() {
		return TAu::urlRelay(self::$instance->getUnitUrl()); 
	}

}
