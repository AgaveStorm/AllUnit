<?php

require_once "TBkSelectIdControl.php";

class TBkAjaxContainer extends TContainer {

	function OnCreateEvent($Sender) {
		/* add child controls here */
		$Sender->Enable();
		$Sender->AddChild(new TBkSelectIdControl());
	}

}
