<?php

class TUnitListControl extends TControl {

	function OnCreateEvent($Sender) {
		$Sender->Enable();
	}
	
	function OnEnableEvent($Sender) {
		$units = TUnits::getInstance();
		$list = $units->getAll();
		$re = [];
		foreach($list as $item) {
			$re[] = [
			    'name'=>get_class($item),
			    'title'=>$item->getTitle(),
			    'slug'=>$item->getSlug(),
			    'path'=>$item->getPath(),
			    'description'=>$item->getDescription(),
			    'active'=>$item->isActive(),
			    'dependencies'=>$item->getDependencies(),
			    'level'=>$item->getLevel(),
			];
		}
		$Sender->Data['items'] = $re;
	}
	
	function OnPostEvent($Sender, $Input) {
		if(!$Sender->isEnabled()) {
			return;
		}
		
		$units = TUnits::getInstance();
		if($Input['action'] == 'enable') {
			$units->setActive($Input['slug']);
		}
		if($Input['action'] == 'disable') {
			$units->setInactive($Input['slug']);
		}
		echo json_encode(['ok'=>true]);
		exit;
	}

}
