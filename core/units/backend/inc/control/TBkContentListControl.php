<?php

class TBkContentListControl extends TControl {

	function OnCreateEvent($Sender) {
		$this->SetEvent('list', array($this, 'OnListEvent'));
		$this->location = new TLocation($this, [TAu::MANAGE,"content","*"]);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}

	function OnEnableEvent($Sender) {
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/content-list.css");
		$vars = $this->location->getVars();
		$slug = $vars[0];

		$factory = TConfigManager::GetModel('IViewModelFactory', null, $filename);
		$factory->includeViewModels($filename);

		$viewModel = $factory->createBySlug($slug);
		$Sender->Data['permalink'] = TAu::getSiteUrl()."/".TAu::MANAGE."/content/".$slug;
		$this->list($viewModel);
	}
	
	public function OnListEvent($Sender, VBaseModel $viewModel) {
		$singleClass = $viewModel->getSingleModelName();
		$single = new $singleClass();
		$fields = $single->getFields();
		foreach($fields as $field) {
			$temp = $field;
			if(!isset($field['title'])) {
				$temp['title'] = $field['name'];
			}
			$Sender->Data['fields'][] = $temp;
		}
		$list = $viewModel->getListModel();
		$items = $list->getAll();
		foreach($items as $item) {
			$temp = $item->getDataAsArray();
			$temp['id'] = $item->getId();
			$Sender->Data['list'][] = $temp;
		}
		 //= 'here we are';
	}

}
