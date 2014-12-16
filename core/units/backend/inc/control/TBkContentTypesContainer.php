<?php

require_once "TBkContentTypeListControl.php";
require_once 'TBkContentListControl.php';
require_once 'TBkContentEditControl.php';

class TBkContentTypesContainer extends TContainer {

	function OnCreateEvent($Sender) {
		$Sender->AddChild(new TBkContentTypeListControl());
		$Sender->AddChild(new TBkContentListControl());
		$Sender->AddChild(new TBkContentEditControl());
		$this->location = new TLocation($this, [TAu::MANAGE,"content"], true);
		if($this->location->current()) {
			$Sender->Enable();
		}
	}

	function OnGetEvent($Sender, $Input) {
		
	}

	function OnPostEvent($Sender, $Input) {
		
	}

}
