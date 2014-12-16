<?php

require_once 'allunit/core/inc/model/TAuOptions.php';

class TBkSiteOptionsControl extends TControl {

	function OnCreateEvent($Sender) {
		$Sender->SetEvent('OnSave', array($this,'OnSaveEvent'));	
	}
	
	function OnGetEvent($Sender, $Input) {
		$this->location = new TLocation($this, [TAu::MANAGE,"site"]);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}
	
	function OnEnableEvent($Sender) {
		$list = new TAuOptions();
		$Sender->Data['name'] = TFormNames::create($this, array_column($list->getPossibleOptions(),'name'));
		foreach($list->getPossibleOptions() as $option) {
			$option['value'] = $list->getOption($option['name']);
			$Sender->Data['options'][] = $option;
		}
	}
	
	function OnPostEvent($Sender, $Input) {
		if(!empty($Input['onBkSaveSiteOptions'])) {
			$Sender->OnSave($Input);
		}
	}
	
	function OnSaveEvent($Sender, $Input) {
		$Input = TFormNames::decodeInput($this, $Input);
		$list = new TAuOptions();
		foreach($list->getPossibleOptions() as $option) {
			$list->setOption($option['name'], $Input[$option['name']]);
		}
		Header('Location: ');
		exit;
	}

}
