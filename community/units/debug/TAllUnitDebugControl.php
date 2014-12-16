<?php

class TAllUnitDebugControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TCss::add(TAu::urlRelay('vihv/css/DebugControl.css'));
		TJs::add(TAu::urlRelay('vihv/js/ToggleVisibility.js'));
		TJs::add(TAu::urlRelay('vihv/js/DebugControl.js'));
	}
	
	function allowBackend() {
		return true;
	}
}
