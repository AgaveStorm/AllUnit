<?php

class TBkContentTypeListControl extends TControl {

	function OnCreateEvent($Sender) {
		$this->location = new TLocation($this, [TAu::MANAGE,"content"], true);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}

	function OnEnableEvent($Sender) {
		$factory = TConfigManager::GetModel('IViewModelFactory', null, $filename);
		$factory->includeViewModels($filename);
		$list = $factory->getViewModels();
		foreach($list as $class) {
			$item = new $class();
			$Sender->Data['types'][] = [
			    'class' => $class,
			    'slug' => $item->getSlug(),
			    'title' => $item->getTitle(),
			    'permalink' => TAu::getSiteUrl()."/".TAu::MANAGE."/content/".$item->getSlug(),
			];
		}
	}

}
