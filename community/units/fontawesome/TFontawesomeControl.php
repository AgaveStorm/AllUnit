<?php

class TFontawesomeControl extends TAuUnitContainer {

	function OnCreateEvent($Sender) {
		TCss::add(TAu::urlRelay($this->getUnitUrl().'/icons/css/font-awesome.min.css'));
	}
	
	function allowBackend() {
		return true;
	}

}
