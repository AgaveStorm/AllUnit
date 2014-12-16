<?php

require_once 'TBkSiteOptionsControl.php';
require_once 'TBkLoginControl.php';
require_once 'TBkContentTypesContainer.php';

class TBkMainWrapperContainer extends TContainer {

	function OnCreateEvent($Sender) {
		/* add child controls here */
		$Sender->Enable();
		$Login = new TBkLoginControl();
		$Sender->AddChild($Login);
		if(TAuthorizationManager::IsLogged()) {
			$Sender->AddChild(new TBkSiteOptionsControl());
			$Sender->AddChild(new TBkContentTypesContainer());
		}
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
