<?php

class TBkSelectIdControl extends TControl {

	function OnCreateEvent($Sender) {
		$this->location = new TLocation($this, [TAu::MANAGE,"select"]);
		if($this->location->current()) {
			$this->Enable();
		}
	}
	

	function OnPostEvent($Sender, $Input) {
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$list = $factory->createBySlug($Input['list'])->getListModel();
		$items = $list->getAll();
		foreach($items as $item) {
			$Sender->Data['items'][] = [
			    'id'=>$item->getId(),
			    'title'=>$item->getTitle()
			];
		}
		$Sender->Data['params'] = $Input;
	}

}
