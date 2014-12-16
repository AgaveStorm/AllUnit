<?php

class TUnitManagementContainer extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		new TLocation($this, TAu::MANAGE.'/units');
	}
	
	function OnEnableEvent($Sender) {

	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
