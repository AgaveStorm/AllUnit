<?php

class TAuMenuManagementContainer  extends TAuUnitContainer  {

	function OnCreateEvent($Sender) {
		new TLocation($this, TAu::MANAGE.'/menu');
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
