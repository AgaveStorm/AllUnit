<?php

require_once 'TBkSiteOptionsControl.php';
require_once 'TBkLoginControl.php';
require_once 'TBkContentTypesContainer.php';

class TBkMainWrapperContainer extends TContainer {

	function OnCreateEvent($Sender) {
		$Sender->SetEvent('OnAuManageUnitsAdded',array($this,'OnAuManageUnitsAddedEvent'));
		$Sender->Enable();
		$Login = new TBkLoginControl();
		$Sender->AddChild($Login);
		if(TAuthorizationManager::IsLogged()) {
			$Sender->AddChild(new TBkSiteOptionsControl());
			$Sender->AddChild(new TBkContentTypesContainer());
		}
	}
	
	function OnAuManageUnitsAddedEvent($Sender, $aumanage) {
		$children = $aumanage->getChildren();
		foreach($children as $key=>$value) {
			if(get_class($value) == 'TBackendContainer') {
				continue;
			}
			$aumanage->removeChild($key);
			$Sender->AddChild($value);
		}
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
