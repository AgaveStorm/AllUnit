<?php


class TBkContentEditControl extends TControl {
	public function OnCreateEvent($Sender) {
		$this->SetEvent('OnAdd', array($this, 'OnAddEvent'));
		$this->SetEvent('OnEdit', array($this, 'OnEditEvent'));
		$this->locationAdd = new TLocation($this, [TAu::MANAGE,'content','*','add']);
		$this->locationEdit = new TLocation($this, [TAu::MANAGE, 'content','*','edit','*']);
		if($this->locationAdd->current()) {
			$Sender->OnAdd();
			$Sender->Enable();
		}
		if($this->locationEdit->current()) {
			$Sender->OnEdit();
			$Sender->Enable();
		}
	}
	
	private function getViewModel() {
		$factory = TConfigManager::GetModel('IViewModelFactory', null, $filename);
		$factory->includeViewModels($filename);
		return $factory->createBySlug($this->slug);
	}
	
	public function OnEnableEvent($Sender) {
		TJs::add(TBackendContainer::getUnitUrlStatic()."/js/edit.js", null, ['jquery','vhfiles']);
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/bk-edit-content.css");
		$viewModel = $this->getViewModel();
		
		$singleClass= $viewModel->getSingleModelName();
		$single = new $singleClass();
		
		$fields = $single->getFields();
		foreach($fields as $field) {
			$temp = $field;
			if(!isset($field['title'])) {
				$temp['title'] = $field['name'];
			}
			$Sender->Data['fields'][] = $temp;
		}
		
	}
	
	public function OnAddEvent($Sender) {
		$this->slug = reset($this->locationAdd->getVars());
	}
	public function OnEditEvent($Sender) {
		$vars = $this->locationEdit->getVars();
		$this->slug = $vars[0];
		$this->id = $vars[1];
		$viewModel = $this->getViewModel();
		$list = $viewModel->getListModel();
		$item = $list->getOne($this->id);
		$Sender->Data['id'] = $this->id;
		$Sender->Data['values'] = $item->getDataAsArrayE();
	}
	
	public function OnPostEvent($Sender, $Input) {
		if(!$this->IsEnabled()) {
			return;
		}
//		var_dump($Input);
		$viewModel = $this->getViewModel();
		$list = $viewModel->getListModel();
		if(!empty($Input['onSaveClick'])) {
			if(empty($Input['id'])) {
				$item = $list->create($Input);
				$item->save();
			} else {
				$item = $list->getOne($Input['id']);
				$item->setData($Input);
				$item->save();
			}
		}
		
		if(!empty($Input['onRemoveClick'])) {
			$item = $list->getOne($Input['id']);
			$item->remove();
		}
		$this->GoBack();
		exit;
	}
}
