<?php
namespace sitemap;

class TFrontendControl extends \TControl {
	function OnCreateEvent($Sender) {
		$this->location = new \TLocation($this, ['sitemap.xml']);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}
	
	function OnBeforeDisplayEvent($Sender) {
		if(!$Sender->isEnabled()) {
			return;
		}
		$locations = \TLocations::getAll();
		foreach($locations as $loc) {
			$pages = $loc->getPages();
			foreach($pages as $page) {
				$exploded = explode("/",$page->getSlugStr());
				if(empty($page)
					|| empty($page->getSlugStr())
					|| reset($exploded) == \TAu::MANAGE) {
					continue;
				}
				$Sender->Data['pages'][] = [ 
				    'slug' => $page->getSlugStr(),
				    'title' => $loc->getTitle($page->getSlugStr())
				]; 
			}
		}
		$Sender->Data['siteurl'] = \TAu::getSiteUrl();
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo "\n";
		echo $Sender->GetHtml();
		exit;
	}
}
