<?php

require_once 'inc/model/TVmSlugLocVar.php';
require_once 'inc/model/TVmLocVar.php';

class TBkContentEditControl extends TControl {
	public function OnCreateEvent($Sender) {
		$this->SetEvent('OnAdd', array($this, 'OnAddEvent'));
		$this->SetEvent('OnEdit', array($this, 'OnEditEvent'));
		$this->locationAdd = new TLocation($this, [TAu::MANAGE,'content',new TVmSlugLocVar(),'add'], null, array($this,'addTitleFunc'));
		$this->locationEdit = new TLocation($this, [TAu::MANAGE, 'content',new TVmSlugLocVar(),'edit',new TVmLocVar('id')], null, array($this,'editTitleFunc'));
		if($this->locationAdd->current()) {
			$Sender->OnAdd();
			$Sender->Enable();
		}
		if($this->locationEdit->current()) {
			$Sender->OnEdit();
			$Sender->Enable();
		}
	}
	
	public function addTitleFunc($slug, $vars) {
		$modelSlug = reset($vars);
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$vm = $factory->createBySlug($modelSlug);
		return "Add ".$vm->getTitle();
	}
	
	public function editTitleFunc($slug, $vars) {
		$modelSlug = reset($vars);
		$id = next($vars);
		$factory = TConfigManager::GetModel('IViewModelFactory');
		$vm = $factory->createBySlug($modelSlug);
		$list = $vm->getListModel();
		$item = $list->getOne($id);
		return "Edit ".$vm->getTitle()." ".$item->getTitle();
	}
	
	private function getViewModel() {
		$factory = TConfigManager::GetModel('IViewModelFactory', null, $filename);
		$factory->includeViewModels($filename);
		return $factory->createBySlug($this->slug);
	}
	
	public function OnEnableEvent($Sender) {
		TJs::add(TBackendContainer::getUnitUrlStatic()."/js/edit.js", null, ['jquery','vhfiles','multiselect']);
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/bk-edit-content.css");
		$viewModel = $this->getViewModel();
		
		$singleClass= $viewModel->getSingleModelName();
		$single = new $singleClass();
		
		$fields = $single->getFieldObjects();
		foreach($fields as $field) {
			$temp = $field->asArray();
			//$temp['title'] = $field->getTitle();
//			if(!isset($field['title'])) {
//				$temp['title'] = $field['name'];
//			}
//			if(!isset($field['template'])) {
//				$temp['template'] = $field['name']."Field";
//			}
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
