<?php

require_once 'TBkHeaderMenuControl.php';

class TBkHeaderContainer extends TContainer {

	function OnCreateEvent($Sender) {
		TCss::add(TBackendContainer::getUnitUrlStatic()."/css/header.css");
		$Sender->Enable();
		$Sender->AddChild(new TBkHeaderMenuControl());
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
